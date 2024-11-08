<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\Database;
use Source\Helpers\InputType;
use Source\Helpers\FlashMessage;
use Source\Helpers\SecurityHelper;
use Source\Models\user\UserModel;
use Source\Models\user\LoginModel;

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

        // crée le 1er user admin lors de la 1er connection
        if (Database::firstLogin()) {
          Database::fixtureAdmin();
          header('Location: login');
          exit;
        }
        $userModel = New UserModel;
        $user = $userModel->findOneByEmail($email);

        if (!$user) {
          // Si l'utilisateur n'existe pas
          FlashMessage::addMessage("Cet utilisateur n'existe pas.", 'warning');
          $this->index();
          exit;
        }

        if ($this->loginModel->authenticate($email, $password)) {
          $this->redirectBasedOnRole();
          exit;
        } else { 
          FlashMessage::addMessage("Email ou mot de passse incorrect", 'warning');
          $this->index();
          exit;
        }
      }

      FlashMessage::addMessage('Veillez remplir tout les champs', 'error');
      $this->index();
      exit;
    }

    FlashMessage::addMessage("L'utilisateur admin a été créé avec succès", 'success');
    $this->index();
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
      FlashMessage::addMessage("Aucun rôle n'a était reconnue", 'error');
      $this->index();
      exit;
    }
  }
}
