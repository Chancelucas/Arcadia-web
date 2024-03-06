<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class ServicesPageController extends Controller
{
    /**
     * Displays Public ServicesPageController
     * 
     */
    public function index()
    {
        $this->render('Page/servicesPage');
    }
}
