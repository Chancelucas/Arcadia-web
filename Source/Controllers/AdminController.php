<?php

namespace Source\Controllers;

use Source\Models\user\UserModel;

/**
 * Controller princial for admin part
 * 
 */

abstract class AdminController
{
  protected $user;

  function __construct()
  {
    $user = new UserModel;
    $user->fromSession();

    $this->user = $user;
  }

  /**
   * Show admin template (navbar & footer)
   */
  public function render(string $file, array $data = [], string $template = 'defaultSessionPage')
  {
    if (!isset($this->user)) {
      header('Location: /login');
    }

    extract($data);

    ob_start();

    require_once ROOT . '/Source/Views/Session/' . $file . '.php';

    $containe = ob_get_clean();

    require_once ROOT . '/Source/Views/Session/' . $template . '.php';
  }

  protected function isAdmin()
  {
    return $this->user->getRole() === "Admin";
  }

  protected function isveto()
  {
    return $this->user->getRole() === "veto";
  }
  
  protected function isEmployee()
  {
    return $this->user->getRole() === "employé";
  }
}
