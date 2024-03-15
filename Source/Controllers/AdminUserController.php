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
        $this->generateCreateUserForm();
        $this->render('adminUser/adminUser');
    } 

    public function validedForm()
    {
        if(Form::validate($_POST, ['username', 'email', 'password'])){
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
    public function generateCreateUserForm()
    {
        $form = new Form;

        $form->startForm('POST', '/adminUser')

            ->startDiv(['id' => 'div_create_username'])
            ->addInput('text', 'username', ['id' => 'username', 'placeholder' => 'Nom', 'required'])
            ->endDiv()

            ->startDiv(['id' => 'div_create_email'])
            ->addInput('email', 'email', ['id' => 'email', 'placeholder' => 'Email', 'required'])
            ->endDiv()

            ->startDiv(['id' => 'div_create_password'])
            ->addInput('password', 'password', ['id' => 'password', 'placeholder' => 'Mot de passe'])
            ->endDiv()
            
            ->startDiv(['id' => 'div_create_role'])
            ->addSelect('roleName', ['Admin', 'Employer', 'Vétérinaire'], ['required'])
            ->endDiv()

            ->startDiv(['class' => 'input_btn_login input_login'])
            ->addBouton('Crée', ['type' => 'submit', 'value' => 'Create_employee', 'name' => 'Create_employee'])
            ->endDiv()

            ->endForm();

        $this->render('adminUser/adminUser', ['createUserForm' => $form->create()]);
    }
}