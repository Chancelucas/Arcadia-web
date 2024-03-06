<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class HomePageController extends Controller
{
    /**
     * Displays homePage
     * 
     */
    public function index()
    {
        $this->render('Page/homePage');
    }
}
