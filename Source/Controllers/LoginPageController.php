<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class LoginPageController extends Controller
{
    /**
     * Displays homePage
     * 
     */
    public function index()
    {
        $this->render('Page/loginPage');
    }
}