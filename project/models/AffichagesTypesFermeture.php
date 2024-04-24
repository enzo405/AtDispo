<?php

namespace Models;

use App\Core\Model;

class AffichagesTypesFermeture extends Model
{
	public string $affichageTypeFermeture;

	protected static $tableName = 'AffichagesTypesFermeture';
	protected static $primaryKey = 'idAffichageTypeFermeture';
	protected static $properties = [
		"affichageTypeFermeture" => ["isNoEmptyString", "isLengthLessThan20"]
	];
}
