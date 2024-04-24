<?php

namespace Models;

use App\Core\Model;
use PDO;
use Models\NomsFormation;

class Matieres extends Model
{
    public string $libelleMatiere;
    public int $valide = 0;

    protected function init(): void
    {
        // empty function because no need to init
    }

    protected static $tableName = 'Matieres';
    protected static $primaryKey = 'idMatiere';
    protected static $properties = [
        'libelleMatiere' => ['isNoEmptyString', "isLengthLessThan30"],
        'valide' => []
    ];
}