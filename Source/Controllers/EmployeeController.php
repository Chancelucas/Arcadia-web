<?php

namespace Source\Controllers;

use Source\Controllers\BackController;


/**
 * Controller princial for admin part
 * 
 */

abstract class EmployeeController extends BackController
{
  function __construct()
  {
    parent::__construct();

    if (!$this->isEmployee()) {
      header('Location: /login');
    }
  }
  /**
   * Show admin template (navbar & footer)
   */
  public function render(string $file, array $data = [], string $template = 'defaultEmployeePage')
  {

    $data['user'] = $this->user;

    extract($data);

    ob_start();

    require_once ROOT . '/Source/Views/Session/' . $file . '.php';

    $containe = ob_get_clean();

    require_once ROOT . '/Source/Views/Session/' . $template . '.php';
  }


}
