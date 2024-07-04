<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\animal\AnimalModel;
use Source\Models\animal\FoodGivenModel;
use Source\Controllers\EmployeeController;
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
    $givenFoodForm = $this->generateCreateGivenFoodForm();

    $this->render('feed/employeeAnimalFeed', [
      'selectAnimalForm' => $selectAnimalForm,
      'reportAnimal' => $reportAnimal,
      'animalsBreed' => $animalsBreed,
      'givenFoodForm' => $givenFoodForm
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
  private function showAllReportsAboutOneAnimal()
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
  private function showAnimalBreed()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animal'])) {
      $animalId = $_POST['animal'];
      $animalModel = new AnimalModel();
      $animal = $animalModel->findOneById($animalId);
      return $animal ? $animal->getBreed() : 'Race inconnue';
    }
    return null;
  }

  private function generateCreateGivenFoodForm()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animal'])) {

      $form = new Form;

      $form->startForm('POST', "/employeeAnimalFeed/createGivenFood", ['id' => 'form_report_habitat', 'enctype' => 'multipart/form-data'])

        ->addLabelFor('for', 'A remplir par l\'employer : ')

        ->addLabelFor('date', 'Date du repas : ')
        ->addInput('date', 'date', ['class' => '', 'id' => '', 'required' => true])

        ->addLabelFor('hour', 'Heure du repas : ')
        ->addInput('time', 'hour', ['class' => '', 'id' => '', 'required' => true])

        ->addLabelFor('food', 'Nourriture donnée : ')
        ->addInput('text', 'food', ['class' => '', 'id' => '', 'required' => true])

        ->addLabelFor('quantity', 'Quantité donnée (en gramme) : ')
        ->addInput('text', 'quantity', ['class' => '', 'id' => '', 'required' => true])

        ->addInput('hidden', 'animal', ['value' => $_POST['animal']])

        ->addBouton('Crée', ['type' => 'submit', 'value' => 'submit', 'id' => '', 'name' => 'createGivenFood', 'class' => ''])

        ->endForm();

      return $form->create();
    }
    return null;
  }

  public function createGivenFood()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createGivenFood'])) {
      $date = $_POST['date'];
      $hour = $_POST['hour'];
      $food = $_POST['food'];
      $quantity = $_POST['quantity'];
      $idAnimal = $_POST['animal'];
      $employee = $_SESSION['user'];

      $existingDate = (new FoodGivenModel)->findOneByDateAndAnimal($date, $idAnimal);

      if (!is_null($existingDate)) {
        echo "Le repas existe déjà.";
        return;
      } else {
        try {
          $foodGiven = new FoodGivenModel;

          $foodGiven->setDay($date)
            ->setHour($hour)
            ->setFood($food)
            ->setQuantity($quantity)
            ->setIdAnimal($idAnimal)
            ->setIdUser($employee['id_user']);

          $foodGiven->createFoodGiven();

          $_SESSION['message'] = "le compte rendu a été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création de du compte rendu : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun compte rendu n'a été renseigné";
    }

    header("Location: /employeeFoodGiven");
    exit;
  }
}
