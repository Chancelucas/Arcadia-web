<?php

namespace Source\Controllers;

use Source\Controllers\VetController;
use Source\Models\report\AnimalReportModel;

class VetAnimalController extends VetController
{

  public function index()
  {
    $reportsAnimal = $this->getAllAnimalReport();

    $this->render('animal/vetAnimal', ['reportsAnimal' => $reportsAnimal]);
  }


  /**
   * Get all user with role(label) on database
   */
  private function getAllAnimalReport()
  {
    $model = new AnimalReportModel;
    $animalsReportModel = $model->getAll();

    $allAnimalReport = [];
    
    foreach ($animalsReportModel as $animalReportModel) {
      $animalReport = new \stdClass();
      $animalReport->id_Report = $animalReportModel->getIdReport();
      $animalReport->state = $animalReportModel->getState();
      $animalReport->proposed_food = $animalReportModel->getProposedFood();
      $animalReport->food_amount = $animalReportModel->getFoodAmount();
      $animalReport->passage_date = $animalReportModel->getPassageDate();
      $animalReport->state_detail = $animalReportModel->getStateDetail();
      $animalReport->id_animal = $animalReportModel->getIdAnimal();


      $allAnimalReport[] = $animalReport;
    }

    return $allAnimalReport;
  }

}