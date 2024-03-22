<?php

namespace Source\Controllers;

/**
 * Controller princial for admin part
 * 
 */

abstract class AdminController
{

    public function index()
    {
        // SESSION ??
        return true;
        return false;
    }

    public function render(string $file, array $data = [], string $template = 'defaultSessionPage')
    {

        extract($data);

        ob_start();

        require_once ROOT . '/Source/Views/Session/' . $file . '.php';

        $containe = ob_get_clean();

        require_once ROOT . '/Source/Views/Session/' . $template . '.php';
    }
}
