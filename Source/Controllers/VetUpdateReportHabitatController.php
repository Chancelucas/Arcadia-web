<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;

class VetUpdateReportHabitatController extends VetController
{
  /**
   * Show all animal en BDD with form create animal. 
   */
  public function index(int $id)
  {

    $habitatReportModel = new HabitatReportModel;
    $habitatReport = $habitatReportModel->findOneById($id);

    $habitatName = $habitatReport->getNameOfHabitat();
    $opinion = $habitatReport->getAssessmentOpinon();
    $state = $habitatReport->getAssessmentState();
    $date = $habitatReport->getDate();
    $improvement = $habitatReport->getImprovement();

    $habitatReportForm = $this->createForm($id, $habitatName, $opinion, $date, $state, $improvement);

    $this->render('habitat/vetUpdateHabitat', ['habitatReportForm' => $habitatReportForm]);
  }
  
  /**
   * Generate update user form
   */
  public function createForm($idHabitatReport, $habitatName, $opinion, $date, $state, $improvement)
  {

    $state = (new AssessmentModel)->getAllNameState();
    $habitatModel = (new HabitatModel)->getAllNameHabitat();

    $form = new Form;

    $form->startForm('POST', "/vetUpdateReportHabitat/updateReportHabitat/{$idHabitatReport}", ['id' => '', 'enctype' => 'multipart/form-data'])

      ->addSelect('habitat', $habitatModel, ['class' => '', 'id' => '', 'required' => true, 'value' => $habitatName])

      ->addLabelFor('state', 'Etat de l\'habitat')
      ->addSelect('stateId', $state, ['class' => '', 'id' => '', 'required' => true, 'value' => $state])

      ->addLabelFor('opinion', 'Etat de l\'animal')
      ->addSelect('opinionId', $state, ['class' => '', 'id' => '', 'required' => true, 'value' => $opinion])

      ->addLabelFor('passage_date', 'Date du passage')
      ->addInput('date', 'passage_date', ['class' => '', 'id' => '', 'required' => true, 'value' => $date])

      ->addLabelFor('improvement', 'Information complémentaire')
      ->addTextarea('improvement', $improvement, ['class' => '', 'id' => '', 'required' => true])

      ->addBouton('Enregister', ['type' => 'submit', 'value' => 'submit', 'id' => '', 'name' => 'save_changes', 'class' => ''])

      ->endForm();

    return $form->create();
  }

  /**
   * Update animal
   */
  public function updateReportHabitat(int $idHabitatReport)
  {
    if (isset($_POST['save_changes'])) {
      $habitat = $_POST['habitat'];
      $state = $_POST['stateId'];
      $opinion = $_POST['opinionId'];
      $date = $_POST['date'];
      $improvement = $_POST['improvement'];

      $habitatReportModel = new HabitatReportModel;
      $habitatReportModel->findOneById($idHabitatReport);
      $assessmentModel = new AssessmentModel;
      $assessmentModel->setState($state);

      $habitatReportModel->setIdHabitatReport($habitat);
      $habitatReportModel->setOpinion($opinion);
      $habitatReportModel->setDate($date);
      $habitatReportModel->setImprovement($improvement);

      $updateResult = $habitatReportModel->update($idHabitatReport);

      if ($updateResult) {
        header("Location: /vetHabitat");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification du compte rendu de l'animal.";
      }
    }

    Header("Location: /vetUpdateHabitat");
    exit;
  }
}
