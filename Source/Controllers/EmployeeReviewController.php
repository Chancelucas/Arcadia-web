<?php

namespace Source\Controllers;

class EmployeeReviewController extends EmployeeController
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $this->render('review/employeeReview', []);
  }
}
