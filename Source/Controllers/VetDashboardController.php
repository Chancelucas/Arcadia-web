<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;

class VetDashboardController extends VetController
{

  /**
   * Index function on Admin Dashboard Controller
   */
  public function index()
  {
    $this->generateLogoutForm();
  }

  /**
   * Function logout [session = 'user']
   */
  public function logout()
  {
    session_destroy();
    header("Location: /login");
    exit;
  }

  /**
   * Form for logout session
   */
  private function generateLogoutForm()
  {
    $form = new Form;

    $form->startForm('POST', 'vetDashboard/logout')
      ->addBouton('Déconnexion', ['type' => 'submit'])
      ->endForm();

    $this->render('dashboard/vetDashboard', ['logoutForm' => $form->create()]);
  }
}


