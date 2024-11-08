<?php

namespace Source\Controllers;

use Source\Controllers\Controller;
use Source\Models\service\ServiceModel;

class ServicesController extends Controller
{
  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $services = $this->getAllServices();
    $this->render('services/services', [
      'allServices' => $services,
    ]);
  }

  private function getAllServices()
  {
    $model = new ServiceModel;
    $allServices = $model->getAllServices();

    return $allServices;
  }

  public function page(int $idService)
  {
    $model = (new ServiceModel)->findBy(['id' => $idService])[0];

    $this->render('services/page', [
      'service' => $model
    ]);
  }

}
