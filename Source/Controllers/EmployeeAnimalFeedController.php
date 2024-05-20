<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\EmployeeController;
use Source\Models\animal\AnimalModel;
use Source\Models\report\AnimalReportModel;

class EmployeeAnimalFeedController extends EmployeeController
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $selectAnimalForm = $this->generateCreateSelectAnimalForm();
    $reportAnimal = $this->showAllReportsAboutOneAnimal();
    $animalsBreed = $this->showAnimalBreed();

    $this->render('feed/employeeAnimalFeed', [
      'selectAnimalForm' => $selectAnimalForm, 
      'reportAnimal' => $reportAnimal,
      'animalsBreed' => $animalsBreed
    ]);
  }

  /**
   * Function with form for create REPORT HABITAT
   */
  private function generateCreateSelectAnimalForm()
  {
    $animal = $this->getAllAnimalsFromDatabase();

    $form = new Form;

    $form->startForm('POST', 'employeeAnimalFeed', ['id' => 'form_report_habitat', 'enctype' => 'multipart/form-data'])

      ->addSelect('animal', $animal, ['class' => 'select_animal', 'id' => '', 'required' => true])

      ->addBouton('Rechercher', ['type' => 'submit', 'value' => 'search', 'id' => 'btn_search_animal_report', 'name' => '', 'class' => ''])

      ->endForm();

    return $form->create();
  }

  /**
   * Get all animal Breed
   */
  public function getAllAnimalsFromDatabase()
  {
    $animalsBreed = (new AnimalModel)->getAllBreedAnimals();

    return $animalsBreed;
  }

  public function getAllAnimalsReports()
  {
   $animalsReports = (new AnimalReportModel)->getAllAnimalsReports();

   return $animalsReports;
  }

  public function getAnimalReports($animalId)
  {
    return (new AnimalReportModel)->getReportsByAnimalId($animalId);
  }

  /**
   * Show all reports about the selected animal
   */
  public function showAllReportsAboutOneAnimal()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animal'])) {
      $animalId = $_POST['animal'];
      return $this->getAnimalReports($animalId);
    }

    return null;
  }

  /**
   * Show the breed of the selected animal
   */
  public function showAnimalBreed()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animal'])) {
      $animalId = $_POST['animal'];
      $animalModel = new AnimalModel();
      $animal = $animalModel->findOneById($animalId);
      return $animal ? $animal->getBreed() : 'Race inconnue';
    }
    return null;
  }

  
}
