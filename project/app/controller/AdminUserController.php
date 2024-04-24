<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Exceptions\ResourceNotFound;
use App\Exceptions\InternalServerError;
use Models\User;
use Models\Role;

/**
 * Class AdminUserController
 * @package App\Controllers
 */
class AdminUserController extends Controller
{
    /**
     * Constructeur du controller AdminUserController
     */
    public function __construct()
    {
        $this->access([1]);
    }

    /**
     * Affiche la liste des utilisateurs
     *
     * @return void
     */
    public function listUser(): void
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10; 
        $offset = ($page - 1) * $limit;

        $this->getView('admin/user/listUser', ["userList" => User::list($offset), "numberOfPages" => ceil(User::count() / $limit)], 'admin')->addCSS("validation.css")->render();
    }

    /**
     * Affiche un utilisateur
     *
     * @param int $userId
     * @return void
     */
    public function showUser(int $userId): void
    {
        $user = new User($userId);
        $this->getView('admin/user/showUser', ["user" => $user,"roles" => Role::list(0, 100)], 'admin')->addCSS("user.css")->render();
    }

    /**
     * Supprime un utilisateur
     *  
     * @param int $userId
     * @return void
     * */
    public function deleteUserPost(): void
    {
        $post = HTTP_REQUEST->getPostParams();
        
        if (isset($post['delete'])) {
            $userId = $post['userId'];
            $user = new User($userId);
            $user->delete();
            $this->redirect("/admin/users");
        }
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur
     *
     * @return void
     */
    public function editUserPost(int $userId): void
    {
        $user = new User($userId);
        foreach (HTTP_REQUEST->getPostParams() as $key => $value) {
            if ($key == "password") continue;
            if (property_exists($user, $key)) {
                $user->$key = $value;
            }else{
                throw new InternalServerError("La propriété " . $key . " n'existe pas");
            }
        }
        $user->save();
        $this->redirect("/admin/users/$userId");
    }

    /**
     * fonction d'ajout d'un role à un utilisateur
     *
     * @return void
     */
    public function addRolePost(int $userId): void
    {
        $post = HTTP_REQUEST->getPostParams();
        $user = new User($userId);
        $role = new Role($post["role"]);

        $user->addRole($role->id);
        $this->redirect("/admin/users/$userId");
    }

    /**
     * Permet de suprimée un role à un utilisateur
     *
     * @param integer $userId
     * @return void
     */
    public function deleteRolePost(int $userId)
    {
        $post = HTTP_REQUEST->getPostParams();
        $user = new User($userId);
        $role = new Role($post["roleid"]);

        $user->deleteRole($role->id);
        $this->redirect("/admin/users/$userId");
    }
}
