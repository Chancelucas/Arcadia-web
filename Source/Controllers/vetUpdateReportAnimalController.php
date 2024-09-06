<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;
use Source\Models\animal\AnimalModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\AnimalReportModel;

class VetUpdateReportAnimalController extends VetController
{
  /**
   * Show all animal en BDD with form create animal. 
   */
  public function index(int $id)
  {

    $animalReportModel = new AnimalReportModel;
    $animalReport = $animalReportModel->findOneById($id);

    $breed = $animalReport->getAnimalBreed();
    $proposedFood = $animalReport->getProposedFood();
    $foodAmount = $animalReport->getFoodAmount();
    $passageDate = $animalReport->getPassageDate();
    $stateDetail = $animalReport->getStateDetail();

    $animalReportForm = $this->createForm($id, $breed, $proposedFood, $foodAmount, $passageDate, $stateDetail);

    $this->render('animal/vetUpdateAnimal', ['animalReportForm' => $animalReportForm]);
  }
  
  /**
   * Generate update user form
   */
  public function createForm($idAnimalReport, $breed, $proposedFood, $foodAmount, $passageDate, $stateDetail)
  {

    $state = (new AssessmentModel)->getAllNameState();
    $breedModel = (new AnimalModel)->getAllBreedAnimals();

    $form = new Form;

    $form->startForm('POST', "/vetUpdateReportAnimal/updateReportAnimal/{$idAnimalReport}", ['class' => 'form_update_report_vet', 'enctype' => 'multipart/form-data'])

      ->addSelect('animal', $breedModel, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $breed])

      ->addLabelFor('state', 'Etat de l\'animal')
      ->addSelect('stateId', $state, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $state])

      ->addLabelFor('proposed_food', 'Nourriture proposer')
      ->addInput('text', 'proposed_food', ['class' => 'label_update_report_vet', 'required' => true, 'value' => $proposedFood])

      ->addLabelFor('food_amount', 'Grammage')
      ->addInput('text', 'food_amount', ['class' => 'label_update_report_vet','required' => true, 'value' => $foodAmount])

      ->addLabelFor('passage_date', 'Date du passage')
      ->addInput('date', 'passage_date', ['class' => 'label_update_report_vet', 'required' => true, 'value' => $passageDate])

      ->addLabelFor('state_detail', 'Information complémentaire')
      ->addTextarea('state_detail', $stateDetail, ['class' => 'label_update_report_vet', 'required' => true])

      ->addBouton('Enregister', ['type' => 'submit', 'value' => 'submit', 'name' => 'save_changes', 'class' => 'btn'])

      ->endForm();

    return $form->create();
  }

  /**
   * Update animal
   */
  public function updateReportAnimal(int $idAnimalReport)
  {
    if (isset($_POST['save_changes'])) {
      $breed = $_POST['animal'];
      $stateId = $_POST['stateId'];
      $proposedFood = $_POST['proposed_food'];
      $foodAmount = $_POST['food_amount'];
      $passageDate = $_POST['passage_date'];
      $stateDetail = $_POST['state_detail'];

      $animalReportModel = new AnimalReportModel;
      $animalReportModel->findOneById($idAnimalReport);
      $assessmentModel = new AssessmentModel;
      $assessmentModel->setState($stateId);

      $animalReportModel->setAnimalBreed($breed);
      $animalReportModel->setProposedFood($proposedFood);
      $animalReportModel->setFoodAmount($foodAmount);
      $animalReportModel->setPassageDate($passageDate);
      $animalReportModel->setStateDetail($stateDetail);

      $updateResult = $animalReportModel->update($idAnimalReport);

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
