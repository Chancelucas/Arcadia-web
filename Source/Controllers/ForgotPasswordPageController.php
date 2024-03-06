<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class ForgotPasswordPageController extends Controller
{
    /**
     * Displays homePage
     * 
     */
    public function index()
    {
        $this->render('Page/forgotPasswordPage');
    }
}