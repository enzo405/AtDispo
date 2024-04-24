<?php

namespace Models;

use PDO;
use App\Core\BDD;
use App\Core\Model;
use Models\CalendriersDisponibilite;
use Models\EtatsDisponibilite;
use Models\Formations;
use Models\Matieres;
use Models\TypesCreneau;

class CreneauDisponibilite extends Model
{
    public string $dateCreneauDisponibilite;
    protected ?int $idMatiere = NULL;
    protected ?int $idFormation = NULL;
    protected int $idCalendrierDisponibilite;
    protected int $idEtatDisponibilite;
    protected int $idTypeCreneau;

    // Propriétés supplémentaire qui n'existe pas dans la table
    private ?Matieres $matiere = NULL; // lazy
    private Formations $formation; // eager
    public CalendriersDisponibilite $calendrierDisponibilite; // eager
    public EtatsDisponibilite $etatDisponibilite; // lazy
    public TypesCreneau $typeCreneau;

    protected function init(): void
    {
        $this->typeCreneau = new TypesCreneau($this->idTypeCreneau);
        $this->etatDisponibilite = new EtatsDisponibilite($this->idEtatDisponibilite);
    }

    protected static $tableName = 'CreneauDisponibilite';
    protected static $primaryKey = 'idCreneauDisponibilite';
    protected static $properties = [
        'dateCreneauDisponibilite' => ["isDate"],
        'idMatiere' => [],
        'idFormation' => [],
        'idCalendrierDisponibilite' => [],
        'idEtatDisponibilite' => [],
        'idTypeCreneau' => []
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

        $sql = 'SELECT * FROM ' . CreneauDisponibilite::$tableName;
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
            $obj = new CreneauDisponibilite();
            $obj->id = $result[CreneauDisponibilite::$primaryKey];
            $obj->init();
            foreach (CreneauDisponibilite::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     */
    public static function list($limit = 0, $offset = 10): array
    {
        $pdo = BDD::getInstance();
        // $sql = "SELECT * FROM " . $tableName . " LIMIT :limit, $offset ;";
        
        $requestResults = $pdo->query("SELECT * FROM " . CreneauDisponibilite::$tableName . " LIMIT " . $limit . "," . $offset . ";")->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($requestResults as $result) {
            $obj = new CreneauDisponibilite();
            $obj->id = $result[CreneauDisponibilite::$primaryKey];
            $obj->init();
            foreach (CreneauDisponibilite::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }
        return $results;
    }


    /**
     * Get the value of matiere
     *
     * @return Matieres|null
     */
    public function getMatiere(): ?Matieres{
        if($this->matiere == null) {
            $this->matiere = new Matieres($this->idMatiere);
        }
        return $this->matiere;
    }

    /**
     * Get the CalendriersDisponibilite
     */
    public function getCalendrierDisponibilite(): CalendriersDisponibilite{
        if(!isset($this->calendrierDisponibilite)) {
            $this->calendrierDisponibilite = new CalendriersDisponibilite($this->idCalendrierDisponibilite);
        }
        return $this->calendrierDisponibilite;
    }

    /**
     * Get the value of idMatiere
     * @return string
     */
    public function getIdMatiere(): ?int{
        return $this->idMatiere;
    }

    /**
     * Set the value of idMatiere
     * @param ?int $idMatiere
     */
    public function setIdMatiere(?int $idMatiere): void{
        $this->idMatiere = $idMatiere;
    }

    /**
     * Get the value of idFormation
     * @return int
     */
    public function getIdFormation(): ?int{
        return $this->idFormation;
    }

    public function getFormation(): Formations{
        if(!isset($this->formation)) {
            $this->formation = new Formations($this->idFormation);
        }
        return $this->formation;
    }

    /**
     * Set the value of idFormation
     * @param ?int $idFormation
     */
    public function setIdFormation(?int $idFormation): void{
        $this->idFormation = $idFormation;
    }

    /**
     * Get the value of idCalendrierDisponibilite
     * @return int
     */
    public function getIdCalendrierDisponibilite(): int{
        return $this->idCalendrierDisponibilite;
    }

    /**
     * Set the value of idCalendrierDisponibilite
     * @param int $idCalendrierDisponibilite
     */
    public function setIdCalendrierDisponibilite($idCalendrierDisponibilite): void{
        $this->idCalendrierDisponibilite = $idCalendrierDisponibilite;
    }

    /**
     * Get the value of idEtatDisponibilite
     * @return int
     */
    public function getIdEtatDisponibilite(): int{
        return $this->idEtatDisponibilite;
    }

    /**
     * Set the value of idEtatDisponibilite
     * @param int $idEtatDisponibilite
     */
    public function setIdEtatDisponibilite($idEtatDisponibilite): void{
        $this->idEtatDisponibilite = $idEtatDisponibilite;
    }

    /**
     * Get the value of idTypeCreneau
     * @return int
     */
    public function getIdTypeCreneau(): int{
        return $this->idTypeCreneau;
    }

    /**
     * Set the value of idTypeCreneau
     * @param int $idTypeCreneau
     */
    public function setIdTypeCreneau($idTypeCreneau): void{
        $this->idTypeCreneau = $idTypeCreneau;
    }

    /**
     * Retourne un string qui représente le créneau
     * @return string
     */
    public function toString(): string{
        return $this->dateCreneauDisponibilite . " - " . $this->typeCreneau->libelleTypeCreneau;
    }

    /**
     * Renvoie vrai si le créneau est disponible
     * @return bool
     */
    public function isDisponible(): bool{
        return $this->idEtatDisponibilite == EtatsDisponibilite::$disponibleID;
    }

    /**
     * Renvoie vrai si le créneau est en attente
     * @return bool
     */
    public function isEnAttente(): bool{
        return $this->idEtatDisponibilite == EtatsDisponibilite::$enAttenteID;
    }

}
