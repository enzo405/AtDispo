<?php

namespace Models;

use App\Core\Model;
use App\Exceptions\ResourceNotFound;
use Models\TypesFermeture;
use Models\NomsFermeture;


class Fermeture extends Model
{
    public string $dateDebut;
    public string $dateFin;
    protected int $idTypeFermeture;
    protected int $idNomFermeture;

    // Propriétés supplémentaire qui n'existe pas dans la table
    private TypesFermeture $typeFermeture;
    private NomsFermeture $nomFermeture;

    protected static $tableName = 'Fermeture';
    protected static $primaryKey = 'idFermeture';
    protected static $properties = [
        'dateDebut' => ["isDate"],
        'dateFin' => ["isDate"],
        'idTypeFermeture' => [],
        'idNomFermeture' => []
    ];

    public function getTypeFermeture() {
        if (!isset($this->typeFermeture)) {
            $this->typeFermeture = new TypesFermeture($this->idTypeFermeture);
        }
        return $this->typeFermeture;
    }

    public function getNomFermeture() {
        if (!isset($this->nomFermeture)) {
            $this->nomFermeture = new NomsFermeture($this->idNomFermeture);
        }
        return $this->nomFermeture;
    }

    /**
     * Get the value of idTypeFermeture
     * @return string
     */
    public function getIdTypeFermeture(): int{
        return $this->idTypeFermeture;
    }

    /**
     * Set the value of idTypeFermeture
     * @param int $idTypeFermeture
     */
    public function setIdTypeFermeture(int $idTypeFermeture): void {
        $this->idTypeFermeture = $idTypeFermeture;
    }

    /**
     * Get the value of idNomFermeture
     * @return int
     */
    public function getIdNomFermeture(): int {
        return $this->idNomFermeture;
    }

    /**
     * Set the value of idNomFermeture
     * @param int $idNomFermeture
     */
    public function setIdNomFermeture(int $idNomFermeture): void {
        $this->idNomFermeture = $idNomFermeture;
    }

}
