<?php

namespace Source\Controllers;

use Source\Controllers\AdminController;
use Source\Controllers\LoginController;

class AdminDashboardController extends AdminController
{
    
    /**
     * Index function on Admin Dashboard Controller
     */
    public function index()
    {
        $logout = $this->logout(); 
        $this->render('dashboard/adminDashboard', ['logout' => $logout]);
    }

    /**
     * Function logout [session = 'user']
     */
    public function logout()
    {
        session_destroy();
    }
}
