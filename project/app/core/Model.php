<?php

namespace App\Core;

use App\Core\BDD;
use App\Core\Validator;
use App\Exceptions\InternalServerError;
use App\Exceptions\ResourceNotFound;
use PDO;

abstract class Model
{
    /**
     * @var int|null
     */
    public ?int $id;

    private string $primaryKey = 'id';

    private ?PDO $pdo;

    /**
     * @var int id de l'items selectionnée
     */
    public function __construct(int $id = null)
    {
        $this->id = $id;
        $this->pdo = BDD::getInstance(); // Peut rejeter une PDOException

        $this->preInit(); // Permet d'initialiser des variables avant l'initialisation de l'objet

        if ($id !== null) {
            $className = get_called_class();
            $tableName = $className::$tableName;
            $primaryKey = $className::$primaryKey;

            $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $primaryKey . '  = :id';
            $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([":id" => $id]);
            $result = $sth->fetch();
            if (!$result) {
                throw new ResourceNotFound("L'item avec l'id " . $id . " n'existe pas dans la table " . $tableName);
            }
            $this->id = $result[$primaryKey];
            foreach ($className::$properties as $property => $validationRules) {
                $this->$property = $result[$property];
            }

            $this->init(); // Permet d'initialiser des variables après l'initialisation de l'objet
        }
    }

    /**
     * init function
     *
     * @return void
     */
    protected function init(): void
    {
        // empty function because no need to init
    }

    /**
     * PreInit function
     *
     * @return void
     */
    protected function preInit(): void
    {
        // empty function because no need to preInit
    }

    /**
     * return instance of PDO
     *
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    /**
     * permet ajout dans la base de donnée ou update
     *
     * @return void
     */
    public function save(): void
    {
        if (!isset($this->id)) {
            $this->insert();
            $this->init();
        } else {
            $this->update();
        }
    }

    /**
     * retourne une list items selon le nom de la colonne et la valeur
     *
     * @param array $param tableau associatif avec nom collonne et valeur
     * @return array
     */
    static public function selectBy(array $param, $offset = null, $limit = 10)
    {
        if (empty($param)) {
            throw new \Exception('Le paramètre doit contenir au moins une clé => valeur');
        }

        $className = get_called_class();
        $tableName = $className::$tableName;
        $primaryKey = $className::$primaryKey;

        $pdo = BDD::getInstance();

        $sql = 'SELECT * FROM ' . $tableName;
        $conditions = array();
        foreach ($param as $fieldName => $value) {
            $conditions[] = '`' . $fieldName . '` = :' . $fieldName;
        }
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
        if(isset($offset)){
            $sql .= ' LIMIT ' . $offset . ',' . $limit . ';';
        }
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $executeValue = [];
        foreach ($param as $fieldName => $value) {
            $executeValue[":" . $fieldName] = $value;
        }

        $sth->execute($executeValue);

        $requestResults = $sth->fetchAll();

        $results = [];
        
        foreach ($requestResults as $result) {
            $obj = new $className();
            $obj->id = $result[$primaryKey];
            foreach ($className::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }

        return $results;
    }

    /**
     * insert un nouvelle object dans la database
     *
     * @return void
     */
    public function insert(): void
    {
        $className = get_called_class();
        $tableName = $className::$tableName;

        $tmpFieldsList = [];
        $values = [];
        foreach ($className::$properties as $property => $validationRules) {
            $tmpFieldsList[] = ':' . $property;
            $values[$property] = $this->$property;
        }

        $sql = 'INSERT INTO `' . $tableName . '` ( ' . implode(',', array_keys($className::$properties)) . ')
            VALUES (' . implode(',', $tmpFieldsList) . ')
        ';

        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute($values);
        $this->id = $this->pdo->lastInsertId();
    }

    /**
     * update les information de object vers la database
     *
     * @return void
     */
    public function update(): void
    {
        $className = get_called_class();
        $tableName = $className::$tableName;
        $primaryKey = $className::$primaryKey;

        $tmpFieldsList = [];
        $values = [
            "id" => $this->id
        ];

        foreach ($className::$properties as $property => $validationRules) {
            $tmpFieldsList[] = $property . ' = :' . $property;
            $values[$property] = $this->$property;
        }

        $sql = 'UPDATE `' . $tableName . '` SET
            ' . implode(',', $tmpFieldsList) . '
            WHERE ' . $primaryKey . ' = :id
        ';

        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute($values);
    }

    /**
     * Supprime l'item de la table
     *
     * @return void
     */
    public function delete(): void
    {
        $className = get_called_class();
        $tableName = $className::$tableName;
        $primaryKey = $className::$primaryKey;

        $sql = 'DELETE FROM `' . $tableName . '`
            WHERE ' . $primaryKey . ' = :id
        ';

        $values = [
            "id" => $this->id
        ];

        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute($values);
    }

    /**
     * Retourne la liste de tout les items de la table
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function list($offset = 0, $limit = 10): array
    {
        $className = get_called_class();
        $tableName = $className::$tableName;
        $primaryKey = $className::$primaryKey;

        $pdo = BDD::getInstance();
        // TODO $sql = "SELECT * FROM " . $tableName . " LIMIT :limit, $offset ;";
        
        $requestResults = $pdo->query("SELECT * FROM " . $tableName . " LIMIT " . $offset . "," . $limit . ";")->fetchAll(PDO::FETCH_ASSOC);

        $results = [];
        foreach ($requestResults as $result) {
            $obj = new $className();
            $obj->id = $result[$primaryKey];
            foreach ($className::$properties as $property => $validationRules) {
                $obj->$property = $result[$property];
            }
            $results[] = $obj;
        }
        return $results;
    }

    /**
     * Retourne le nombre d'entrée dans la table
     * @return int
     */
    public static function count(): int
    {
        $className = get_called_class();
        $tableName = $className::$tableName;

        $pdo = BDD::getInstance();
        
        $count = $pdo->query("SELECT count(*) FROM " . $tableName . ";")->fetchColumn();

        return (int)$count;
    }

    /**
     * retourne le nombre d'entrée dans la table 
     *
     * @param array $param tableau associatif avec nom colonne et valeur
     * @return int
     */
    static public function countSelectBy(array $param)
    {
        if (empty($param)) {
            throw new \Exception('Le paramètre doit contenir au moins une clé => valeur');
        }

        $className = get_called_class();
        $tableName = $className::$tableName;

        $pdo = BDD::getInstance();

        $sql = 'SELECT count(*) FROM ' . $tableName;
        $conditions = array();
        foreach ($param as $fieldName => $value) {
            $conditions[] = '`' . $fieldName . '` = :' . $fieldName;
        }
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $executeValue = [];
        foreach ($param as $fieldName => $value) {
            $executeValue[":" . $fieldName] = $value;
        }

        $sth->execute($executeValue);

        $results = $sth->fetchColumn();

        return (int)$results;
    }

    /**
     * executer les validator sur les propriété de l'objet
     *
     * @return array
     */
    public function validate(): array
    {
        $className = get_called_class();
        $errors = [];
        foreach ($className::$properties as $property => $validationRules) {
            foreach ($validationRules as $rule) {
                $resultValidate = Validator::$rule($this->$property);
                if ($resultValidate !== true) {
                    if (!isset($errors[$property])) {
                        $errors[$property] = [];
                    }
                    $errors[$property][] = [$rule, $resultValidate];
                }
            }
        }
        return $errors;
    }
}
