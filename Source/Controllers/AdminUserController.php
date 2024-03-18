<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\user\UserModel;
use Source\Controllers\AdminController;

class AdminUserController extends AdminController
{
    /**
     * Affiche tout les employer de la BDD
     * 
     */
    public function index()
    {
        $valideForm = $this->createUser();
        $createUserForm = $this->generateCreateUserForm();
        $users = $this->showAllUsers();
        $this->render('adminUser/adminUser',['createUserForm' => $createUserForm, 'users' => $users]);
    }

    //validedForm
    public function validedForm()
    {
        if (Form::validate($_POST, ['username', 'email', 'password'])) {
            $username = strip_tags($_POST['username']);
            $email = strip_tags($_POST['email']);
            $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $user = new UserModel;

            $user->setEmail($email)
                ->setPassword($pass)
                ->setUsername($username);

            $user->create();
        }
    }

    //generateCreateUserForm
    public function generateCreateUserForm()
    {
        $form = new Form;

        $form->startForm('POST', '/adminUser')
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
            ->addSelect('roleName', ['Admin', 'Employer', 'Vétérinaire'], ['required'])
            ->endDiv()
            ->startDiv(['class' => 'input_btn_login input_login div_create'])
            ->addBouton('Crée', ['type' => 'submit', 'value' => 'Create_employee', 'name' => 'Create_employee', 'id' => 'btn_add_user'])
            ->endDiv()
            ->endForm();

            return $form->create();
    }

    //createUser
    public function createUser()
    {
        if (Form::validate($_POST, ['username', 'email', 'password', 'roleName'])) {
            $username = strip_tags($_POST['username']);
            $email = strip_tags($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = strip_tags($_POST['roleName']);

            $user = new UserModel;
            $user->setUsername($username)
                ->setEmail($email)
                ->setPassword($password)
                ->setRole($role)
                ->create();

            header('Location: /adminUser');
            exit;
        } else {
            $_SESSION['error'] = "Le formulaire est incomplet";
        }
    }


    public function updateUser()
    {

    }

    public function deleteUser()
    {

    }

    public function showAllUsers()
    {
        $usersModel = new UserModel;
        $users =  $usersModel->getAllUser();
        return $users;
    }
}
