<?php

namespace Source\Controllers;

use Source\Controllers\AdminController;

class AdminAnimalController extends AdminController
{
    public function index()
    {
        $this->render('animal/adminAnimal', [], 'defaultSessionPage');
    }
}