<?php

namespace Models;

use App\Core\Model;
use App\Exceptions\AccessDeniedException;
use App\Exceptions\ResourceNotFound;
use Models\Role;
use App\Core\BDD;
use Models\OrganismesFormation;
use App\Exceptions\InternalServerError;
use PDO;

class User extends Model
{
    public string $nom;
    public string $prenom;
    public string $courriel;
    public string $password;
    public array $roles = [];
    protected ?int $idOrganismeFormation = NULL;

    // Propriété supplémentaire qui n'existe pas dans la table
    public ?OrganismesFormation $organismeFormation = NULL;

    /**
     * Fonction lancer par le models si elle existe
     *
     * @return void
     */
    protected function init(): void
    {
        if ($this->idOrganismeFormation != null) {
            $this->organismeFormation = new OrganismesFormation($this->idOrganismeFormation);
        }
        $this->getRoles();
    }

    /**
     * @var string Nom de la table MySQL hébergeant ce model
     */
    protected static $tableName = 'Comptes';
    /**
     * @var string nom de la colum de la primary key
     */
    protected static $primaryKey = 'idCompte';
    protected static $properties = [
        'nom' => ['isNoEmptyString', 'isLengthLessThan50'],
        'prenom' => ['isNoEmptyString', 'isLengthLessThan50'],
        'courriel' => ['isEmail', 'isLengthLessThan50'],
        'password' => ['isPasswordLengthValid'],
        'idOrganismeFormation' => []
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

        $sql = 'SELECT * FROM ' . User::$tableName;
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
            $obj = new User();
            $obj->id = $result[User::$primaryKey];
            $obj->init();
            foreach (User::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }

        return $results;
    }

    /**
     * {@inheritDoc}
     */
    public static function list($offset = 0, $limit = 10): array
    {
        $pdo = BDD::getInstance();
        // $sql = "SELECT * FROM " . $tableName . " LIMIT :limit, $offset ;";
        
        $requestResults = $pdo->query("SELECT * FROM " . User::$tableName . " LIMIT " . $offset . "," . $limit . ";")->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($requestResults as $result) {
            $obj = new User();
            $obj->id = $result[User::$primaryKey];
            $obj->init();
            foreach (User::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }
        return $results;
    }

    /**
     * Get the value of idOrganismeFormation
     * @return int
     */
    public function getIdOrganismeFormation(): int
    {
        return $this->idOrganismeFormation;
    }

    /**
     * Set the value of idOrganismeFormation
     * @param int $idOrganismeFormation
     */
    public function setIdOrganismeFormation($idOrganismeFormation): void
    {
        $this->idOrganismeFormation = $idOrganismeFormation;
    }

    /**
     * permet de verifier si l'utilisateur a acces a la page
     *
     * @param int $roleId permission requise
     * @return boolean
     */
    public function access(int $roleId): bool
    {
        foreach ($this->roles as $role) {
            if ($role->id == $roleId) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function getRoles(): void
    {
        try {
            $pdo = $this->getPDO();
            $sql = 'SELECT `idTypeCompte` FROM `Acces` WHERE `idCompte` = :id';
            $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([":id" => $this->id]);
        } catch (\Exception $e) {
            throw new InternalServerError("Impossible de récupérer les roles de l'utilisateur : " . $e->getMessage());
        }
        foreach ($sth->fetchAll() as $key => $value) {
            $this->roles[] = new Role($value['idTypeCompte']);
        }
    }

    public static function getWaitingUsers($limit = 0, $offset = 10): array
    {
        $primaryKey = User::$primaryKey;

        $pdo = BDD::getInstance();
        $ids = $pdo->query('SELECT * FROM `Comptes` WHERE `idCompte` NOT IN (SELECT DISTINCT `idCompte` FROM `Acces`) LIMIT ' . $limit . ',' . $offset . ';')->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($ids as $id) {
            $results[] = new User($id[$primaryKey]);
        }
        return $results;
    }

    public static function countWaitingUsers(): int
    {
        $pdo = BDD::getInstance();
        $count = $pdo->query('SELECT count(*) FROM `Comptes` WHERE `idCompte` NOT IN (SELECT DISTINCT `idCompte` FROM `Acces`)')->fetchColumn();

        return (int)$count;
    }


    public function addRole($roleId): void
    {
        $pdo = $this->getPDO();

        $sql = 'INSERT INTO `Acces` (`idCompte`, `idTypeCompte`) VALUES (:id, :roleId);';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $sth->execute([
            ":id" => $this->id,
            ":roleId" => $roleId
        ]);
    }

    public function deleteRole($roleId): void
    {
        $pdo = $this->getPDO();

        $sql = 'DELETE FROM `Acces` WHERE `Acces`.`idCompte` = :id AND `Acces`.`idTypeCompte` = :roleId';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $sth->execute([
            ":id" => $this->id,
            ":roleId" => $roleId
        ]);
    }

    public function addOrganisme($organismeId): void
    {
        $primaryKey = User::$primaryKey;

        $pdo = $this->getPDO();

        $sql = 'UPDATE `Comptes` SET `idOrganismeFormation` = :organismeId WHERE `' . $primaryKey . '` = :idCompte;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $sth->execute([
            ":idCompte" => $this->id,
            ":organismeId" => $organismeId
        ]);
    }

    public function toString(){
        return $this->nom . " " . $this->prenom;
    }

    /**
     * Récupère tout les calendriers d'un formateur
     * @return array
     */
    public function getAllCalendriersDisponibilite(): array{
        $pdo = $this->getPDO();
        $sql = 'SELECT * FROM `CalendriersDisponibilite` WHERE `idCompte` = :idCompte;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":idCompte" => $this->id]);

        $results = [];
        foreach ($sth->fetchAll() as $key => $value) {
            $results[] = new CalendriersDisponibilite($value['idCalendrierDisponibilite']);
        }
        return $results;
    }

    /**
     * Récupère tout les calendriers dont l'utilisateur est responsable
     * @return array
     */
    public function getCalendriers(): array{
        // On check si l'utilisateur est responsable
        $this->access(2);

        $year = "%" . date("Y") . "%";

        $pdo = $this->getPDO();
        $sql = 'SELECT DisposIntervenant.idCalendrierDisponibilite FROM `Comptes`
         INNER JOIN DisposIntervenant ON DisposIntervenant.idCompte = Comptes.idCompte
         INNER JOIN CalendriersDisponibilite ON CalendriersDisponibilite.idCalendrierDisponibilite = DisposIntervenant.idCalendrierDisponibilite
         WHERE Comptes.idCompte = :idCompte AND anneeScolCalendrierDisponibilite LIKE :year;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":idCompte" => $this->id, ":year" => $year]);

        $results = [];
        foreach ($sth->fetchAll() as $key => $value) {
            $results[] = new CalendriersDisponibilite($value['idCalendrierDisponibilite']);
        }
        return $results;
    }

    /**
     * Récupère la liste des responsables du calendrier de l'utilisateur
     * @return array
     */
    public function getUsersAccessToCalendar(): array{
        $pdo = $this->getPDO();

        $sql = 'SELECT DisposIntervenant.idCompte, DisposIntervenant.idCalendrierDisponibilite FROM `Comptes` 
        INNER JOIN DisposIntervenant ON DisposIntervenant.idCompte = Comptes.idCompte 
        INNER JOIN CalendriersDisponibilite ON CalendriersDisponibilite.idCalendrierDisponibilite = DisposIntervenant.idCalendrierDisponibilite 
        WHERE CalendriersDisponibilite.idCompte = :idCompte
        ORDER BY DisposIntervenant.idCompte;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":idCompte" => $this->id]);
        $results = [];
        foreach ($sth->fetchAll() as $key => $value) {
            $results[] = [
                'user' => new User($value['idCompte']),
                'calendrier' => new CalendriersDisponibilite($value['idCalendrierDisponibilite'])
            ];
        }
        return $results;
    }
    
    /**
     * Méthode qui ajoute l'accès d'un utilisateur au calendrier de l'utilisateur
     * @param int $calendarId
     * @param int $responsableId
     * @return bool
     */
    public function addAccessToCalendar(int $calendarId, int $responsableId): bool{
        $pdo = $this->getPDO();

        $sql = 'INSERT INTO `DisposIntervenant` (`idCalendrierDisponibilite`, `idCompte`) VALUES (:idCalendrierDisponibilite, :idCompte);';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $sth->execute([
                ":idCalendrierDisponibilite" => $calendarId,
                ":idCompte" => $responsableId
            ]);
            return TRUE;
        } catch (\PDOException $e) {
            return FALSE;
        }
    }

    /**
     * Méthode qui supprime l'accès d'un utilisateur au calendrier de l'utilisateur
     * @param int $calendarId
     * @param int $responsableId
     * @return void
     */
    public function removeAccessToCalendar(int $calendarId, int $responsableId): void{
        $pdo = $this->getPDO();

        $sql = 'DELETE FROM `DisposIntervenant` 
        WHERE idCalendrierDisponibilite = :idCalendrierDisponibilite AND idCompte = :idCompte;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $sth->execute([
            ":idCalendrierDisponibilite" => $calendarId,
            ":idCompte" => $responsableId
        ]);
        // Si rien n'a été supprimé
        if(empty($sth->rowCount())){
            throw new ResourceNotFound("L'accès n'existe pas");
        }
    }

    /**
     * Méthode qui vérifie si l'utilisateur a accès à la formation
     * Est utilisé dans le calendrier (vue responsable)
     * @param int $formationId
     * @return bool
     */
    public function hasAccessToFormation($formationId): bool{
        $pdo = $this->getPDO();
        $sql = 'SELECT Comptes.idCompte FROM Comptes
        INNER JOIN OrganismesFormation ON OrganismesFormation.idOrganismeFormation = Comptes.idOrganismeFormation
        INNER JOIN SitesOrgaFormation ON SitesOrgaFormation.idOrganismeFormation = OrganismesFormation.idOrganismeFormation
        INNER JOIN Formations ON Formations.idSiteOrgaFormation = SitesOrgaFormation.idSiteOrgaFormation
        WHERE Formations.idFormation = :idFormation AND Comptes.idCompte = :idCompte;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":idFormation" => $formationId, ":idCompte" => $this->id]);
        if (empty($sth->fetchAll())) {
            return FALSE;
        } 
        return TRUE;
    }


    /**
     * Méthode validation si le courriel est pas déjà présent dans la table User
     * @param $value
     * @return bool
     */
    public function isEmailUnique($courriel): bool
    {
        if ($this->courriel == $courriel || empty(User::selectBy(['courriel' => $courriel]))) {
            return TRUE;
        }
        return FALSE;
    }
}
