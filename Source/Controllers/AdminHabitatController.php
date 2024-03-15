<?php

namespace Source\Controllers;

use Source\Controllers\AdminController;

class AdminHabitatController extends AdminController
{

    public function index()
    {
        $this->render('habitat/adminHabitat', [], 'defaultSessionPage');
    }
}