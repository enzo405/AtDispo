<?php

namespace App\Core;

use App\Core\Mail\AttachmentType;

/**
 * Class Mailler (only SMTP)
 * @package App\Core
 */
class Mailer
{
    private array $to = [];

    private string $subject;

    private ?string $htmlBody;

    private ?string $textBody;

    private array $attachments = [];

    private string $boundary;

    private array $headers = [
        'From' => "no-reply@at-dispo.fr",
        'MIME-Version' => '1.0'
    ];

    /**
     * Instancied Mailler
     * 
     * @param array $to
     * @param string $subject
     * @param string|null $message
     * message in html format
     * @param array|null $headers
     * list of headers 
     */
    public function __construct(array $to, string $subject, string $textBody = null, array $headers = [])
    {
        // générer boundary
        $this->boundary = md5(uniqid(microtime(), TRUE));
        $this->headers['Content-Type'] = 'multipart/mixed;boundary=' . $this->boundary;
        $this->to = $to;
        $this->subject = $subject;
        $this->textBody = $textBody;
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Adding header to mail
     *
     * @param string $key
     *   Key of header.
     * @param string $value
     *   Value of header.
     * @return void
     */
    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = htmlspecialchars($value);
    }

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Change headers
     *
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function addTemplate(string $templatePath, array $data): void
    {
        ob_start();
        extract($data);
        include dirname(__FILE__) . '/../../../templates/' . $templatePath . '.tpl.php';
        $this->htmlBody = ob_get_clean();
    }

    /**
     * Build body of mail
     *
     * @return string
     */
    private function buildBody(): string
    {
        $body = '';
        // générer message
        if (isset($this->textBody)) {
            $body .= '--' . $this->boundary . "\r\n";
            $body .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
            $body .= "Content-Transfer-Encoding: 8bit \r\n\r\n\r\n";
            $body .= wordwrap($this->textBody, 70, "\n") . "\r\n";
        }

        // générer message html
        if (isset($this->htmlBody)) {
            $body .= '--' . $this->boundary . "\r\n";
            $body .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
            $body .= "Content-Transfer-Encoding: 8bit \r\n\r\n\r\n";
            $body .= wordwrap($this->htmlBody, 70, "\n") . "\r\n";
        }
        // générater Attachement
        foreach ($this->attachments as $attachment) {
            $body .= '--' . $this->boundary . "\r\n";
            switch ($attachment['type']) {
                case AttachmentType::PDF:
                    $body .= 'Content-Type: application/pdf; name="' . $attachment['name'] . '"' . "\r\n";
                    break;

                case AttachmentType::PNG:
                    $body .= 'Content-Type: image/png; name="' . $attachment['name'] . '"' . "\r\n";
                    break;

                case AttachmentType::JPG:
                    $body .= 'Content-Type: image/jpg; name="' . $attachment['name'] . '"' . "\r\n";
                    break;

                default:
                    throw new \Exception('Type of attachment not found');
            }
            $body .= 'Content-Disposition: attachment; filename="' . $attachment['name'] . '"' . "\r\n";
            $body .= 'Content-Transfer-Encoding: base64' . "\r\n";
            $body .= "\r\n";
            if (isset($attachment['path'])) {
                $body .= chunk_split(base64_encode(file_get_contents($attachment['path'])));
            } elseif (isset($attachment['base64'])) {
                $body .= $attachment['base64'];
            } else {
                throw new \Exception('Type of attachment passed to body not found');
            }
            $body .= "\r\n";
        }
        $body .= '--' . $this->boundary . '--';
        return $body;
    }

    /**
     * Add attachment to mail
     *
     * @param string $pathFile
     *  Path of attachment (project/public/dede.png).
     * @param string $name
     *   Name of attachment (dede.png).
     * @param string $type
     * @return void
     */
    public function addAttachment(string $pathFile, string $name, AttachmentType $type): void
    {
        if (!file_exists(__DIR__ . "/../../../public/" . $pathFile)) {
            throw new \Exception('File not found - ' . __DIR__ . "/../../../public/" . $pathFile . '');
        }
        $this->attachments[] = [
            'path' => $pathFile,
            'name' => $name,
            'type' => $type
        ];
    }

    /**
     * Add base64 attachment to mail
     *
     * @param string $base64
     *  Base 64 string
     * @param string $name
     *  Name of attachment.
     * @param string $type
     * @return void
     */
    public function addAttachmentBase64(string $base64, string $name, AttachmentType $type): void
    {
        $this->attachments[] = [
            'base64' => $base64,
            'name' => $name,
            'type' => $type
        ];
    }

    /**
     * Validate attachments file exist
     *
     * @param string $pathFile
     * @return bool
     */
    public static function validateAttachmentsFile(string $pathFile): bool
    {
        if (!file_exists(__DIR__ . "/../../../public/" . $pathFile)) {
            return false;
        }
        return true;
    }

    /**
     * Get attachments
     *
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * Build headers of mail
     * 
     * @return string
     */
    private function buildHeaders(): string
    {
        $headers = '';
        foreach ($this->headers as $key => $value) {
            $headers .= $key . ': ' . $value . "\r\n";
        }
        $headers .= "\r\n";
        return $headers;
    }

    /**
     * Set destination.
     *
     * @param array $to
     * @return void
     */
    public function setTo(array $to): void
    {
        $this->to = $to;
    }

    /**
     * Get destination.
     *
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * Send mail and return true if success
     *
     * @return mixed
     */
    public function send(): mixed
    {
        try {
            $body = $this->buildBody();
            $headers = $this->buildHeaders();

            // send mail
            $successful = 0;
            foreach ($this->to as $to) {
                if (mail($to, $this->subject, $body, $headers)) {
                    $successful++;
                }
            }

            if ($successful === count($this->to)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
