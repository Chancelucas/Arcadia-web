<?php

namespace Source\Controllers;

class ContactController extends Controller
{

  /**
   * Displays WelcomPage
   */
  public function index()
  {
    $this->render('contact/contact', [], 'defaultPublicPage');
  }
}
