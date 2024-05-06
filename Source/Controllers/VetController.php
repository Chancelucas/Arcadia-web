<?php

namespace Source\Controllers;


/**
 * Controller princial for admin part
 * 
 */

abstract class VetController
{

  /**
   * Show admin template (navbar & footer)
   */
  public function render(string $file, array $data = [], string $template = 'defaultVetPage')
  {

    extract($data);

    ob_start();

    require_once ROOT . '/Source/Views/Session/' . $file . '.php';

    $containe = ob_get_clean();

    require_once ROOT . '/Source/Views/Session/' . $template . '.php';
  }


}
