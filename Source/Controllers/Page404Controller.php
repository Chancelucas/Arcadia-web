<?php

namespace Source\Controllers;

class Page404Controller extends Controller
{

  public function index()
  {
    $this->render('404', []);
  }
}
