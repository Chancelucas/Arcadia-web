<?php

namespace Source\Controllers;

use Source\Controllers\AdminController;
use Source\Controllers\LoginController;


class AdminDashboardController extends AdminController
{
    public function index()
    {
        //$logout = LoginController::logout(); 
        $this->render('dashboard/adminDashboard');
    }
}
