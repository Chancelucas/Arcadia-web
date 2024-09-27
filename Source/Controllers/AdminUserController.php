<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\user\UserModel;
use Source\Models\role\RoleModel;
use Source\Controllers\AdminController;
use Source\Models\filter\FilterModel;
use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;
use Source\Helpers\FlashMessage;

class AdminUserController extends AdminController
{
  public function index()
  {
    $filterUser = [];
    $selectedRole = $_POST['roleFilter'] ?? null;
    $filterUser = (new FilterModel())->filterAllUserOfRole($selectedRole);

    $filterFormUser = $this->createFilterUser();
    $createUserForm = $this->generateCreateUserForm();
    
    $users = empty($filterUser) ? $this->getAllUsers() : $filterUser;

    $this->render('user/adminUser', [
      'createUserForm' => $createUserForm,
      'users' => $users,
      'filterFormUser' => $filterFormUser
    ]);
  }

  private function generateCreateUserForm()
  {
    $roles = $this->getRolesFromDatabase();

    $form = new Form;

    $form->startForm('POST', 'adminUser/createUser', ['class' => 'form-user-admin'])

      ->startDiv(['class' => 'form-group'])
      ->addInput('text', 'username', ['id' => 'username', 'class' => 'form-control', 'placeholder' => 'Nom', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'form-group'])
      ->addInput('email', 'email', ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'form-group'])
      ->addInput('password', 'password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Mot de passe'])
      ->endDiv()

      ->startDiv(['class' => 'form-group'])
      ->addSelect('role', $roles, ['class' => 'form-control', 'required'])
      ->endDiv()

      ->startDiv(['class' => 'form-group'])
      ->addBouton('Créer', ['type' => 'submit', 'class' => 'btn btn-create-user', 'id' => 'btn_add_user', 'name' => 'createUser'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  public function createUser()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['createUser'])) {
      // $username = $_POST['username'];
      // $email = $_POST['email'];
      // $password = $_POST['password'];
      // $id_Role = $_POST['role'];

      $username = SecurityHelper::sanitize(InputType::String, 'username');
      $email = SecurityHelper::sanitize(InputType::String, 'email');
      $password = SecurityHelper::sanitize(InputType::String, 'password');
      $id_Role = SecurityHelper::sanitize(InputType::String, 'role');

      $existingUser = (new UserModel)->findOneByEmail($email);

      if (!is_null($existingUser)) {
        FlashMessage::addMessage("Le nom d'utilisateur ou l'adresse e-mail est déjà utilisé.", 'warning');
        //echo "Le nom d'utilisateur ou l'adresse e-mail est déjà utilisé.";
        $this->index();
        exit;
      }

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      try {
        $newUser = new UserModel;

        $newUser->setUsername($username)
          ->setEmail($email)
          ->setPassword($hashedPassword)
          ->setIdRole($id_Role);

        $newUser->createUser();

        $_SESSION['message'] = "L'utilisateur a été créé avec succès.";
      } catch (\Exception $e) {
        $_SESSION['error'] = "Une erreur s'est produite lors de la création de l'utilisateur : " . $e->getMessage();
      }
    } else {
      $_SESSION['error'] = "Aucun utilisateur n'a été renseigné";
    }

    Header("Location: /adminUser");
    exit;
  }

  public function deleteUser(int $userId)
  {
    if (isset($_POST['deleteUser'])) {
      $userModel = new UserModel;

      $userModel->findOneById($userId);
      $userModel->setActive(0);

      $deleteUser = $userModel->update();



      if ($deleteUser) {
        $_SESSION['message'] = "✅ Utilisateur supprimé avec succès.";
      } else {
        $_SESSION['error'] = "❌ Une erreur s'est produite lors de la suppression de l'utilisateur.";
      }
    }

    Header("Location: /adminUser");
    exit;
  }

  private function createFilterUser()
  {
    $form = new Form();

    $form->startForm('POST', '', ['class' => 'form-filter-role'])

      ->addBouton('Tous', ['type' => 'submit', 'value' => 'Tous', 'name' => 'roleFilter', 'class' => 'btn-filter-admin-user'])
      ->addBouton('Employer', ['type' => 'submit', 'value' => 'Employer', 'name' => 'roleFilter', 'class' => 'btn-filter-admin-user'])
      ->addBouton('Vétérinaire', ['type' => 'submit', 'value' => 'Vétérinaire', 'name' => 'roleFilter', 'class' => 'btn-filter-admin-user'])
      ->addBouton('Inactif', ['type' => 'submit', 'value' => 'Inactif', 'name' => 'roleFilter', 'class' => 'btn-filter-admin-user'])


      ->endForm();

    return $form->create();
  }

  private function getAllUsers()
  {
    $users = (new UserModel)->getAllUsers();
    return $users;
  }

  public function getRolesFromDatabase()
  {
    $role = (new RoleModel())->getAllRoles();
    return $role;
  }
}
