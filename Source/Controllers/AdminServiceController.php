<?php

namespace Source\Controllers;

use Source\Controllers\AdminController;

class AdminServiceController extends AdminController
{
    public function index()
    {
        $this->render('service/adminService', [], 'defaultSessionPage');
    }

}