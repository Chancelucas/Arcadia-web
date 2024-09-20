<?php

namespace Source\Controllers;

use Source\Models\user\UserModel;

/**
 * Controller princial for BO part
 * 
 */

abstract class BackController
{
  protected $user;
  protected $error = [];


  function __construct()
  {
    $user = new UserModel;
    $user->fromSession();

    $this->user = $user;

    if (!$this->isAuthenticated()) {
      header('Location: /login');
    }
  }

  protected function isAuthenticated()
  {
    return isset($_SESSION) && isset($_SESSION['user']) && isset($this->user) && !empty($this->user->getId());
  }

  protected function isAdmin()
  {
    return $this->user->getRole() === "Admin";
  }

  protected function isVeto()
  {
    return $this->user->getRole() === "Vétérinaire";
  }

  protected function isEmployee()
  {
    return $this->user->getRole() === "Employer";
  }
}
