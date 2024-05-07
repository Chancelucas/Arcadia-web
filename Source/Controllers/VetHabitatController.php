<?php

namespace Source\Controllers;

use Source\Controllers\VetController;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\HabitatReportModel;

class VetHabitatController extends VetController
{

  public function index()
  {
    $reportsHabitat = $this->getAllHabitatReport();

    $this->render('habitat/vetHabitat', ['reportsHabitat' => $reportsHabitat]);
  }

  /**
   * Get all user with role(label) on database
   */
  private function getAllHabitatReport()
  {
    $model = new HabitatReportModel;
    $habitatsReportModel = $model->getAll();

    $allHabitatReport = [];
    
    foreach ($habitatsReportModel as $habitatReportModel) {
      $habitatReport = new \stdClass();
      $habitatReport->id_Report = $habitatReportModel->getIdReport();
      $habitatReport->opinion = $habitatReportModel->getOpinion();
      $habitatReport->state = $habitatReportModel->getState();
      $habitatReport->improvement = $habitatReportModel->getImprovement();
      $habitatReport->date = $habitatReportModel->getDate();
      $habitatReport->id_habitat = $habitatReportModel->getIdHabitat();

      $allHabitatReport[] = $habitatReport;
    }

    return $allHabitatReport;
  }

}