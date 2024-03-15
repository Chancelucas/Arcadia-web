<?php

namespace Source\Controllers;

class HabitatController extends Controller
{

    /**
     * Displays WelcomPage
     * 
     */
    public function index()
    {
        $this->render('habitat/habitat', [] , 'defaultPublicPage');
    }
}