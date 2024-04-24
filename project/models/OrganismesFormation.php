<?php

namespace Models;

use App\Core\Model;
use App\Exceptions\ResourceNotFound;
use App\Exceptions\InternalServerError;
use App\Core\BDD;
use PDO;

class OrganismesFormation extends Model
{
    public string $nomOrganismeFormation;
    public string $adresse;
    public string $codePostal;
    public string $ville;
    public int $valide;

    protected function init(): void
    {
        // empty function because no need to init
    }

    protected static $tableName = 'OrganismesFormation';
    protected static $primaryKey = 'idOrganismeFormation';
    protected static $properties = [
        'nomOrganismeFormation' => ['isNoEmptyString', "isLengthLessThan50"],
        'adresse' => ['isNoEmptyString', "isLengthLessThan200"],
        'codePostal' => ['isCodePostal'],
        'ville' => ['isNoEmptyString', "isLengthLessThan30"],
        'valide' => [],
    ];

    /**
     * Récupère le site de l'organisme
     * Si on trouve rien retourne une erreur 404
     * @return SitesOrgaFormation
     */
    public function getSiteOrganisme(): SitesOrgaFormation {
        try {
            $pdo = $this->getPDO();
            $sql = 'SELECT SitesOrgaFormation.idSiteOrgaFormation FROM `OrganismesFormation`
                INNER JOIN SitesOrgaFormation ON SitesOrgaFormation.idOrganismeFormation = OrganismesFormation.idOrganismeFormation
                WHERE OrganismesFormation.idOrganismeFormation = :id;';
            $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $sth->execute([":id" => $this->id]);
        } catch (\PDOException $e) {
            throw new InternalServerError("Impossible de récupérer le site de l'organisme : " . $e->getMessage());
        }
        $result = $sth->fetch();
        if (!$result) {
            return new SitesOrgaFormation(); // Retourne un site vide pour pouvoir renvoyer l'admin vers la page d'ajout de site
        }
        return new SitesOrgaFormation($result["idSiteOrgaFormation"]);
    }
}
