<?php

namespace Models;

use App\Core\Model;
use App\Exceptions\DisabledForDemoException;
use App\Exceptions\InternalServerError;
use Models\Matieres;
use PDO;

class NomsFormation extends Model
{
    public string $libelleNomFormation;
    public int $valide = 0;

    /**
     * Représente la table Contenus qui contient la matière et l'id du NomsFormation
     */
    private array $matieres = [];

    protected static $tableName = 'NomsFormation';
    protected static $primaryKey = 'idNomFormation';
    protected static $properties = [
        'libelleNomFormation' => ["isNoEmptyString", "isLengthLessThan30"],
        'valide' => []
    ];

    /**
     * Méthode qui récupère les matières qui sont assignées à un NomFormation
     * @return void
     */
    protected function syncMatieres(){
        try{
            $pdo = $this->getPDO();
            $sql = 'SELECT `idMatiere` FROM `Contenus` WHERE `idNomFormation` = :id';
            $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([":id" => $this->id]);
            $result = $sth->fetchAll();
        } catch (\PDOException $e) {
            throw new InternalServerError("Impossible de récupérer les matières de la formation : " . $e->getMessage());
        }
        $this->matieres = []; // reset des matières
        foreach ($result as $key => $value) {
            $this->matieres[] = new Matieres($value['idMatiere']);
        }
    }

    /**
     * Méthode qui récupère les matières qui sont assignées a NomFormation
     * @return array Ajoute toutes les matieres de la formation
     */
    public function getMatieres(): array
    {
        if (count($this->matieres) > 0) {
            // TODO faire un count de la table et comparer la taille avec le nombre de matiere 
            return $this->matieres;
        }
        $this->syncMatieres();
        return $this->matieres;
    }

    /**
     * Méthode qui ajoutes les matières dans la table qui correspond
     * @param array $matieres Tableau de matières
     * @return void
     */
    public function saveMatieres(array $matieres)
    {
        $user = new User($_SESSION["userID"]);
        $this->syncMatieres();
        if ($user->isSuperAdmin()) {
            $valuesAdd[":idNomFormation"] = $this->id;
            $valuesRemove[":idNomFormation"] = $this->id;
            $idsAdd = [];
            $idsDelete = [];
            // Si on veux ajouter la matiere
            foreach ($matieres as $key => $matiere) {
                if (!in_array($matiere, $this->matieres)) {
                    $idsAdd[] = "(:idNomFormation, :idMatiere_$key)";
                    $valuesAdd[":idMatiere_$key"] = $matiere->id;
                }
            }
            // Si on veux supprimer la matiere
            foreach ($this->matieres as $key => $matiere) {
                if (!in_array($matiere, $matieres)) {
                    $idsDelete[] = ":idMatiere_$key";
                    $valuesRemove[":idMatiere_$key"] = $matiere->id;
                }
            }

            $pdo = $this->getPDO();
            if (!empty($idsAdd)) {
                $sqlAdd = 'INSERT INTO `Contenus`(`idNomFormation`, `idMatiere`) VALUES ' . implode(", ", $idsAdd) . ";";
                $sthAdd = $pdo->prepare($sqlAdd, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                $sthAdd->execute($valuesAdd);
            }

            if (!empty($idsDelete)) {
                $sqlRemove = 'DELETE FROM `Contenus` WHERE `idMatiere` IN (' . implode(", ", $idsDelete) . ') AND `idNomFormation` = :idNomFormation';
                $sthRemove = $pdo->prepare($sqlRemove, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                $sthRemove->execute($valuesRemove);
            }
        } else {
            throw new DisabledForDemoException();
        }
    }

    public function getFormations(){
        $pdo = $this->getPDO();

		$sql = "SELECT Formations.idFormation FROM NomsFormation INNER JOIN `Formations` ON NomsFormation.idNomFormation = Formations.idNomFormation WHERE Formations.idNomFormation = :idNomFormation";
        
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        
        $sth->execute([":idNomFormation" => $this->id]);
		$result = $sth->fetchAll();

        $formations = [];
        foreach ($result as $key => $value) {
            $formations[] = new Formations($value['idFormation']);
        }
        return $formations;
    }
}
