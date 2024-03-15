<?php

namespace Source\Controllers;

use Lib\config\Database;
use Source\Models\user\LoginModel;
use Lib\config\Form;


class LoginController extends Controller
{
    private $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    public function index()
    {

        $this->generateLoginForm();
        $this->login();
        $this->render('login/login');

    }

    public function login()
    {
        $firstLogin = Database::firstLogin();

        if ($firstLogin) {
            Database::createAdminUser();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && Form::validate($_POST, ['email', 'password'])) {

            $email = strip_tags($_POST['email']);
            $password = $_POST['password'];

            if ($this->loginModel->authenticate($email, $password)) {
                $this->redirectBasedOnRole();
                exit;
            } else {
                $_SESSION['error'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /login');
                exit;
            }
        }
    }

    private function redirectBasedOnRole()
    {
        $role = $_SESSION['user']['role'];
        if ($role === 'Admin') {
            header('Location: /adminDashboard');
            exit;
        } elseif ($role === 'Employer') {
            header('Location: /employeeDashboard');
            exit;
        } elseif ($role === 'Vétérinaire') {
            header('Location: /vetDashboard');
            exit;
        } else {
            $_SESSION['error'] = "Rôle non reconnu";
            header('Location: /login');
            exit;
        }
    }

    private function generateLoginForm()
    {
        $form = new Form;

        $form->startForm('POST', '/login', ['class' => 'formulaire', 'id' => 'form_login'])

            ->startDiv(['class' => 'input_login'])
            ->addInput('email', 'email', ['class' => 'input_text_login', 'id' => 'input_email_login', 'placeholder' => 'Email'])
            ->endDiv()

            ->startDiv(['class' => 'input_login'])
            ->addInput('password', 'password', ['class' => 'input_text_login', 'id' => 'input_password_login', 'placeholder' => 'Mot de passe'])
            ->endDiv()

            ->startDiv(['class' => 'input_btn_login input_login'])
            ->addBouton('Connexion', ['class' => 'btn', 'id' => 'btn_connect_login'])
            ->endDiv()

            ->endForm();

        $this->render('login/login', ['loginForm' => $form->create()]);
    }

    //logout
    static public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /login') ;
        exit;
    }
}
