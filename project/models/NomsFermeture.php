<?php

namespace Models;

use App\Core\Model;

class NomsFermeture extends Model
{
    public string $libelleNomFermeture;

    /**
     * @var string Nom de la table MySQL hébergeant ce model
     */
    protected static $tableName = 'NomsFermeture';
    protected static $primaryKey = 'idNomFermeture';
    protected static $properties = [
        'libelleNomFermeture' => ["isNoEmptyString", "isLengthLessThan50"],
    ];
}
