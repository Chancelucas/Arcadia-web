<?php

namespace Source\Controllers;

use Source\Controllers\Controller;
use Source\Models\animal\AnimalModel;
use Source\Models\animal\FoodGivenModel;
use Source\Models\filter\FilterModel;
use Source\Models\report\AnimalReportModel;

class AnimalController extends Controller
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $animal = $this->getAllAnimal();

    $this->render('animal/animal', [
      'allHabitats' => $animal,

    ]);
  }

  private function getAllAnimal()
  {
    $model = new AnimalModel;
    $allAnimals = $model->getAllAnimals();

    return $allAnimals;
  }

  public function page(int $idAnimal)
  {
    $model = (new AnimalModel)->findBy(['id' => $idAnimal])[0];
    $reportOfVet = $this->getLastReportVet($idAnimal);
    $foodGiven = $this->getLastFoodGiven($idAnimal);

    $this->render('animal/page', [
      'animal' => $model,
      'report' => $reportOfVet,
      'food' => $foodGiven
    ]);
  }

  private function getLastElementByField($items, $field)
  {
    $model = new FilterModel;
    $lastElementModel = $model->getLastElementByField($items, $field);

    return $lastElementModel;
  }


  private function getLastReportVet($idAnimal)
  {
    $reportModel = new AnimalReportModel;
    $allReports = $reportModel->getReportsByAnimalId($idAnimal);

    return $this->getLastElementByField($allReports, 'passage_date');
  }

  private function getLastFoodGiven($idAnimal)
  {
    $foodGivenModel = new FoodGivenModel;
    $allFoodGiven = $foodGivenModel->getFoodGivenByAnimalId($idAnimal);

    return $this->getLastElementByField($allFoodGiven, 'food_given_date');
  }
}
