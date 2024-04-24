<?php

namespace Models;

use App\Core\Model;
use Models\OrganismesFormation;

class SitesOrgaFormation extends Model
{
    public string $nomSiteOrgaFormation;
    public string $adresse;
    public string $codePostal;
    public string $ville;
    protected int $idOrganismeFormation;

    // Propriété supplémentaire qui n'existe pas dans la table
    private OrganismesFormation $organismeFormation;

    protected static $tableName = 'SitesOrgaFormation';
    protected static $primaryKey = 'idSiteOrgaFormation';
    protected static $properties = [
        'nomSiteOrgaFormation' => ['isNoEmptyString', "isLengthLessThan50"],
        'adresse' => ['isNoEmptyString', "isLengthLessThan200"],
        'codePostal' => ['isCodePostal'],
        'ville' => ['isNoEmptyString', "isLengthLessThan30"],
        'idOrganismeFormation' => []
    ];

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
    // $this->organismeFormation = new OrganismesFormation($this->idOrganismeFormation);

    /**
     * Get the value of organismeFormation
     * @return OrganismesFormation
     */
    public function getOrganismeFormation(): OrganismesFormation
    {
        if (!isset($this->organismeFormation)) {
            $this->organismeFormation = new OrganismesFormation($this->idOrganismeFormation);
        }
        return $this->organismeFormation;
    }

    /**
     * Retourne le nom du site de la formation avec le nom de l'organisme
     * @return string
     */
    public function toString(): string{
        $orgaFormation = $this->getOrganismeFormation();
        if ($orgaFormation == null){
            return "Le site n'a pas d'Organisme " . $this->nomSiteOrgaFormation;
        } else {
            return $orgaFormation->nomOrganismeFormation . " " . $this->nomSiteOrgaFormation;
        }
    }
}
