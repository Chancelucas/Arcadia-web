<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\AssessmentModel;

class VetUpdateReportAnimalController extends VetController
{
  /**
   * Show all animal en BDD with form create animal. 
   */
  public function index()
  {
    $animalReportForm = $this->getOneAnimalReport();
    $this->render('animal/vetUpdateAnimal', ['animalReportForm' => $animalReportForm]);
  }

  public function getOneAnimalReport()
  {
    if (isset($_POST['id_AnimalReport'])) {
      $animalReportId = intval($_POST['id_AnimalReport']);

      $animalReportModel = new AnimalReportModel;
      $animalReport = $animalReportModel->findOneById($animalReportId);


      $breed = $animalReport->getAnimalBreed();
      $proposedFood = $animalReport->getProposedFood();
      $foodAmount = $animalReport->getFoodAmount();
      $passageDate = $animalReport->getPassageDate();
      $stateDetail = $animalReport->getStateDetail();

      $animalForm = $this->createForm($animalReportId, $breed, $proposedFood, $foodAmount, $passageDate, $stateDetail);

      return $animalForm;
    }
  }

  /**
   * Generate update user form
   */
  public function createForm($animalReportId, $breed, $proposedFood, $foodAmount, $passageDate, $stateDetail)
  {

    $getState = new AssessmentModel;
    $state = $getState->getAllNameState();

    $form = new Form;

    $form->startForm('POST', "vetUpdateAnimal/updateReportAnimal/{$animalReportId}", ['id' => '', 'enctype' => 'multipart/form-data'])

      ->addSelect('animal', $breed, ['class' => '', 'id' => '', '' => true])

      ->addLabelFor('state', 'Etat de l\'animal')
      ->addSelect('stateId', $state, ['class' => '', 'id' => '', 'required' => true])

      ->addLabelFor('proposed_food', 'Nourriture proposer')
      ->addInput('text', $proposedFood, ['class' => '', 'id' => '', 'required' => true])

      ->addLabelFor('food_amount', 'Grammage')
      ->addInput('text', $foodAmount, ['class' => '', 'id' => '', 'required' => true])

      ->addLabelFor('passage_date', 'Date du passage')
      ->addInput('date', $passageDate, ['class' => '', 'id' => '', 'required' => true])

      ->addLabelFor('state_detail', 'Information complémentaire')
      ->addTextarea('state_detail', $stateDetail, ['class' => '', 'id' => '', 'required' => true])

      ->addBouton('Enregister', ['type' => 'submit', 'value' => 'submit', 'id' => '', 'name' => 'save_changes', 'class' => ''])

      ->endForm();

    return $form->create();
  }

  /**
   * Update animal
   */
  public function updateReportAnimal(int $animalReportId)
  {
    if (isset($_POST['save_changes'])) {
      $breed = $_POST['animal'];
      $stateId = $_POST['stateId'];
      $proposedFood = $_POST['proposed_food'];
      $foodAmount = $_POST['food_amount'];
      $passageDate = $_POST['passage_date'];
      $stateDetail = $_POST['state_detail'];

      $animalReportModel = new AnimalReportModel;
      $animalReportModel->findOneById($animalReportId);
      $assessmentModel = new AssessmentModel;
      $assessmentModel->setState($stateId);

      $animalReportModel->setAnimalBreed($breed);
      $animalReportModel->setProposedFood($proposedFood);
      $animalReportModel->setFoodAmount($foodAmount);
      $animalReportModel->setPassageDate($passageDate);
      $animalReportModel->setStateDetail($stateDetail);

      $updateResult = $animalReportModel->update($animalReportId);

      if ($updateResult) {
        header("Location: /vetAnimal");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification du compte rendu de l'animal.";
      }
    }

    Header("Location: /vetUpdateAnimal");
    exit;
  }
}
