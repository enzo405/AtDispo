<?php

namespace Models;

use App\Core\BDD;
use App\Core\Model;
use App\Exceptions\ResourceNotFound;
use PDO;

class CalendriersDisponibilite extends Model
{
	public string $anneeScolCalendrierDisponibilite;
	protected ?string $dateMajEtat = NULL;
	public int $idCompte;

	protected static $tableName = 'CalendriersDisponibilite';
	protected static $primaryKey = 'idCalendrierDisponibilite';
	protected static $properties = [
		'anneeScolCalendrierDisponibilite' => ["isAnneeScol"],
		'dateMajEtat' => ["isDate"],
		"idCompte" => []
	];

	/**
	 * Récupère le compte associé à ce calendrier
	 *
	 * @return User
	 */
	public function getCompte() : User
	{
		return new User($this->idCompte);
	}

	public function getAllEvents(): array
	{
		$pdo = $this->getPDO();
		$sql = "SELECT C.idCreneauDisponibilite, C.idTypeCreneau, C.dateCreneauDisponibilite, TC.libelleTypeCreneau, ED.couleurEtatDisponibilite, ED.libelleEtatDisponibilite, M.libelleMatiere, SOF.adresse, SOF.nomSiteOrgaFormation, O.nomOrganismeFormation, C.idEtatDisponibilite, NF.libelleNomFormation
        FROM CreneauDisponibilite C
            INNER JOIN TypesCreneau TC on C.idTypeCreneau = TC.idTypeCreneau
            INNER JOIN EtatsDisponibilite ED on C.idEtatDisponibilite = ED.idEtatDisponibilite
            LEFT JOIN Formations F on C.idFormation = F.idFormation
            LEFT JOIN NomsFormation NF on NF.idNomFormation = F.idNomFormation
            LEFT JOIN SitesOrgaFormation SOF on SOF.idSiteOrgaFormation = F.idSiteOrgaFormation
            LEFT JOIN Matieres M on C.idMatiere = M.idMatiere
            LEFT JOIN OrganismesFormation O on SOF.idOrganismeFormation = O.idOrganismeFormation
        WHERE C.idCalendrierDisponibilite = :id";
        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([":id" => $this->id]);
		return $sth->fetchAll();
	}

	/**
	 * Recupere la date de mise a jours
	 *
	 * @return string
	 */
	public function getMajDate(): string
	{
		return $this->dateMajEtat;
	}

	/**
	 * {@inheritDoc}
	 */
	public function save(): void
    {
		$this->dateMajEtat = date("Y-m-d H:i:s");
        if (!isset($this->id)) {
            $this->insert();
            $this->init();
        } else {
            $this->update();
        }
    }

	/**
	 * Ajout l'année scoalire au calendrier
	 *
	 * @param string $year
	 * @return void
	 */
	public function setAnneeScolCalendrierDisponibilite(string $year): void
	{
		$this->anneeScolCalendrierDisponibilite = $year . "-" . strval($year + 1);
	}

	/**
	 * Récupère le calendrier de disponibilité d'un utilisateur
	 *
	 * @param integer $idCompte
	 * @param string $year
	 *	Format : "YYYY"
	 *  Si null, l'année courante est utilisée
	 *
	 * @throws ResourceNotFound
	 * @return CalendriersDisponibilite
	 */
	public static function getCalendrierDisponibiliteByUser(int $idCompte, string $year = NULL): CalendriersDisponibilite
	{
		if ($year == NULL) {
			$year = self::getCurrentYear();
		}
		$year = $year . "%";
		$pdo = BDD::getInstance();
		$sql = "SELECT * FROM CalendriersDisponibilite WHERE idCompte = :id AND anneeScolCalendrierDisponibilite like :year;";
		$sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
		$sth->execute([":id" => $idCompte, ":year" => $year]);
		$results = $sth->fetchAll();

		if (count($results) === 0) {
			throw new ResourceNotFound("Calendrier introuvable");
		}
		return new CalendriersDisponibilite($results[0]['idCalendrierDisponibilite']);
	}

	/**
	 * Return current year
	 *
	 * @return string
	 */
	public static function getCurrentYear(): string
	{
		$date = date("Y-m-d");
		$year = date("Y");
		if ($date < $year . "-08-01") {
			return $year - 1;
		}else{
			return $year;
		}
	}

	public function toString(): string{
		$compte = $this->getCompte();
		return $compte->toString() . " " . $this->anneeScolCalendrierDisponibilite;
	}

	/**
	 * Récupère les ids des responsables du calendrier
	 *
	 * @return array
	*/
	public function getListCalendarAccess(): array {
		$pdo = $this->getPDO();
		$sql = 'SELECT DisposIntervenant.idCompte FROM CalendriersDisponibilite 
			INNER JOIN DisposIntervenant ON DisposIntervenant.idCalendrierDisponibilite = CalendriersDisponibilite.idCalendrierDisponibilite 
			WHERE CalendriersDisponibilite.idCalendrierDisponibilite = :idCalendrierDisponibilite;';
		$sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
		$sth->execute([":idCalendrierDisponibilite" => $this->id]);
		$result = [];

		foreach ($sth->fetchAll() as $key => $value) {
			$result[] = $value["idCompte"];
		}
		return $result;
	}

	/**
	 * Vérifie que le calendrier est expiré
	 * @return bool
	 */
	public function isNotExpired(): bool{
		$dates = explode("-" , $this->anneeScolCalendrierDisponibilite);
		if (!($dates[0] > $this::getCurrentYear())) {
			return false;
		}
		return true;
	}
}
