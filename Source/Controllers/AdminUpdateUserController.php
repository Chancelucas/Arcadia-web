<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Helpers\InputType;
use Source\Models\user\UserModel;
use Source\Helpers\SecurityHelper;
use Source\Controllers\AdminController;
use Source\Controllers\AdminUserController;
use Source\Helpers\FlashMessage;
use Source\Models\role\RoleModel;

class AdminUpdateUserController extends AdminController
{

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
      // $password = $user->getPassword();
      $role = $user->getIdRole();

      // Utilisez la méthode createForm pour générer le formulaire
      $updateUserForm = $this->createForm($userId, $username, $email, $role);

      return $updateUserForm;
    }
  }

  public function createForm($userId, $username, $email, $role)
  {
    $getRole = new AdminUserController;
    $rolesList = $getRole->getRolesFromDatabase();

    $form = new Form;

    $form->startForm('POST', "adminUpdateUser/updateUser/{$userId}", ['class' => 'form_update_user'])
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
      ->addInput('password', 'password', ['id' => 'password', 'class' => 'input_class_update_user', 'placeholder' =>  'Entrez un nouveau mot de passe', 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_form_update_user'])
      ->addSelect('roleId', $rolesList, ['required' => true, 'id' => 'roleId', 'class' => 'input_class_update_user', 'value' => $role])
      ->endDiv()
      ->startDiv(['id' => 'div_id_update_user', 'class' => 'div_class_update_user'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'class' => 'btn'])
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
      $username = SecurityHelper::sanitize(InputType::String, 'username');
      $password = SecurityHelper::sanitize(InputType::String, 'password');
      $email = SecurityHelper::sanitize(InputType::String, 'email');
      $roleId = SecurityHelper::sanitize(InputType::Int, 'roleId');

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
        FlashMessage::addMessage("Modification effectuer avec succes", 'success');
        return;
      } else {
        FlashMessage::addMessage("Une erreur s'est produite lors de la modification de l'utilisateur.", 'error');
      }
    }

    Header("Location: /adminUpdateUser");
    exit;
  }
}
