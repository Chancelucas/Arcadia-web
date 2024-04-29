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
    $this->render('main/welcome');
  }
}
