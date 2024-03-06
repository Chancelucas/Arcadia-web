<?php

namespace Source\Controllers;

class MainController extends Controller
{

    /**
     * Displays WelcomPage
     * 
     */
    public function index()
    {
        
        $this->render('Page/welcomePage');

        // POUR AVOIR DEUX TEMPLATE
        // $this->render('Page/welcomePage', [], 'home');


    }
}