<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\EmployeeController;
use Source\Models\reviews\ReviewsModel;

class EmployeeDashboardController extends EmployeeController
{


  public function index()
  {
    $this->generateLogoutForm();
  }


  public function logout()
  {
    session_destroy();
    header("Location: /login");
    exit;
  }


  private function generateLogoutForm()
  {
    $form = new Form;

    $form->startForm('POST', 'employeeDashboard/logout')
      ->addBouton('Déconnexion', ['type' => 'submit'])
      ->endForm();

    $this->render('dashboard/employeeDashboard', [
      'logoutForm' => $form->create(),
      'user' => $this->user
    ]);
  }

 
}
