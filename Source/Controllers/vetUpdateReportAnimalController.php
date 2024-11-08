<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;
use Source\Models\animal\AnimalModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\AnimalReportModel;
use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;

class VetUpdateReportAnimalController extends VetController
{
  /**
   * Donne les données à la vue. 
   */
  public function index(int $id)
  {
    // Vérifie si des changements ont été soumis via le formulaire
    if (isset($_POST['save_changes'])) {
      // Récupère les données saisies dans le formulaire
      $breed = $_POST['animal'];
      $state = $_POST['stateId'];
      $proposedFood = $_POST['proposed_food'];
      $foodAmount = $_POST['food_amount'];
      $passageDate = $_POST['passage_date'];
      $stateDetail = $_POST['state_detail'];
    } else {
      // Si aucune soumission, récupère les données existantes du compte rendu pour le formulaire
      $animalReportModel = new AnimalReportModel;
      $animalReport = $animalReportModel->findOneById($id);
      // Récupération des valeurs existantes pour peupler le formulaire
      $breed = $animalReport->getAnimalBreed();
      $state = $animalReport->getAssessmentStateId();
      $proposedFood = $animalReport->getProposedFood();
      $foodAmount = $animalReport->getFoodAmount();
      $passageDate = $animalReport->getPassageDate();
      $stateDetail = $animalReport->getStateDetail();
    }

    // Création du formulaire de mise à jour
    $animalReportForm = $this->createForm($id, $breed, $state, $proposedFood, $foodAmount, $passageDate, $stateDetail);

    // Rend la vue pour afficher le formulaire de mise à jour
    $this->render('animal/vetUpdateAnimal', [
      'animalReportForm' => $animalReportForm,
      'error' => $this->error

    ]);
  }

  /**
   * Génère le formulaire de mise à jour.
   */
  public function createForm($idAnimalReport, $breed, $state, $proposedFood, $foodAmount, $passageDate, $stateDetail)
  {
    // Récupère les listes des états et des animaux pour les sélections du formulaire
    $stateModel = (new AssessmentModel)->getAllNameState();
    $breedModel = (new AnimalModel)->getAllBreedAnimals();
    $form = new Form;

    $form->startForm('POST', "/vetUpdateReportAnimal/updateReportAnimal/{$idAnimalReport}", ['class' => 'form_update_report_vet', 'enctype' => 'multipart/form-data'])

      // Ajoute les erreurs éventuelles
      ->addError('animal', $this->error)
      ->addError('state', $this->error)
      ->addError('proposed_food', $this->error)
      ->addError('food_amount', $this->error)
      ->addError('date', $this->error)
      ->addError('state_detail', $this->error)

      // Ajout du champ de sélection 
      ->addSelect('animal', $breedModel, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $breed])

      ->addLabelFor('state', 'Etat de l\'animal')
      ->addSelect('stateId', $stateModel, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $state])

      ->addLabelFor('proposed_food', 'Nourriture proposer')
      ->addInput('text', 'proposed_food', ['class' => 'label_update_report_vet', 'required' => true, 'value' => $proposedFood])

      ->addLabelFor('food_amount', 'Grammage')
      ->addInput('text', 'food_amount', ['class' => 'label_update_report_vet', 'required' => true, 'value' => $foodAmount])

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
    // Vérifie si des changements ont été soumis via le formulaire
    if (isset($_POST['save_changes'])) {

      // Nettoie les entrées du formulaire pour éviter les injections ou erreurs
      $breed = SecurityHelper::sanitize(InputType::Int, 'animal');
      $stateId = SecurityHelper::sanitize(InputType::Int, 'stateId');
      $proposedFood = SecurityHelper::sanitize(InputType::String, 'proposed_food');
      $foodAmount = SecurityHelper::sanitize(InputType::Int, 'food_amount');
      $passageDate = SecurityHelper::sanitize(InputType::Date, 'passage_date');
      $stateDetail = SecurityHelper::sanitize(InputType::String, 'state_detail');

      // Vérifie la validité des données et ajoute des messages d'erreur si nécessaire
      if (!$breed) {
        $this->error["animal"] = "L'animal séléctioné n'existe pas";
      }
      if (!$stateId) {
        $this->error["stateId"] = "L'etat de l'animal est inconnue";
      }
      if (!$proposedFood) {
        $this->error["proposed_food"] = "La nourriture proposer n'ai pas valide";
      }
      if (!$foodAmount) {
        $this->error["food_amount"] = "La quantité donnée n'ai pas bonne";
      }
      if (!$passageDate) {
        $this->error["passage_date"] = "Date absente ou mal formatée (JJ/MM/AAAA)";
      }
      if (!$stateDetail) {
        $this->error["passage_date"] = "Les commentaires doivent être remplis";
      }

      // Si toutes les données sont valides, procède à la mise à jour
      if (
        $breed && $stateId && $proposedFood && $foodAmount && $passageDate && strlen($stateDetail) <= 255
      ) {
        // Récupère le modèle du compte rendu et le met à jour avec les nouvelles valeurs
        $animalReportModel = new AnimalReportModel;
        $animalReportModel->findOneById($idAnimalReport);
        $assessmentModel = new AssessmentModel;
        $assessmentModel->setState($stateId);

        $animalReportModel->setAnimalBreed($breed);
        $animalReportModel->setProposedFood($proposedFood);
        $animalReportModel->setFoodAmount($foodAmount);
        $animalReportModel->setPassageDate($passageDate);
        $animalReportModel->setStateDetail($stateDetail);

        // Sauvegarde les changements dans la base de données
        $updateResult = $animalReportModel->update($idAnimalReport);

        // Si la mise à jour est réussie, redirige l'utilisateur
        if ($updateResult) {
          header("Location: /vetAnimal");
          exit;
        } else {
          // Sinon, affiche un message d'erreur pour l'utilisateur
          $this->error["db"] = "Une erreur s'est produite lors de la modification du compte rendu de l'animal.";
        }
      } else {
        // Si des champs ne sont pas valides, affiche un message d'erreur général
        $this->error["form"] = "Formulaire incomplet";
      }
    }
    // Si la mise à jour échoue ou s'il manque des informations, retourne à la vue du formulaire
    $this->index($idAnimalReport);
  }
}
