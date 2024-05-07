<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\MainModel;
use Source\Controllers\VetController;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;

class VetReportController extends VetController
{

  public function index()
  {
    $createReportAnimalForm = $this->generateCreateReportAnimalForm();
    $createReportHabitatForm = $this->generateCreateReportHabitatForm();


    $this->render('report/report', ['createReportHabitatForm' => $createReportHabitatForm, 'createReportAnimalForm' => $createReportAnimalForm]);
  }

  ////////////////////// REPORT HABITAT ///////////////////

  /**
   * Function with form for create Animal
   */
  private function generateCreateReportHabitatForm()
  {
    $state = ['Excellent', 'Moyen', 'Mauvais'];

    $habitats = $this->getHabitatsFromDatabase();

    $form = new Form;

    $form->startForm('POST', 'vetReport/createHabitatReport', ['id' => 'form_report_habitat', 'enctype' => 'multipart/form-data'])

      ->addInput('date', 'date', ['class' => 'input_report_habitat', 'id' => 'input_report_habitat', 'required' => true])

      ->addSelect('habitat', $habitats, ['class' => 'input_report_habitat', 'id' => 'input_report_habitat', 'required' => true])

      ->addLabelFor('opinion', 'Avis du vétérinaire')
      ->addSelect('opinion', $state, ['class' => 'input_report_habitat', 'id' => 'input_report_habitat_opinon', 'required' => true])

      ->addLabelFor('state', 'Etat de l\'habitat')
      ->addSelect('state', $state, ['class' => 'input_report_habitat', 'id' => 'input_report_habitat_state', 'required' => true])

      ->addLabelFor('improvement', 'Amélioration à apporté')
      ->addTextarea('improvement', '', ['class' => 'input_report_habitat', 'id' => 'input_report_habitat_improvement', 'required' => true])

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'btn_save_report_habitat', 'name' => 'createReportHabitat', 'class' => 'input_report_habitat'])

      ->endForm();

    return $form->create();
  }

  /**
   * Function create habitat report
   */
  public function createHabitatReport()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createReportHabitat'])) {
      $opinion = $_POST['opinion'];
      $state = $_POST['state'];
      $date = $_POST['date'];
      $idHabitat = $_POST['habitat'];
      $improvement = $_POST['improvement'];

      $existingReport = (new HabitatReportModel)->findOneByDate($date);

      if (!is_null($existingReport)) {
        echo "Le rapport existe déjà.";
        return;
      } else {

        try {
          $reportHabitat = new HabitatReportModel;

          $reportHabitat->setOpinion($opinion)
            ->setState($state)
            ->setDate($date)
            ->setIdHabitat($idHabitat)
            ->setImprovement($improvement);

          $reportHabitat->createReport();

          $_SESSION['message'] = "le compte rendu a été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création de du compte rendu : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun compte rendu n'a été renseigné";
    }

    header("Location: /vetHabitat");
    exit;
  }

  /** 
   * Function get all habitat on habitat model
  */
  private function getHabitatsFromDatabase()
  {
    $model = new HabitatModel;
    $habitats = $model->getAllNameHabitat();

    return $habitats;
  }

  ////////////////////// REPORT ANIMAL ///////////////////////////

  private function generateCreateReportAnimalForm()
  {
    $state = ['Excellent', 'Moyen', 'Mauvais'];

    $animals = $this->getAllAnimalsFromDatabase();


    $form = new Form;

    $form->startForm('POST', 'vetReport/createAnimalReport', ['id' => 'form_report_animal', 'enctype' => 'multipart/form-data'])


      ->addSelect('animal', $animals, ['class' => 'input_report_animal', 'id' => '', 'required' => true])

      ->addLabelFor('state', 'Etat de l\'animal')
      ->addSelect('state', $state, ['class' => 'input_report_animal', 'id' => 'input_report_animal_state', 'required' => true])

      ->addLabelFor('proposed_food', 'Nourriture proposer')
      ->addInput('text', 'proposed_food', ['class' => 'input_report_animal', 'id' => 'input_report_animal_food_amount', 'required' => true])

      ->addLabelFor('food_amount', 'Grammage')
      ->addInput('text', 'food_amount', ['class' => 'input_report_animal', 'id' => 'input_report_animal_proposed_food', 'required' => true])

      ->addLabelFor('passage_date', 'Date du passage')
      ->addInput('date', 'passage_date', ['class' => 'input_report_animal', 'id' => 'input_report_animal_proposed_food', 'required' => true])

      ->addLabelFor('state_detail', 'Information complémentaire')
      ->addTextarea('state_detail', '', ['class' => 'input_report_habitat', 'id' => 'input_report_habitat_improvement', 'required' => true])

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'btn_save_report_habitat', 'name' => 'createReportAnimal', 'class' => 'input_report_habitat'])

      ->endForm();

    return $form->create();
  }

  /**
   * Function create Animal Report
   */
  public function createAnimalReport()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createReportAnimal'])) {
      $idAnimal = $_POST['animal'];
      $state = $_POST['state'];
      $proposed_food = $_POST['proposed_food'];
      $food_amount = $_POST['food_amount'];
      $passage_date = $_POST['passage_date'];
      $state_detail = $_POST['state_detail'];


      $existingReport = (new HabitatReportModel)->findOneByDate($passage_date);

      if (!is_null($existingReport)) {
        echo "Le rapport existe déjà.";
        return;
      } else {

        try {
          $reportAnimal = new AnimalReportModel;

          $reportAnimal->setIdAnimal($idAnimal)
            ->setState($state)
            ->setProposedFood($proposed_food)
            ->setFoodAmount($food_amount)
            ->setPassageDate($passage_date)
            ->setStateDetail($state_detail);

          $reportAnimal->createReport();

          $_SESSION['message'] = "le compte rendu a été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création de du compte rendu : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun compte rendu n'a été renseigné";
    }

    header("Location: /vetAnimal");
    exit;
  }

  /**
   * Get all Animals 
   * 
   */
  public function getAllAnimalsFromDatabase()
  {
    $model = new AnimalModel;
    $animalsModel = $model->getAllBreedAnimals();

    return $animalsModel;
  }


}
