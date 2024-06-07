<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\user\UserModel;
use Source\Models\role\RoleModel;
use Source\Controllers\AdminController;

class AdminUserController extends AdminController
{
  /**
   * Show all employee in BDD with form create user. 
   */
  public function index()
  {
    $createUserForm = $this->generateCreateUserForm();
    $users = $this->getAllUsers();
    $this->render('user/adminUser', ['createUserForm' => $createUserForm, 'users' => $users]);
  }

  /**
   * Generate form for create user.
   */
  private function generateCreateUserForm()
  {
    $roles = $this->getRolesFromDatabase();

    $form = new Form;

    $form->startForm('POST', 'adminUser/createUser')

      ->startDiv(['id' => 'div_create_username', 'class' => 'div_create_user'])
      ->addInput('text', 'username', ['id' => 'username', 'placeholder' => 'Nom', 'required' => true])
      ->endDiv()

      ->startDiv(['id' => 'div_create_email', 'class' => 'div_create_user'])
      ->addInput('email', 'email', ['id' => 'email', 'placeholder' => 'Email', 'required' => true])
      ->endDiv()

      ->startDiv(['id' => 'div_create_password', 'class' => 'div_create_user'])
      ->addInput('password', 'password', ['id' => 'password', 'placeholder' => 'Mot de passe'])
      ->endDiv()

      ->startDiv(['id' => 'div_create_role', 'class' => 'div_create_user'])
      ->addSelect('role', $roles, ['required'])
      ->endDiv()

      ->startDiv(['class' => 'input_btn_login input_login div_create_user'])
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

    Header("Location: /adminUser");
    exit;
  }

  /**
   * Delete One User
   */
  public function deleteUser(int $userId)
  {
    if (isset($_POST['deleteUser'])) {
      $userModel = new UserModel;

      $userModel->setId($userId);
      $deleteUser = $userModel->delete();

      if ($deleteUser) {
        $_SESSION['message'] = "✅ Utilisateur supprimé avec succès.";
      } else {
        $_SESSION['error'] = "❌ Une erreur s'est produite lors de la suppression de l'utilisateur.";
      }
    }

    Header("Location: /adminUser");
    exit;
  }

  /**
   * Get all user with role(label) on database
   */
  private function getAllUsers()
  {
    $users = (new UserModel)->getAllUsers();
   
    return $users;
  }

  /**
   * Get all Roles on database
   */
  public function getRolesFromDatabase()
  {
    $role = (new RoleModel)->getAllRoles();
   
    return $role;
  }
}
