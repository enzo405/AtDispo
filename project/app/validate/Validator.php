<?php

namespace App\Core;

use Models\User;
use DateTime;

class Validator
{
    /**
     * Méthode validation si l'input n'est pas vide
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isNoEmptyString($value): bool|string
    {
        if (!empty($value)) {
            return true;
        }
        return "La chaine de caractère ne peut pas être vide !";
    }

    /**
     * Méthode validation si l'input est un e-mail
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isEmail($value): bool|string
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return "Votre email n'est pas un email";
    }

    /**
     * Méthode validation si l'input est une date
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isDate($value): bool|string
    {
        if (DateTime::createFromFormat('Y-m-d', $value) !== false) {
            return true;
        }
        return "Date is not in correct format";
    }

    /**
     * Méthode validation de la taille du password (8 charactère) 
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isPasswordLengthValid($value): bool|string
    {
        if (strlen($value) < 8) {
            return "Le mot de passe est trop court !";
        }
        return true;
    }

    /**
     * Méthode validation pour vérifier que cela correspond à un nombre
     * @param $value correspond à la valeur de la propriété
     * @return bool|string correspond à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isNumber($value): bool|string
    {
        if (is_int($value)) {
            return true;
        }
        return "Veuillez entrer un nombre !";
    }
    
    /**
     * Méthode validation pour vérifier que cela correspond à un nombre
     * @param $value correspond à la valeur de la propriété
     * @return bool|string correspond à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isCodePostal($value): bool|string
    {
        if (!is_int($value) && intval($value) == 0) {
            return "Veuillez entrer un nombre pour le code postal !";
        }

        if (strlen((int)$value) != 5) {
            return "Ceci n'est pas un code postal !";
        }
        return true;
    }

    /**
     * Méthode validation du format d'une couleure "#ffffff"
     * @param $value correspond à la valeur de la propriété*
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isHexColor($value): bool|string
    {
        if (strlen($value) > 7) {
            return "La chaîne est trop longue, elle doit avoir 7 caractères ou moins";
        }
        if (!preg_match('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/', $value)) {
            return "La couleur n'est pas sous le bon format";
        }
        return true;
    }

    /**
     * Méthode validation année scolaire est correctement renseigné dans ce format
     * "2023-2024"
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isAnneeScol($value): bool|string
    {
        if (preg_match('/^\d{4}-\d{4}$/', $value)) {
            $years = explode('-', $value);
            $startYear = intval($years[0]);
            $endYear = intval($years[1]);
    
            if ($startYear < $endYear) {
                return true;
            }
        }
        return "Le format des années n'est pas respecté !";
    }

    /**
     * Méthode validation si l'input est de taille inférieur à 50 charactères
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isLengthLessThan50($value): bool|string
    {
        if (strlen($value) > 50) {
            return "La chaîne est trop longue, elle doit avoir 50 caractères ou moins";
        }
        return true;
    }

    /**
     * Méthode validation si l'input est de taille inférieur à 20 charactères
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isLengthLessThan20($value): bool|string
    {
        if (strlen($value) > 20) {
            return "La chaîne est trop longue, elle doit avoir 20 caractères ou moins";
        }
        return true;
    }

    /**
     * Méthode validation si l'input est de taille inférieur à 30 charactères
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isLengthLessThan30($value): bool|string
    {
        if (strlen($value) > 30) {
            return "La chaîne est trop longue, elle doit avoir 30 caractères ou moins";
        }
        return true;
    }

    /**
     * Méthode validation si l'input est de taille inférieur à 200 charactères
     * @param $value correspond à la valeur de la propriété
     * @return string|bool correspond soit à l'erreur à afficher ou un "True" si la validation fonctionne
     */
    public static function isLengthLessThan200($value): bool|string
    {
        if (strlen($value) > 200) {
            return "La chaîne est trop longue, elle doit avoir 200 caractères ou moins";
        }
        return true;
    }
}
