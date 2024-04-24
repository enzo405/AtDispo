<?php

namespace Models;

use App\Core\Model;

class EtatsDisponibilite extends Model
{
	public string $libelleEtatDisponibilite;
	public string $couleurEtatDisponibilite;

	protected static $tableName = 'EtatsDisponibilite';
	protected static $primaryKey = 'idEtatDisponibilite';
	protected static $properties = [
		'libelleEtatDisponibilite' => ["isNoEmptyString", "isLengthLessThan30"],
		'couleurEtatDisponibilite' => ["isHexColor"]
	];

	public static int $disponibleID = 1;
	public static int $pasDisponibleID = 2;
	public static int $indefinieID = 3;
	public static int $potentiellementDispoID = 4;
	public static int $enAttenteID = 5;
}
