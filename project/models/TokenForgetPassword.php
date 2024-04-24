<?php

namespace Models;

use App\Core\Model;
use Models\User;

class TokenForgetPassword extends Model
{
    public int $validationDate;
    public string $token;
    protected int $idUser;

    // Propriété supplémentaire qui n'existe pas dans la table
    public User $user;

    protected static $tableName = 'TokenForgetPassword';
    protected static $primaryKey = 'idToken';
    protected static $properties = [
        'validationDate' => ["isDate"],
        'token' => ["isNoEmptyString", "isLengthLessThan50"],
        'idUser' => []
    ];

    /**
     * Get the value of idUser
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     * @param int $idUser
     * @return void
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }
 
    /**
     * Generate token with md5
     * @param [type] $courriel
     * @return void
     */
    public function generateToken($courriel)
    {
        $this->token = md5($courriel . time()); // (on utilise le md5 du courriel et du timestamp pour générer un token)
    }
}
