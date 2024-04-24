<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\User;
use Models\TokenForgetPassword;
use App\Exceptions\ResourceNotFound;
use App\Core\Mailer;

/**
 * Class AuthentificationController
 * @package App\Controllers
 */
class AuthentificationController extends Controller
{
    /**
     * Fonction de login
     *
     * @return void
     */
    public function login(): void
    {
        $this->notLogin();
        $get = HTTP_REQUEST->getGetParams();

        $this->getView('auths/login', ['errorMessage' => $get["errorMessage"] ?? NULL], 'commun')->addCSS("auths.css")->render();
    }

    /**
     * Traitement de la demande de connexion
     *
     * @return void
     */
    public function loginPost(): void
    {
        $this->notLogin();
        $post = HTTP_REQUEST->getPostParams();

        if (empty($post['courriel']) && empty($post['password'])) {
            $this->redirect('/login?errorMessage=Veuillez remplir les champs');
        }

        $users = User::selectBy(['courriel' => $post['courriel']]);

        if (empty($users)) {
            $this->redirect('/login?errorMessage=Impossible de se connecter');
        }

        $user = $users[0];

        if (!password_verify($post['password'], $user->password)) {
            $this->redirect('/login?errorMessage=Impossible de se connecter');
        }

        if (count($user->roles) == 0) {
            $this->redirect('/login?errorMessage=Votre Compte n\'est pas encore validé');
        }

        $_SESSION['userID'] = $user->id;
        if (isset($_SESSION['redirect_after_login'])) {
            $this->redirect($_SESSION['redirect_after_login']);
        } else {
            $this->redirect("/");
        }
    }

    /**
     * Affiche la page d'inscription
     *
     * @return void
     */
    public function register(): void
    {
        $this->notLogin();
        $get = HTTP_REQUEST->getGetParams();

        $this->getView('auths/register', ['errorMessage' => $get["errorMessage"] ?? NULL], 'commun')->addCSS("auths.css")->render();
    }

    /**
     * Traitement de la demande d'inscription
     *
     * @return void
     */
    public function registerPost()
    {
        $this->notLogin();
        $post = HTTP_REQUEST->getPostParams();
        $post['nom'] = trim($post['nom']);
        $post['prenom'] = trim($post['prenom']);
        $post['courriel'] = trim($post['courriel']);
        $post['psw'] = trim($post['psw']);

        if ($post['psw'] != $post['confirm-psw']) {
            $this->redirect('/register?errorMessage=Vous avez mal confirmé votre mot de passe');
        }

        $users = User::selectBy(['courriel' => $post['courriel']]);
        if (!empty($users)) {
            $this->redirect('/register?errorMessage=Une erreur est survenue lors de la création de votre compte');
        }
        
        $user = new User();
        $user->nom = $post['nom'];
        $user->prenom = $post['prenom'];
        $user->courriel = $post['courriel'];
        $user->password = $post['psw'];
        $errors = $user->validate();

        if (empty($errors)) {
            $user->password = password_hash($post['psw'], PASSWORD_DEFAULT);
            $user->save();
            
            $to[] = $user->courriel;
            $subject = "Création de votre compte At-Dispo";
            $mail = new Mailer($to, $subject);
            $mail->addTemplate('mail/compteCree', ['compte' => $user]);
            $mail->addHeader("X-Mailer", 'PHP\\' . phpversion());
            $mail->send();

            $this->redirect('/login');
        } else {
            $firstError = array_shift($errors)[0][1];
            $this->redirect("/register?errorMessage=$firstError");
        }
    }

    /**
     * Déconnexion
     *
     * @return void
     */
    public function logout(): void
    {
        $this->needLogin();
        session_destroy();
        $this->redirect('/login');
    }

    public function passwordForget()
    {
        // Ici on prend en compte qu'un user peut être soit connecté soit non connecté
        $get = HTTP_REQUEST->getGetParams();
        $this->getView('auths/passwordForget', ['errorMessage' => $get["errorMessage"] ?? NULL, "message" => $get['message'] ?? null], 'commun')->addCSS("auths.css")->render();
    }

    public function passwordForgetPost()
    {
        // Ici on prend en compte qu'un user peut être soit connecté soit non connecté
        $post = HTTP_REQUEST->getPostParams();
        $email = trim($post['email']);

        // On vérifie si l'utilisateur avec le courriel du post existe
        $userWithEmail = User::selectBy(["courriel" => $email]);
      
        if (!empty($userWithEmail)) {
            $user = $userWithEmail[0];
            
            // Création du token pour la réinitialisation du mot de passe
            $tokenForgetPassword = new TokenForgetPassword();
            $tokenForgetPassword->validationDate = time();
            $tokenForgetPassword->setIdUser($user->id);
            $tokenForgetPassword->generateToken($user->courriel); // Assigne le token directement à la propriété token
            $tokenForgetPassword->save();

            // Envoi du mail
            
            $to[] = $user->courriel;
            $subject = "Réinitialisation de mot de passe";

            $mail = new Mailer($to, $subject);
            $mail->addTemplate('mail/mdpOublie', [
                'compte' => $user, 
                'urlReinitialisation' => "/passwordChange/{$tokenForgetPassword->token}"
            ]);
            $mail->send();
        }
        // Redirection vers la même page, que l'adresse email existe ou non
        $this->redirect("/passwordForget?message=Si votre adresse e-mail existe, vous avez reçu un e-mail contenant un lien pour changer votre mot de passe.");
    }


    public function passwordChange(string $token)
    {
        // On ne gère pas le cas où le string n'existe pas car sinon l'utilisateur pourrait savoir si un email existe ou non
        // Ici on prend en compte qu'un user peut être soit connecté soit non connecté
        $get = HTTP_REQUEST->getGetParams();
        $this->getView('auths/passwordForgetChange', ['token' => $token, 'errorMessage' => $get["errorMessage"] ?? NULL], 'commun')->addCSS("auths.css")->render();
    }

    public function passwordChangePost(string $token)
    {
        // Ici on prend en compte qu'un user peut être soit connecté soit non connecté
        $post = HTTP_REQUEST->getPostParams();

        $tokens = TokenForgetPassword::selectBy(["token" => $token]);
        $userToken = $tokens[0] ?? NULL;
        
        // On vérifie si le token existe et qu'il n'a pas expiré (1 heure d'expiration)
        if (empty($tokens) || $userToken->validationDate < strtotime("-1 hour")){
            throw new ResourceNotFound("Le token n'existe pas ou a expiré.");
        }

        if (isset($post['newPassword']) && isset($post['confirmNewPassword'])){
            $newPassword = $post['newPassword'];
            $confirmNewPassword = $post['confirmNewPassword'];
            if ($newPassword != $confirmNewPassword) {
                $this->redirect("/passwordChange/$token?errorMessage=Les mots de passe ne correspondent pas.");
            } else {
                if (strlen($newPassword) < 8) {
                    $this->redirect("/passwordChange/$token?errorMessage=Le mot de passe doit contenir au moins 8 caractères.");
                } else {
                    $user = new User($userToken->getIdUser());
                    $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
                    $user->save();
                    $userToken->delete();

                    $mail = new Mailer([$user->courriel], "Mot de passe modifié");
                    $mail->addTemplate('mail/mdpModifie', [
                        'compte' => $user
                    ]);
                    $mail->send();

                    $this->redirect('/login');
                }
            }
        }
        $this->redirect("/passwordChange/{$token}?errorMessage=Veuillez remplir tous les champs.");
    }
}
