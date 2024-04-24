<?php

namespace Models;

use App\Core\Model;
use App\Exceptions\ResourceNotFound;
use Models\AffichagesTypesFermeture;

class TypesFermeture extends Model
{
    public string $libelleTypeFermeture;
    public string $couleurTypeFermeture;
    protected int $idAffichageTypeFermeture;

    // Propriété supplémentaire qui n'existe pas dans la table
    public AffichagesTypesFermeture $affichageTypeFermeture;

    protected function init(): void
    {
    }

    protected static $tableName = 'TypesFermeture';
    protected static $primaryKey = 'idTypeFermeture';
    protected static $properties = [
        'libelleTypeFermeture' => ["isNoEmptyString", "isLengthLessThan50"],
        'couleurTypeFermeture' => ["isHexColor"],
        'idAffichageTypeFermeture' => []
    ];

    /**
     * Get the value of idAffichageTypeFermeture
     * @return int
     */
    public function getIdAffichageTypeFermeture(): int
    {
        return $this->idAffichageTypeFermeture;
    }

    /**
     * Set the value of idAffichageTypeFermeture
     * @param int $idAffichageTypeFermeture
     */
    public function setIdAffichageTypeFermeture($idAffichageTypeFermeture): void
    {
        $this->idAffichageTypeFermeture = $idAffichageTypeFermeture;
    }

    // $this->affichageTypeFermeture = new AffichagesTypesFermeture($this->idAffichageTypeFermeture);

    /**
     * Get the value of affichageTypeFermeture
     * @return AffichagesTypesFermeture
     */
    public function getAffichageTypeFermeture(): AffichagesTypesFermeture
    {
        if ($this->affichageTypeFermeture == null) {
            $this->affichageTypeFermeture = new AffichagesTypesFermeture($this->idAffichageTypeFermeture);
        }
        return $this->affichageTypeFermeture;

    }

}
