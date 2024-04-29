<?php

namespace Source\Models\user;

use Source\Models\MainModel;
use Source\Models\user\UserModel;

class LoginModel extends MainModel
{

  protected $table = 'User';
  protected $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  //authenticate
  public function authenticate(string $email, string $password)
  {
    $user = $this->userModel->findOneByEmail($email);

    if ($user && password_verify($password, $user->getPassword())) {

      $user->setSession();

      return true;
    }

    return false;
  }
}
