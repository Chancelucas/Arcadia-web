<?php

namespace Source\Controllers;

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
  }

  /**
 * Gère le processus de connexion des utilisateurs.
 *
 * Cette méthode vérifie si la requête HTTP est de type POST et valide les champs 'email' et 'password'.
 * Si les informations sont correctes, elle authentifie l'utilisateur et le redirige en fonction de son rôle.
 * Sinon, elle renvoie une erreur et redirige vers la page de connexion.
 *
 * @return void
 */
public function login()
{
    // Vérifie si la méthode de requête est POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Valide les champs du formulaire 'email' et 'password'
        if (Form::validate($_POST, ['email', 'password'])) {
            // Récupère et nettoie l'email de l'utilisateur
            $email = strip_tags($_POST['email']);
            // Récupère le mot de passe de l'utilisateur
            $password = $_POST['password'];

            // Authentifie l'utilisateur avec l'email et le mot de passe
            if ($this->loginModel->authenticate($email, $password)) {
                // Redirige l'utilisateur en fonction de son rôle
                $this->redirectBasedOnRole();
                exit;
            } else {
                // Définit un message d'erreur de connexion incorrecte
                $_SESSION['error'] = '⚠️ login/login en POST... L\'adresse e-mail et/ou le mot de passe est incorrect';
                // Redirige vers la page de connexion
                header('Location: /login');
                exit;
            }
        }

        // Définit un message d'erreur de formulaire invalide
        $_SESSION['error'] = '⚠️ login/login en POST... Formulaire invalide';
        // Redirige vers la page de connexion
        header('Location: /login');
        exit;
    }

    // Définit un message d'erreur si la requête n'est pas de type POST
    $_SESSION['error'] = '⚠️ login/login en GET...';
    // Redirige vers la page de connexion
    header('Location: /login');
    exit;
}


  /**
 * Redirige l'utilisateur en fonction de son rôle.
 *
 * Cette méthode privée vérifie le rôle de l'utilisateur stocké dans la session et le redirige vers
 * le tableau de bord approprié. Si le rôle n'est pas reconnu, elle définit un message d'erreur
 * et redirige vers la page de connexion.
 *
 * @return void
 */
private function redirectBasedOnRole()
{
    // Récupère le rôle de l'utilisateur depuis la session
    $role = $_SESSION['user']['role'];

    // Redirige en fonction du rôle de l'utilisateur
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
        // Définit un message d'erreur pour un rôle non reconnu
        $_SESSION['error'] = "Rôle non reconnu";
        // Redirige vers la page de connexion
        header('Location: /login');
        exit;
    }
}


  /**
 * Génère et affiche le formulaire de connexion.
 *
 * Cette méthode privée crée un formulaire de connexion à l'aide de la classe Form,
 * définit les champs d'email et de mot de passe avec leurs attributs HTML,
 * puis rend la vue 'login/login' en incluant le formulaire généré.
 *
 * @return void
 */
private function generateLoginForm()
{
    // Instancie un nouvel objet Form pour créer le formulaire
    $form = new Form;

    // Démarre la création du formulaire avec la méthode POST et l'action 'login/login'
    // Ajoute une classe CSS 'form_login' au formulaire
    $form->startForm('POST', 'login/login', ['class' => 'form_login'])

        // Démarre la première division pour le champ d'email
        ->startDiv(['class' => 'input_login'])
        // Ajoute un champ d'entrée de type email avec une classe et un placeholder
        ->addInput('email', 'email', ['class' => 'input_text_login', 'placeholder' => 'Email'])
        // Termine la première division
        ->endDiv()

        // Démarre la deuxième division pour le champ de mot de passe
        ->startDiv(['class' => 'input_login'])
        // Ajoute un champ d'entrée de type password avec une classe et un placeholder
        ->addInput('password', 'password', ['class' => 'input_text_login', 'placeholder' => 'Mot de passe'])
        // Termine la deuxième division
        ->endDiv()

        // Démarre la troisième division pour le bouton de connexion
        ->startDiv(['class' => 'input_btn_login input_login'])
        // Ajoute un bouton de type submit avec une classe spécifique
        ->addBouton('Connexion', ['class' => 'btn_connexion'])
        // Termine la troisième division
        ->endDiv()

        // Termine la création du formulaire
        ->endForm();

    // Rend la vue 'login/login' en passant le formulaire généré sous forme de chaîne HTML
    $this->render('login/login', ['loginForm' => $form->create()]);
}

}
