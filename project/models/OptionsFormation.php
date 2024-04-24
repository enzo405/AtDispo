<?php

namespace Models;

use PDO;
use App\Core\Model;
use App\Exceptions\ResourceNotFound;
use Models\NomsFormation;
use Models\Formations;

class OptionsFormation extends Model
{
    public string $libelleNomOptionFormation;
    public int $valide = 0;
    protected int $idNomFormation;

    // Propriété supplémentaire qui n'existe pas dans la table
    private NomsFormation $nomFormation;

    protected static $tableName = 'OptionsFormation';
    protected static $primaryKey = 'idOptionFormation';
    protected static $properties = [
        'libelleNomOptionFormation' => ["isNoEmptyString", "isLengthLessThan20"],
        'valide' => [],
        'idNomFormation' => []
    ];

    /**
     * Méthode qui sauvegarde l'option d'une formation dans la table associé
     * Permet de sauvegardé l'option et de l'associer à une formation
     * @param int $idFormation
     * @return void
     */
    public function saveOptionFormation(int $idFormation): void
    {
        parent::save(); // d'abord on enregistre l'option puis ensuite une fois qu'il est instancier dans la BDD on peut l'associer à la formation

        $formation = new Formations($idFormation);

        if (!in_array($this->id, $formation->getOptionsFormation())){ // On vérifie que l'option n'est pas déjà dans la liste d'option de la formation
            $pdo = $this->getPDO();
            $sql = 'INSERT INTO `ProposeOption`(`idFormation`, `idOptionFormation`) VALUES (:idFormation, :idOptionFormation)';
            $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([":idFormation" => $idFormation, ":idOptionFormation" => $this->id]);
        }
    }

    /**
     * Get the value of idNomFormation
     * @return int
     */
    public function getIdNomFormation(): int
    {
        return $this->idNomFormation;
    }

    /**
     * Set the value of idNomFormation
     * @param int $idNomFormation
     */
    public function setIdNomFormation($idNomFormation): void
    {
        $this->idNomFormation = $idNomFormation;
    }

    /**
     * Méthode qui récupère le nom de la formation
     * @return NomsFormation
     */
    public function getNomFormation(): NomsFormation
    {
        if (!isset($this->nomFormation)) {
            $this->nomFormation = new NomsFormation($this->idNomFormation);
        }
        return $this->nomFormation;
    }
}
