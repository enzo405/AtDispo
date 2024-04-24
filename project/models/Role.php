<?php

namespace Models;

use App\Core\Model;

class Role extends Model
{
    public string $libelleTypeCompte;

    /**
     * @var string Nom de la table MySQL hébergeant ce model
     */
    protected static $tableName = 'TypesCompte';
    protected static $primaryKey = 'idTypeCompte';
    protected static $properties = [
        'libelleTypeCompte' => ["isNoEmptyString", "isLengthLessThan30"]
    ];
}
