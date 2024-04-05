<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\MainModel;
use Source\Models\user\UserModel;
use Source\Models\role\RoleModel;
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
        $this->render('adminUser/adminUser', ['createUserForm' => $createUserForm, 'users' => $users, 'deleteUser' => $deleteUser]);
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
            $id_Role = $_POST['role'];

            $existingUser = (new UserModel)->findOneByEmail($email);

            if (!is_null($existingUser)) {
                echo "Le nom d'utilisateur ou l'adresse e-mail est déjà utilisé.";
                return;
            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                try {
                    $user = new UserModel;

                    $user->setUsername($username)
                        ->setEmail($email)
                        ->setPassword($hashedPassword)
                        ->setIdRole($id_Role);

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
     * Get all user with role(label) on database
     */
    public function getAllUsers()
    {
        $model = new UserModel;
        $usersModel = $model->getAll();

        $allUsers = [];
        foreach ($usersModel as $userModel) {
            $user = new \stdClass();
            $user->id_User = $userModel->getId();
            $user->username = $userModel->getUsername();
            $user->email = $userModel->getEmail();
            $user->password = $userModel->getPassword();
            $user->id_Role = $userModel->getIdRole();
            $user->role = $userModel->getRole();
            $allUsers[] = $user;
        }

        return $allUsers;
    }

    /**
     * Get all Roles on database
     */
    public function getRolesFromDatabase()
    {
        $roleModel = new RoleModel;
        $roles = $roleModel->getAll();
        $roleOptions = [];

        foreach ($roles as $role) {
            $roleOptions[$role->getId()] = $role->getRole();
        }

        return $roleOptions;
    }

    /**
     * Delete One User
     */
    public function deleteUser()
    {
        if (isset($_POST['deleteUser'])) {
            $userModel = new UserModel;
            $userId = intval($_POST['id_user']);

            $userModel->setId($userId);
            $deleteUser = $userModel->delete();

            if ($deleteUser) {
                $_SESSION['message'] = "Utilisateur supprimé avec succès.";
            } else {
                $_SESSION['error'] = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
            }
        }
    }
}
