<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\animal\AnimalModel;
use Source\Models\animal\FoodGivenModel;
use Source\Controllers\EmployeeController;
use Source\Models\report\AnimalReportModel;
use Source\Helpers\InputType;
use Source\Helpers\FlashMessage;
use Source\Helpers\SecurityHelper;

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

    $form->startForm('POST', 'employeeAnimalFeed', ['class' => 'form_animal_feed'])

      ->addSelect('animal', $animal, ['class' => 'select_animal_feed', 'required' => true])

      ->addBouton('Rechercher', ['type' => 'submit', 'value' => 'search', 'name' => '', 'class' => 'btn'])

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
      $animalId = SecurityHelper::sanitize(InputType::Int, 'animal');
      //$animalId = $_POST['animal'];
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
      $animalId =  SecurityHelper::sanitize(InputType::Int, 'animal');
      //$animalId = $_POST['animal'];
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

      $form->startForm('POST', "/employeeAnimalFeed/createGivenFood", ['class' => 'form_food_given', 'enctype' => 'multipart/form-data'])

        ->addLabelFor('for', 'A remplir par l\'employer', ['class' => 'label_good_given title_form_given_food'])

        ->addLabelFor('date', 'Date du repas : ', ['class' => 'label_good_given'])
        ->addInput('date', 'date', ['class' => 'input_food_given', 'required' => true])

        ->addLabelFor('hour', 'Heure du repas : ', ['class' => 'label_good_given'])
        ->addInput('time', 'hour', ['class' => 'input_food_given', 'required' => true])

        ->addLabelFor('food', 'Nourriture donnée : ', ['class' => 'label_good_given'])
        ->addInput('text', 'food', ['class' => 'input_food_given', 'required' => true])

        ->addLabelFor('quantity', 'Quantité donnée (en gramme) : ', ['class' => 'label_good_given'])
        ->addInput('text', 'quantity', ['class' => 'input_food_given', 'required' => true])

        ->addInput('hidden', 'animal', ['value' => $_POST['animal']])

        ->addBouton('Crée', ['type' => 'submit', 'value' => 'submit', 'name' => 'createGivenFood', 'class' => 'btn'])

        ->endForm();

      return $form->create();
    }
    return null;
  }

  public function createGivenFood()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createGivenFood'])) {
      $date = SecurityHelper::sanitize(InputType::Date, 'date');
      $hour = SecurityHelper::sanitize(InputType::Int, 'hour');
      $food = SecurityHelper::sanitize(InputType::String, 'food');
      $quantity = SecurityHelper::sanitize(InputType::Int, 'quantity');
      $idAnimal = SecurityHelper::sanitize(InputType::Int, 'animal');
      $employee = $_SESSION['user'];

      $existingDate = (new FoodGivenModel)->findOneByDateAndAnimal($date, $idAnimal);

      if (!is_null($existingDate)) {
        FlashMessage::addMessage("Un repas déjà était donner a la même date pour cette animal", 'error');
        $this->index();
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

          FlashMessage::addMessage("Le repas a bien était crée.", 'success');

        } catch (\Exception $e) {
          FlashMessage::addMessage("Une erreur s'est produite lors de la création du repas", 'error');
        }
      }
    } else {
      FlashMessage::addMessage("Aucun compte rendu n'a été renseigné", 'error');
    }

    $this->index();
    exit;
  }
}
