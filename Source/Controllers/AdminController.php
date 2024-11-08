<?php

namespace Source\Controllers;

use Source\Controllers\BackController;

/**
 * Controller princial for admin part
 * 
 */

abstract class AdminController extends BackController
{
  /**
   * Show admin template (navbar & footer)
   */

  function __construct()
  {
    parent::__construct();

    if (!$this->isAdmin()) {
      header('Location: /login');
    }
  }

  public function render(string $file, array $data = [], string $template = 'defaultAdminPage')
  {
    $data['user'] = $this->user;

    extract($data);

    ob_start();

    require_once ROOT . '/Source/Views/Session/' . $file . '.php';

    $containe = ob_get_clean();

    require_once ROOT . '/Source/Views/Session/' . $template . '.php';
  }
}
