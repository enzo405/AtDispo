<?php

namespace Models;

use App\Core\Model;
use PDO;
use Models\NomsFormation;
use Models\SitesOrgaFormation;
use Models\OptionsFormation;
use App\Exceptions\InternalServerError;
use App\Core\BDD;

class Formations extends Model
{
    public string $dateDebutFormation;
    public string $dateFinFormation;
    private array $optionsFormation = [];
    protected int $idNomFormation;
    protected int $idSiteOrgaFormation;

    // Propriétés supplémentaire qui n'existe pas dans la table
    public NomsFormation $nomFormation;
    public SitesOrgaFormation $siteOrgaFormation;

    protected function init(): void
    {
        $this->nomFormation = new NomsFormation($this->idNomFormation);
        $this->siteOrgaFormation = new SitesOrgaFormation($this->idSiteOrgaFormation);
    }

    protected static $tableName = 'Formations';
    protected static $primaryKey = 'idFormation';
    protected static $properties = [
        'dateDebutFormation' => ["isDate"],
        'dateFinFormation' => ["isDate"],
        "idNomFormation" => [],
        "idSiteOrgaFormation" => []
    ];


    /**
     * {@inheritDoc}
     */
    static public function selectBy(array $param, $offset = null, $limit = 10)
    {
        if (empty($param)) {
            throw new \Exception('Le paramètre doit contenir au moins une clé => valeur');
        }

        $pdo = BDD::getInstance();

        $sql = 'SELECT * FROM ' . Formations::$tableName;
        $conditions = array();
        foreach ($param as $fieldName => $value) {
            $conditions[] = '`' . $fieldName . "` = :" . $fieldName;
        }
        $sql .= " WHERE " . implode(' AND ', $conditions);
        if(isset($offset)){
            $sql .= " LIMIT " . $offset . ',' . $limit . ';';
        };
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $executeValue = [];
        foreach ($param as $fieldName => $value) {
            $executeValue[":" . $fieldName] = $value;
        }

        $sth->execute($executeValue);

        $requestResults = $sth->fetchAll();

        $results = [];
        
        foreach ($requestResults as $result) {
            $obj = new Formations();
            $obj->id = $result[Formations::$primaryKey];
            $obj->init();
            foreach (Formations::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }

        return $results;
    }


    /**
     * Get the value of idNomFormation
     * @return int
     */
    public function getIdNomFormation():int{
        return $this->idNomFormation;
    }

    /**
     * Set the value of idNomFormation
     * @param int $idNomFormation
     */
    public function setIdNomFormation($idNomFormation): void{
        $this->idNomFormation = $idNomFormation;
    }

    /**
     * Get the value of idSiteOrgaFormation
     * @return int
     */
    public function getIdSiteOrgaFormation():int{
        return $this->idSiteOrgaFormation;
    }

    /**
     * Set the value of idSiteOrgaFormation
     * @param int $idSiteOrgaFormation
     */
    public function setIdSiteOrgaFormation($idSiteOrgaFormation): void{
        $this->idSiteOrgaFormation = $idSiteOrgaFormation;
    }

    /**
     * Méthode qui récupère les options d'une formations dans la base de donnée
     * @return void
     */
    protected function syncOptions()
    {
        try {
            $pdo = $this->getPDO();
            $sql = 'SELECT `idOptionFormation` FROM `ProposeOption` WHERE `idFormation` = :id';
            $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([":id" => $this->id]);
        } catch (\PDOException $e) {
            throw new InternalServerError("Impossible de récupérer les options de la formation : " . $e->getMessage());
        }
        $this->optionsFormation = []; // reset des options
        foreach ($sth->fetchAll() as $key => $value) {
            $this->optionsFormation[] = new OptionsFormation($value['idOptionFormation']);
        }
    }

    /**
     * Méthode qui récupère les options d'une formations
     * @return array Ajoute toutes les options de la formation dans la propriété
     */
    public function getOptionsFormation(): array
    {
        if (count($this->optionsFormation) > 0) {
            // TODO faire un count de la table et comparer la taille avec le nombre d'option 
            return $this->optionsFormation;
        }
        $this->syncOptions();
        return $this->optionsFormation;
    }

    /**
     * Méthode qui récupère les formations d'un organisme
     * @param int $idOrganisme
     * @return array
     */
    public static function getFormationsByOrgaFormation(int $idOrganisme, $offset = null, $limit = 10): array
    {
        $pdo = BDD::getInstance();
        $sql = 'SELECT Formations.*, NF.*, Sites.* FROM Formations
        INNER JOIN SitesOrgaFormation ON SitesOrgaFormation.idSiteOrgaFormation = Formations.idSiteOrgaFormation
        INNER JOIN OrganismesFormation ON SitesOrgaFormation.idOrganismeFormation = OrganismesFormation.idOrganismeFormation
        INNER JOIN NomsFormation NF on Formations.idNomFormation = NF.idNomFormation
        INNER JOIN SitesOrgaFormation Sites ON Formations.idSiteOrgaFormation = Sites.idSiteOrgaFormation
        WHERE OrganismesFormation.idOrganismeFormation = :id';
        if(isset($offset)){
            $sql .= ' LIMIT ' . $offset . ',' . $limit . ';';
        }
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":id" => $idOrganisme]);

        $results = [];
        foreach ($sth->fetchAll() as $key => $value) {
            $results[] = Formations::createWithoutDB($value);
        }
        return $results;
    }

    /**
     * Méthode qui récupère les formations d'un organisme
     * @param int $idOrganisme
     * @return array
     */
    public static function countFormationsByOrgaFormation(int $idOrganisme): int
    {
        $pdo = BDD::getInstance();
        $sql = 'SELECT count(*) FROM Formations
        INNER JOIN SitesOrgaFormation ON SitesOrgaFormation.idSiteOrgaFormation = Formations.idSiteOrgaFormation
        INNER JOIN OrganismesFormation ON SitesOrgaFormation.idOrganismeFormation = OrganismesFormation.idOrganismeFormation
        INNER JOIN NomsFormation NF on Formations.idNomFormation = NF.idNomFormation
        INNER JOIN SitesOrgaFormation Sites ON Formations.idSiteOrgaFormation = Sites.idSiteOrgaFormation
        WHERE OrganismesFormation.idOrganismeFormation = :id';
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":id" => $idOrganisme]);

        $results = $sth->fetchColumn();

        return (int)$results;
    }

    /**
     * {@inheritDoc}
     */
    public static function list($offset = 0, $limit = 10): array
    {
        $pdo = BDD::getInstance();
        $sql = 'SELECT Formations.*, NF.*, Sites.* FROM Formations
        INNER JOIN SitesOrgaFormation ON SitesOrgaFormation.idSiteOrgaFormation = Formations.idSiteOrgaFormation
        INNER JOIN OrganismesFormation ON SitesOrgaFormation.idOrganismeFormation = OrganismesFormation.idOrganismeFormation
        INNER JOIN NomsFormation NF on Formations.idNomFormation = NF.idNomFormation
        INNER JOIN SitesOrgaFormation Sites ON Formations.idSiteOrgaFormation = Sites.idSiteOrgaFormation ' . " LIMIT " . $offset . "," . $limit . ";";
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute();

        $results = [];
        foreach ($sth->fetchAll() as $key => $value) {
            $results[] = Formations::createWithoutDB($value);
        }
        return $results;
    }

    /**
     * Méthode qui sauvegarde l'option d'une formation dans la table associé (en l'ocurence ProposeOption)
     * @param array $optionFormations Tableau d'optionFormation
     * @return void
     */
    public function saveOption(array $optionsFormation): void
    {
        $this->syncOptions();
        $valuesAdd[":idFormation"] = $this->id;
        $valuesRemove[":idFormation"] = $this->id;
        $idsAdd = [];
        $idsDelete = [];
        // Si on veux ajouter l'option
        foreach ($optionsFormation as $keys => $optionFormation) {
            if (!in_array($optionFormation, $this->optionsFormation)){ // On vérifie que l'option n'est pas déjà dans la liste d'option de la formation
                $idsAdd[] = "(:idFormation, :idOptionFormation_$keys)"; // On prépare le string qui sera utilisé dans le query de la requête
                $valuesAdd[":idOptionFormation_$keys"] = $optionFormation->id; // On ajoute dans le tableau le placeholder et la valeur qui sera utilisé dans le query de la requête
            }
        }
        // Si on veux supprimer l'option
        foreach ($this->optionsFormation as $key => $optionFormation) {
            if (!in_array($optionFormation, $optionsFormation)) {
                $idsDelete[] = ":idOptionFormation_$key";
                $valuesRemove[":idOptionFormation_$key"] = $optionFormation->id;
            }
        }

        $pdo = $this->getPDO();
        if (!empty($idsAdd)) {
            $sqlAdd = 'INSERT INTO `ProposeOption`(`idFormation`, `idOptionFormation`) VALUES ' . implode(", ", $idsAdd) . ";";
            $sthAdd = $pdo->prepare($sqlAdd, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sthAdd->execute($valuesAdd);
        }

        if (!empty($idsDelete)) {
            $sqlRemove = 'DELETE FROM `ProposeOption` WHERE `idOptionFormation` IN (' . implode(", ", $idsDelete) . ') AND `idFormation` = :idFormation';
            $sthRemove = $pdo->prepare($sqlRemove, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sthRemove->execute($valuesRemove);
        }
    }

    /**
     * Méthode d'instanciation d'une formation sans la database
     * @return Formations
     */
    public static function createWithoutDB(array $value): Formations
    {
        $formation = new Formations();
        $formation->id = $value['idFormation'];
        $formation->dateDebutFormation = $value['dateDebutFormation'];
        $formation->dateFinFormation = $value['dateFinFormation'];
        $formation->idNomFormation = $value['idNomFormation'];
        $formation->idSiteOrgaFormation = $value['idSiteOrgaFormation'];
        $nomFormation = new NomsFormation();
        $nomFormation->id = $value['idNomFormation'];
        $nomFormation->libelleNomFormation = $value['libelleNomFormation'];
        $formation->nomFormation = $nomFormation;
        $siteOrgaFormation = new SitesOrgaFormation();
        $siteOrgaFormation->id = $value['idSiteOrgaFormation'];
        $siteOrgaFormation->nomSiteOrgaFormation = $value['nomSiteOrgaFormation'];
        $siteOrgaFormation->adresse = $value['adresse'];
        $siteOrgaFormation->codePostal = $value['codePostal'];
        $siteOrgaFormation->ville = $value['ville'];
        $siteOrgaFormation->setIdOrganismeFormation($value['idOrganismeFormation']);
        $formation->siteOrgaFormation = $siteOrgaFormation;
        return $formation;
    }

    /**
     * Méthode qui renvoie le nom de la formation et le site de formation
     * @return string
     */
    public function toString($withDate = FALSE): string{
        if ($withDate){
            return $this->nomFormation->libelleNomFormation . " " . $this->siteOrgaFormation->nomSiteOrgaFormation . " du " . $this->dateDebutFormation . " au " . $this->dateFinFormation;
        }
        return $this->nomFormation->libelleNomFormation . " " . $this->siteOrgaFormation->nomSiteOrgaFormation;
    }
}
