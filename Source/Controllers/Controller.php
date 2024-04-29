<?php

namespace Source\Controllers;

/**
 * Controller princial for web site
 * 
 */

abstract class Controller
{



  public function render(string $file, array $data = [], string $template = 'defaultPublicPage')
  {

    extract($data);

    ob_start();

    require_once ROOT . '/Source/Views/Public/' . $file . '.php';

    $containe = ob_get_clean();

    require_once ROOT . '/Source/Views/Public/' . $template . '.php';
  }
}
