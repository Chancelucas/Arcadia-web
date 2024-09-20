<?php

namespace Source\Controllers;

use Source\Controllers\VetController;
use Source\Models\report\AnimalReportModel;
use Source\Helpers\securityHTML;

class VetAnimalController extends VetController
{

  public function index()
  {
    $animalsReport = $this->getAllAnimalReportFromModel();

    $this->render('animal/vetAnimal', [
      'animalsReport' => $animalsReport
    ]);
  }


  /**
   * Get all user with role(label) on database
   */
  private function getAllAnimalReportFromModel()
  {
    $model = new AnimalReportModel;
    $animalsReportModel = $model->getAllAnimalsReports();

    return $animalsReportModel;
  }

}