<?php

namespace Source\Controllers;

class ServicesController extends Controller
{

    /**
     * Displays WelcomPage
     * 
     */
    public function index()
    {
        $this->render('services/services', [] , 'defaultPublicPage');
    }
}