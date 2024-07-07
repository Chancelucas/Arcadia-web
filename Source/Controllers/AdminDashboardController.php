<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\user\UserModel;

class AdminDashboardController extends AdminController
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

    $form->startForm('POST', 'adminDashboard/logout')
      ->addBouton('Déconnexion', ['type' => 'submit'])
      ->endForm();

    $this->render('dashboard/adminDashboard', [
      'logoutForm' => $form->create(),
    ]);
  }
}
