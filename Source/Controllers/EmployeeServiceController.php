<?php

namespace Source\Controllers;

use Source\Models\service\ServiceModel;

class EmployeeServiceController extends EmployeeController
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $services = $this->getAllService();

    $this->render('service/employeeService', [
      'services' => $services
    ]);
  }

  public function getAllService()
  {
    $allServices = (new ServiceModel)->getAllServices();


    return $allServices;
  }
}
