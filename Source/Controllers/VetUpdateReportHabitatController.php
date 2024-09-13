<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\HabitatReportModel;
use function Source\Helpers\securityHTML;

class VetUpdateReportHabitatController extends VetController
{
  /**
   * Show all animal en BDD with form create animal. 
   */
  public function index(int $id)
  {
    $habitatReportModel = new HabitatReportModel;
    $habitatReport = $habitatReportModel->findOneById($id);

    $habitatName = $habitatReport->getIdHabitat();
    $opinion = $habitatReport->getAssessmentOpinonId();
    $state = $habitatReport->getAssessmentStateId();
    $date = $habitatReport->getDate();
    $improvement = $habitatReport->getImprovement();

    $habitatReportForm = $this->createForm($id, $habitatName, $opinion, $date, $state, $improvement);

    $this->render('habitat/vetUpdateHabitat', [
      'habitatReportForm' => $habitatReportForm
    ]);
  }

  /**
   * Generate update user form
   */
  public function createForm($idHabitatReport, $habitatName, $opinion, $date, $state, $improvement)
  {
    $stateList = (new AssessmentModel)->getAllNameState();
    $habitatModelList = (new HabitatModel)->getAllNameHabitat();

    $form = new Form;

    $form->startForm('POST', "/vetUpdateReportHabitat/updateReportHabitat/{$idHabitatReport}", ['class' => 'form_update_report_vet'])

      ->addSelect('habitat', $habitatModelList, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $habitatName])

      ->addLabelFor('state', 'Etat de l\'habitat')
      ->addSelect('stateId', $stateList, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $state])

      ->addLabelFor('opinion', 'Avis du vétérinaire')
      ->addSelect('opinionId', $stateList, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $opinion])

      ->addLabelFor('passage_date', 'Date du passage')
      ->addInput('date', 'passage_date', ['class' => 'label_update_report_vet', 'required' => true, 'value' => $date])

      ->addLabelFor('improvement', 'Information complémentaire')
      ->addTextarea('improvement', $improvement, ['class' => 'label_update_report_vet', 'required' => true])

      ->addBouton('Enregister', ['type' => 'submit', 'value' => 'submit', 'name' => 'save_changes', 'class' => 'btn'])

      ->endForm();

    return $form->create();
  }

  /**
   * Update animal
   */
  public function updateReportHabitat(int $idHabitatReport)
  {
    if (isset($_POST['save_changes'])) {
      // $habitat = $_POST['habitat'];
      // $state = $_POST['stateId'];
      // $opinion = $_POST['opinionId'];
      // $date = $_POST['passage_date'];
      // $improvement = $_POST['improvement'];
      $habitat = filter_input(INPUT_POST, 'habitat', FILTER_SANITIZE_NUMBER_INT);
      $state = filter_input(INPUT_POST, 'stateId', FILTER_SANITIZE_NUMBER_INT);
      $opinion = filter_input(INPUT_POST, 'opinionId', FILTER_SANITIZE_NUMBER_INT);
      $date = securityHTML(strip_tags($_POST['passage_date']), ENT_QUOTES, 'UTF-8');
      $improvement = securityHTML(strip_tags($_POST['improvement']), ENT_QUOTES, 'UTF-8');

      $dateFormatValid = preg_match('/^\d{4}-\d{2}-\d{2}$/', $date); // AAAA-MM-JJ

      // var_dump();
      // die;

      if (
        $habitat && $state && $opinion && $date && $improvement &&
        strlen($improvement) <= 255 &&
        $dateFormatValid
      ) {
        $habitatReportModel = new HabitatReportModel;
        $habitatReportModel->findOneById($idHabitatReport);

        $habitatReportModel->setIdHabitat($habitat);
        $habitatReportModel->setOpinion($opinion);
        $habitatReportModel->setState($state);
        $habitatReportModel->setDate($date);
        $habitatReportModel->setImprovement($improvement);

        $updateResult = $habitatReportModel->update();

        if ($updateResult) {
          header("Location: /vetHabitat");
          exit;
        } else {
          $_SESSION['error'] = "Une erreur s'est produite lors de la modification du compte rendu de l'animal.";
        }
      } else {
        $_SESSION['error'] = "Tu as fait de la merde dans le formulaire frérot ! ";
      }
    }

    Header("Location: /vetUpdateReportHabitat/index/" . $idHabitatReport);
    exit;
  }
}
