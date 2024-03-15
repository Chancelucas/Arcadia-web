<?php

namespace Source\Controllers;

class HomeController extends Controller
{

    /**
     * Displays WelcomPage
     * 
     */
    public function index()
    {
        $this->render('home/home', [] , 'defaultPublicPage');
    }
}