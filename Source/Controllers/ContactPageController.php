<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class ContactPageController extends Controller
{
    /**
     * Displays homePage
     * 
     */
    public function index()
    {
        $this->render('Page/contactPage');
    }
}