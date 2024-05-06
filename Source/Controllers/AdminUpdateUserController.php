<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\user\UserModel;
use Source\Controllers\AdminController;
use Source\Controllers\AdminUserController;

class AdminUpdateUserController extends AdminController
{
  /**
   * Show all employee en BDD with form create user. 
   */
  public function index()
  {
    $userForm = $this->getOneUser();
    $this->render('user/adminUpdateUser', ['userForm' => $userForm]);
  }

  /**
   * Get the user on clic
   */
  public function getOneUser()
  {
    if (isset($_POST['id_user'])) {
      $userId = intval($_POST['id_user']);
      $userModel = new UserModel;
      $user = $userModel->findOneById($userId);

      $username = $user->getUsername();
      $email = $user->getEmail();
      $password = $user->getPassword();

      // Utilisez la méthode createForm pour générer le formulaire
      $updateUserForm = $this->createForm($userId, $username, $email, $password);

      return $updateUserForm;
    }
  }

  /**
   * Generate update user form
   */
  public function createForm($userId, $username, $email, $password)
  {
    $getRole = new AdminUserController;
    $roles = $getRole->getRolesFromDatabase();

    $form = new Form;

    $form->startForm('POST', "adminUpdateUser/updateUser/{$userId}", ['id' => 'form_update_user'])
      ->startDiv(['class' => 'div_form_update_user'])
      ->addLabelFor('username', 'Nom : ')
      ->addInput('text', 'username', ['id' => 'username', 'class' => 'input_class_update_user', 'value' => $username, 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_form_update_user'])
      ->addLabelFor('email', 'Email : ')
      ->addInput('email', 'email', ['id' => 'email', 'class' => 'input_class_update_user', 'value' => $email, 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_form_update_user'])
      ->addLabelFor('password', 'Mot de passe : ')
      ->addInput('password', 'password', ['id' => 'password', 'class' => 'input_class_update_user', 'value' =>  $password, 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_form_update_user'])
      ->addSelect('roleId', $roles, ['required', 'id' => 'roleId', 'class' => 'input_class_update_user'])
      ->endDiv()
      ->startDiv(['id' => 'div_id_update_user', 'class' => 'div_class_update_user'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'id' => 'btn_update_user'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * Update user
   */
  public function updateUser(int $userId)
  {
    if (isset($_POST['save_changes'])) {
      $username = $_POST['username'];
      $password = $_POST['password']; 
      $email = $_POST['email'];
      $roleId = $_POST['roleId'];

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $userModel = new UserModel;
      $userModel->findOneById($userId);

      $userModel->setUsername($username)
        ->setEmail($email)
        ->setPassword($hashedPassword)
        ->setIdRole($roleId);

      $updateResult = $userModel->update($userId);

      if ($updateResult) {
        header("Location: /adminUser");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification de l'utilisateur.";
      }
    }

    Header("Location: /adminUpdateUser");
    exit;
  }
}
