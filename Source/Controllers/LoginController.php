<?php

namespace Source\Controllers;

use Lib\config\Database;
use Source\Models\user\LoginModel;
use Lib\config\Form;
use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;
use Source\Helpers\FlashMessage;

class LoginController extends Controller
{
  private $loginModel;

  public function __construct()
  {
    $this->loginModel = new LoginModel();
  }

  public function index()
  {
    $loginForm = $this->generateLoginForm();

    $this->render('login/login', [
      'loginForm' => $loginForm,
    ]);
  }

  /**
   * Génère et affiche le formulaire de connexion.
   */
  private function generateLoginForm()
  {
    $form = new Form;

    $form->startForm('POST', 'login/login', ['class' => 'form_login'])

      ->addError('email', $this->error)
      ->addError('password', $this->error)

      ->startDiv(['class' => 'input_login'])
      ->addInput('email', 'email', ['class' => 'input_text_login', 'placeholder' => 'Email'])
      ->endDiv()

      ->startDiv(['class' => 'input_login'])
      ->addInput('password', 'password', ['class' => 'input_text_login', 'placeholder' => 'Mot de passe'])
      ->endDiv()

      ->startDiv(['class' => 'input_btn_login input_login'])
      ->addBouton('Connexion', ['class' => 'btn_connexion'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * Gère le processus de connexion des utilisateurs.
   */
  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (Form::validate($_POST, ['email', 'password'])) {
        $email = SecurityHelper::sanitize(InputType::String, 'email');
        $password = SecurityHelper::sanitize(InputType::String, 'password');

        if (!$email) {
          FlashMessage::addMessage("Utilisateur inconnu", 'error');
          header('Location: /login');
          exit;
        }

        if (Database::firstLogin()) {
          Database::fixtureAdmin();
          FlashMessage::addMessage("L'utilisateur admin a été créé avec succès", 'success');
          header('Location: /login');
          exit;
        }

        if ($this->loginModel->authenticate($email, $password)) {
          $this->redirectBasedOnRole();
          exit;
        } else { 
          FlashMessage::addMessage("Le formulaire est incomplet", 'error');
          header('Location: /login');
          exit;
        }
      }

      FlashMessage::addMessage('⚠️ login/login en POST... Formulaire invalide', 'error');
      header('Location: /login');
      exit;
    }

    FlashMessage::addMessage('⚠️ login/login en GET...', 'error');
    header('Location: /login');
    exit;
  }


  /**
   * Redirige l'utilisateur en fonction de son rôle.
   */
  private function redirectBasedOnRole()
  {
    $role = $_SESSION['user']['role'];
    $active = $_SESSION['user']['active'];

    if ($active === 0) {
      header('Location: /errorPage');
      exit;
    }
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
}
