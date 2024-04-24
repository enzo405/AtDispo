<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Mailer;
use Models\User;

class UserController extends Controller
{
    /**
     * Constructeur du controller UserController
     */
    public function __construct()
    {
        $this->access([1,2,3]);
    }

    /**
     * Affichage de la page setting utilisateur
     */
    public function settingsUser()
    {
        $get = HTTP_REQUEST->getGetParams();
        $user = new User($_SESSION['userID']);
        foreach ($user->roles as $role) {
            switch ($role->id) {
                case 2:
                    $layout = 'responsable';
                    break;
                case 3:
                    $layout = 'formateur';
                    break;
                case 1:
                    $layout = 'admin';
                    break;
            }
        }

        $this->getView('user/settingsUser', [
            "user" => $user,
            'errorMessage' => $get["errorMessage"] ?? NULL
        ], $layout)->addCSS("user.css")->render();
    }

    /**
     * Traitement du formulaire de la page setting utilisateur
     */
    public function settingsUserPost()
    {
        $user = new User($_SESSION['userID']);
        $post = HTTP_REQUEST->getPostParams();

        if (isset($post['infosSettings'])) {
            $user->nom = trim($post['nom']);
            $user->prenom = trim($post['prenom']);

            $newCourriel = trim($post['courriel']);

            // Vérification que l'email est pas déjà utilisé
            if (!$user->isEmailUnique($newCourriel)){
                $this->redirect('/settings?errorMessage=Cet email est déjà utilisé !');
            }

            $user->courriel = $newCourriel;
            $errors = $user->validate();

            if (empty($errors)) {
                $user->update();
                $this->redirect('/settings');
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/settings?errorMessage=$firstError");
            }
        }

        if (isset($post['passwordSettings'])) {
            $post['newPassword'] = htmlspecialchars(trim($post['newPassword']));
            $post['oldPassword'] = trim($post['oldPassword']);
            $post['confirmationPassword'] = htmlspecialchars(trim($post['confirmationPassword']));

            // Vérification que l'ancien mot de passe correspond
            if (!password_verify($post['oldPassword'], $user->password)) {
                $this->redirect('/settings?errorMessage=Votre ancien mot de passe ne correspond pas avec celui que vous avez entré');
            }

            // Ne doivent pas correspondre
            if ($post['newPassword'] == $post['oldPassword']) {
                $this->redirect('/settings?errorMessage=Le nouveau mot de passe ne peut pas être le même que l\'ancien !');
            }

            // Doivent correspondre
            if ($post['newPassword'] != $post['confirmationPassword']) {
                $this->redirect('/settings?errorMessage=Le nouveau mot de passe et la confirmation de celui-ci ne correspondent pas !');
            }

            $user->password = $post['newPassword'];
            $errors = $user->validate();
            if (empty($errors)) {
                $user->password = password_hash($user->password, PASSWORD_DEFAULT);
                $user->update();

                $mail = new Mailer([$user->courriel], "Mot de passe modifié");
                $mail->addTemplate('mail/mdpModifie', [
                    'compte' => $user
                ]);
                $mail->send();

                $this->redirect('/settings');
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/settings?errorMessage=$firstError");
            }
        }
    }
}
