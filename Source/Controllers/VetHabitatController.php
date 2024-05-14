<?php

namespace Source\Controllers;

use Source\Controllers\VetController;
use Source\Models\report\HabitatReportModel;

class VetHabitatController extends VetController
{

  public function index()
  {
    $reportsHabitat = $this->getAllHabitatReportFromModel();


    $this->render('habitat/vetHabitat', ['reportsHabitat' => $reportsHabitat]);
  }

  /**
   * Get all user with role(label) on database
   */
  private function getAllHabitatReportFromModel()
  {
    $model = new HabitatReportModel;
    $habitatsReportModel = $model->getAllHabitatReport();

    return $habitatsReportModel;
  }
}