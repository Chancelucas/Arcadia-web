<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class HabitatPageController extends Controller
{
    /**
     * Displays homePage
     * 
     */
    public function index()
    {
        $this->render('Page/habitatPage');
    }
}