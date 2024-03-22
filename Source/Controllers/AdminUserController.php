<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\MainModel;
use Source\Models\user\UserModel;
use Source\Controllers\AdminController;


class AdminUserController extends AdminController
{
    /**
     * Affiche tous les employés de la BDD avec le formulaire de création d'utilisateur.
     */
    public function index()
    {
        $createUserForm = $this->generateCreateUserForm();
        $users = $this->getAllUsers();
        $deleteUser = $this->deleteUser();
        $updateUser = $this->updateUser();
        $this->render('adminUser/adminUser', ['createUserForm' => $createUserForm, 'users' => $users, 'deleteUser' => $deleteUser, 'updateUser' => $updateUser]);
    }

    /**
     * Génère le formulaire de création d'utilisateur.
     */
    public function generateCreateUserForm()
    {
        $createUser = $this->createUser();
        $roles = $this->getRolesFromDatabase();

        $form = new Form;

        $form->startForm('POST', '')
            ->startDiv(['id' => 'div_create_username', 'class' => 'div_create'])
            ->addInput('text', 'username', ['id' => 'username', 'placeholder' => 'Nom', 'required'])
            ->endDiv()
            ->startDiv(['id' => 'div_create_email', 'class' => 'div_create'])
            ->addInput('email', 'email', ['id' => 'email', 'placeholder' => 'Email', 'required'])
            ->endDiv()
            ->startDiv(['id' => 'div_create_password', 'class' => 'div_create'])
            ->addInput('password', 'password', ['id' => 'password', 'placeholder' => 'Mot de passe'])
            ->endDiv()
            ->startDiv(['id' => 'div_create_role', 'class' => 'div_create'])
            ->addSelect('role', $roles, ['required'])
            ->endDiv()
            ->startDiv(['class' => 'input_btn_login input_login div_create'])
            ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'btn_add_user', 'name' => 'createUser'])
            ->endDiv()
            ->endForm();


        return $form->create();
    }

    /**
     * Traite la soumission du formulaire de création d'utilisateur.
     */
    public function createUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createUser'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $existingUser = (new UserModel)->findOneByEmail($email);

            if ($role === '1') {
                $roleName = 'Admin';
            } elseif ($role === '2') {
                $roleName = 'Employer';
            } elseif ($role === '3') {
                $roleName = 'Vétérinaire';
            } else {
                echo "Rôle non reconnu";
                return;
            }

            if ($existingUser) {
                echo "Le nom d'utilisateur ou l'adresse e-mail est déjà utilisé.";
            } else {
                try {
                    $user = new UserModel;

                    $user->setUsername($username)
                        ->setEmail($email)
                        ->setPassword($hashedPassword)
                        ->setRole($roleName);

                    $user->createUser();

                    $_SESSION['message'] = "L'utilisateur a été créé avec succès.";
                } catch (\Exception $e) {

                    $_SESSION['error'] = "Une erreur s'est produite lors de la création de l'utilisateur : " . $e->getMessage();
                }
            }
        } else {
            $_SESSION['error'] = "Aucun utilisateur n'a été renseigné";
        }
    }


    /**
     * Récupère tous les utilisateurs de la base de données.
     */
    public function getAllUsers()
    {
        $usersModel = new UserModel;
        return $usersModel->getAllUser();
    }

    //getRolesFromDatabase
    public function getRolesFromDatabase()
    {
        $rolesModel = new MainModel;
        $roles = $rolesModel->findAll('Role');
        $roleOptions = [];

        foreach ($roles as $role) {
            $roleOptions[$role->id_Role] = $role->role;
        }

        return $roleOptions;
    }

    //deleteUser
    public function deleteUser()
    {
        if (isset($_POST['deleteUser'])) {
            $userModel = new UserModel;
            $userId = intval($_POST['id_user']);
            $deleteUser = $userModel->delete($userId);

            if ($deleteUser) {
                $_SESSION['message'] = "Utilisateur supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
            }
        }
    }

    //updateUser
    public function updateUser()
    {
    }
}
