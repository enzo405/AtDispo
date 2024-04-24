<?php

namespace Models;

use App\Core\Model;

class TypesCreneau extends Model
{
    public string $libelleTypeCreneau;

    /**
     * @var string Nom de la table MySQL hébergeant ce model
     */
    protected static $tableName = 'TypesCreneau';
    protected static $primaryKey = 'idTypeCreneau';
    protected static $properties = [
        'libelleTypeCreneau' => ["isNoEmptyString", "isLengthLessThan20"]
    ];
}
