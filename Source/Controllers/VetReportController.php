<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Helpers\InputType;
use Source\Helpers\SecurityHelper;
use Source\Controllers\VetController;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;
use Source\Helpers\FlashMessage;


class VetReportController extends VetController
{
  /**
   * Donne les données à la vue. 
   */
  public function index()
  {
    $createReportAnimalForm = $this->generateCreateReportAnimalForm();
    $createReportHabitatForm = $this->generateCreateReportHabitatForm();

    $this->render('report/report', [
      'createReportHabitatForm' => $createReportHabitatForm,
      'createReportAnimalForm' => $createReportAnimalForm
    ]);
  }

  private function getAllAssessment()
  {
    $model = new AssessmentModel;
    $habitats = $model->getAllNameState();

    return $habitats;
  }

  private function getHabitatsFromDatabase()
  {
    $model = new HabitatModel;
    $habitats = $model->getAllNameHabitat();

    return $habitats;
  }


  ////////////////////// REPORT HABITAT ///////////////////

  /**
   * Formulaire report habitat
   */
  private function generateCreateReportHabitatForm()
  {
    $state = $this->getAllAssessment();
    $habitats = $this->getHabitatsFromDatabase();

    $form = new Form;

    $form->startForm('POST', 'vetReport/createHabitatReport', ['class' => 'form_create_report_vet', 'enctype' => 'multipart/form-data'])

      // Ajoute les erreurs éventuelles
      ->addError('date', $this->error)
      ->addError('habitat', $this->error)
      ->addError('opinion', $this->error)
      ->addError('state', $this->error)
      ->addError('improvement', $this->error)

      // Ajout du champ de sélection 
      ->addInput('date', 'date', ['class' => 'input_create_report_vet', 'required' => true])

      ->addSelect('habitat', $habitats, ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('opinion', 'Avis du vétérinaire', ['class' => 'label_create_report_vet'])
      ->addSelect('opinion', $state, ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('state', 'Etat de l\'habitat', ['class' => 'label_create_report_vet'])
      ->addSelect('state', $state, ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('improvement', 'Amélioration à apporté', ['class' => 'label_create_report_vet'])
      ->addTextarea('improvement', '', ['class' => 'input_create_report_vet',  'required' => true])

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createReportHabitat', 'class' => 'btn'])

      ->endForm();

    return $form->create();
  }

  /**
   * Création habitat report
   */
  public function createHabitatReport()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createReportHabitat'])) {

      $opinion = SecurityHelper::sanitize(InputType::Int, 'opinion');
      $state = SecurityHelper::sanitize(InputType::Int, 'state');
      $date = SecurityHelper::sanitize(InputType::Date, 'date');
      $idHabitat = SecurityHelper::sanitize(InputType::Int, 'habitat');
      $improvement = SecurityHelper::sanitize(InputType::Int, 'improvement');

      $existingReportDate = (new HabitatReportModel)->findOneByDate($date);
      $existingReportHabitat = (new HabitatReportModel)->findOneByIdHabitat($idHabitat);

      if (!is_null($existingReportDate) && !is_null($existingReportHabitat)) {
        FlashMessage::addMessage("Le rapport existe déjà", 'error');
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
          FlashMessage::addMessage("le compte rendu a été créé avec succès.", 'success');
        } catch (\Exception $e) {
          FlashMessage::addMessage("Une erreur s'est produite lors de la création de du compte rendu", 'error');
        }
      }
    } else {
      FlashMessage::addMessage("Aucun compte rendu n'a été renseigné", 'warning');
    }
    $this->index();
    //header("Location: /vetHabitat");
    exit;
  }

  /**
   * Delete One Habitat
   */
  public function deleteReportHabitat()
  {
    if (isset($_POST['deleteReportHabitat'])) {
      $habitatReportId = $_POST['habitatReportId'];
      $reportHabitatModel = new HabitatReportModel;
      $reportHabitatModel->setId($habitatReportId);
      $deleteReportHabitat = $reportHabitatModel->delete();

      if ($deleteReportHabitat) {
      FlashMessage::addMessage("Le rapport de l'habitat a été supprimé avec succès.", 'success');

      } else {
      FlashMessage::addMessage("Une erreur s'est produite lors de la suppression du rapport de l'habitat.", 'error');
      }
    }
    $this->index();
    //header("Location: /vetHabitat");
    exit;
  }


  ////////////////////// REPORT ANIMAL ///////////////////////////

  private function generateCreateReportAnimalForm()
  {
    $state = $this->getAllAssessment();
    $animals = $this->getAllAnimalsFromDatabase();

    $form = new Form;

    $form->startForm('POST', 'vetReport/createAnimalReport', ['class' => 'form_create_report_vet', 'enctype' => 'multipart/form-data'])


      ->addSelect('animal', $animals, ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('state', 'Etat de l\'animal', ['class' => 'label_create_report_vet'])
      ->addSelect('state', $state, ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('proposed_food', 'Nourriture proposer', ['class' => 'label_create_report_vet'])
      ->addInput('text', 'proposed_food', ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('food_amount', 'Grammage', ['class' => 'label_create_report_vet'])
      ->addInput('text', 'food_amount', ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('passage_date', 'Date du passage', ['class' => 'label_create_report_vet'])
      ->addInput('date', 'passage_date', ['class' => 'input_create_report_vet', 'required' => true])

      ->addLabelFor('state_detail', 'Information complémentaire', ['class' => 'label_create_report_vet'])
      ->addTextarea('state_detail', '', ['class' => 'input_create_report_vet', 'required' => true])

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createReportAnimal', 'class' => 'btn'])

      ->endForm();

    return $form->create();
  }

  /**
   * Function create Animal Report
   */
  public function createAnimalReport()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createReportAnimal'])) {
      $idAnimal = SecurityHelper::sanitize(InputType::Int, 'animal');
      $state = SecurityHelper::sanitize(InputType::Int, 'state');
      $proposed_food = SecurityHelper::sanitize(InputType::String, 'proposed_food');
      $food_amount = SecurityHelper::sanitize(InputType::Int, 'food_amount');
      $passage_date = SecurityHelper::sanitize(InputType::Date, 'passage_date');
      $state_detail = SecurityHelper::sanitize(InputType::Int, 'state_detail');


      $existingReportDate = (new HabitatReportModel)->findOneByDate($passage_date);
      $existingReportIdAnimal = (new AnimalReportModel)->findOneByIdAnimal($idAnimal);


      if (!$food_amount) {
        $this->error["food_amount"] = "Les commentaires doivent être remplis";
      } else if (strlen($food_amount) > 255) {
        $this->error["food_amount"] = "Le commentaire est trop long, 255 caractères maximum!";
      }

      if (!is_null($existingReportDate) && !is_null($existingReportIdAnimal)) {
        FlashMessage::addMessage("Rapport déjà existant", 'error');
        $this->index();
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

          FlashMessage::addMessage("le compte rendu a été créé avec succès.", 'success');

        } catch (\Exception $e) {
          FlashMessage::addMessage("Une erreur s'est produite lors de la création du compte rendu", 'warning');
        }
      }
    } else {
      FlashMessage::addMessage("Aucun compte rendu n'a été renseigné", 'error');
    }
    $this->index();
    //header("Location: /vetAnimal");
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

  /**
   * Delete One animal
   */
  public function deleteReportAnimal(int $animalReportId)
  {
    if (isset($_POST['deleteReportAnimal'])) {
      $reportAnimalModel = new AnimalReportModel;
      $reportAnimalModel->setId($animalReportId);
      $deleteReportAnimal = $reportAnimalModel->delete();

      if ($deleteReportAnimal) {
      FlashMessage::addMessage("Le rapport de l'animal à était supprimé avec succès.", 'success');
      } else {
      FlashMessage::addMessage("Une erreur s'est produite lors de la suppression du rapport de l'animal.", 'error');
      }
    }
    $this->index();

    //Header("Location: /vetAnimal");
    exit;
  }
}
