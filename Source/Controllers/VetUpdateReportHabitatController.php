<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;
use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\HabitatReportModel;

class VetUpdateReportHabitatController extends VetController
{

  /**
   * Donne les données à la vue
   */
  public function index(int $id)
  {
    // Vérifie si des changements ont été soumis via le formulaire
    if (isset($_POST['save_changes'])) {
      // Récupère les données saisies dans le formulaire
      $habitatName = $_POST['habitat'];
      $opinion = $_POST['opinionId'];
      $state = $_POST['stateId'];
      $date = $_POST['passage_date'];
      $improvement = $_POST['improvement'];
    } else {
      // Si aucune soumission, récupère les données existantes du compte rendu pour le formulaire
      $habitatReportModel = new HabitatReportModel;
      $habitatReport = $habitatReportModel->findOneById($id);
      // Récupération des valeurs existantes pour peupler le formulaire
      $habitatName = $habitatReport->getIdHabitat();
      $opinion = $habitatReport->getAssessmentOpinonId();
      $state = $habitatReport->getAssessmentStateId();
      $date = $habitatReport->getDate();
      $improvement = $habitatReport->getImprovement();
    }

    // Création du formulaire de mise à jour 
    $habitatReportForm = $this->createForm($id, $habitatName, $opinion, $date, $state, $improvement);

    // Rend la vue pour afficher le formulaire de mise à jour
    $this->render('habitat/vetUpdateHabitat', [
      'habitatReportForm' => $habitatReportForm,
      'error' => $this->error
    ]);
  }

  /**
   * Génère le formulaire de mise à jour.
   */
  public function createForm($idHabitatReport, $habitatName, $opinion, $date, $state, $improvement)
  {
    // Récupère les listes des états et des habitats pour les sélections du formulaire
    $stateList = (new AssessmentModel)->getAllNameState();
    $habitatModelList = (new HabitatModel)->getAllNameHabitat();
    $form = new Form;

    $form->startForm('POST', "/vetUpdateReportHabitat/updateReportHabitat/{$idHabitatReport}", ['class' => 'form_update_report_vet'])

      // Ajoute les erreurs éventuelles
      ->addError('habitat', $this->error)
      ->addError('opinion', $this->error)
      ->addError('state', $this->error)
      ->addError('date', $this->error)
      ->addError('improvement', $this->error)


      // Ajout du champ de sélection 
      ->addSelect('habitat', $habitatModelList, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $habitatName])

      ->addLabelFor('opinion', 'Avis du vétérinaire')
      ->addSelect('opinionId', $stateList, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $opinion])

      ->addLabelFor('state', 'Etat de l\'habitat')
      ->addSelect('stateId', $stateList, ['class' => 'label_update_report_vet', 'required' => true, 'value' => $state])

      ->addLabelFor('passage_date', 'Date du passage')
      ->addInput('date', 'passage_date', ['class' => 'label_update_report_vet', 'required' => true, 'value' => $date])

      ->addLabelFor('improvement', 'Information complémentaire')
      ->addTextarea('improvement', $improvement, ['class' => 'label_update_report_vet', 'required' => true])
      // Bouton de soumission du formulaire
      ->addBouton('Enregister', ['type' => 'submit', 'value' => 'submit', 'name' => 'save_changes', 'class' => 'btn'])

      ->endForm();

    return $form->create();
  }

  /**
   * Mise à jour du compte rendu de l'habitat
   */
  public function updateReportHabitat(int $idHabitatReport)
  {
    // Vérifie si des changements ont été soumis via le formulaire
    if (isset($_POST['save_changes'])) {

      // Nettoie les entrées du formulaire pour éviter les injections ou erreurs
      $habitat = SecurityHelper::sanitize(InputType::Int, 'habitat');
      $state = SecurityHelper::sanitize(InputType::Int, 'stateId');
      $opinion = SecurityHelper::sanitize(InputType::Int, 'opinionId');
      $date = SecurityHelper::sanitize(InputType::Date, 'passage_date');
      $improvement = SecurityHelper::sanitize(InputType::String, 'improvement');

      // Vérifie la validité des données et ajoute des messages d'erreur si nécessaire
      if (!$habitat) {
        $this->error["habitat"] = "L'habitat séléctioné n'existe pas";
      }
      if (!$opinion) {
        $this->error["opinion"] = "L'avis du vétérinaire est inconnue";
      }
      if (!$state)
        $this->error["state"] = "L'etat de l'habitat est inconnue";
    }
    if (!$date) {
      $this->error["date"] = "Date absente ou mal formatée (JJ/MM/AAAA)";
    }
    if (!$improvement) {
      $this->error["improvement"] = "Les commentaires doivent être remplis";
    } else if (strlen($improvement) > 255) {
      $this->error["improvement"] = "Le commentaire est trop long, 255 caractères maximum!";
    }

    // Si toutes les données sont valides, procède à la mise à jour
    if (
      $habitat && $state && $opinion && $date && $improvement &&
      strlen($improvement) <= 255 &&
      $date
    ) {
      // Récupère le modèle du compte rendu et le met à jour avec les nouvelles valeurs
      $habitatReportModel = new HabitatReportModel;
      $habitatReportModel->findOneById($idHabitatReport);

      $habitatReportModel->setIdHabitat($habitat);
      $habitatReportModel->setOpinion($opinion);
      $habitatReportModel->setState($state);
      $habitatReportModel->setDate($date);
      $habitatReportModel->setImprovement($improvement);

      // Sauvegarde les changements dans la base de données
      $updateResult = $habitatReportModel->update();

      // Si la mise à jour est réussie, redirige l'utilisateur
      if ($updateResult) {
        header("Location: /vetHabitat");
        exit;
      } else {
        // Sinon, affiche un message d'erreur pour l'utilisateur
        $this->error["db"] = "Une erreur s'est produite lors de la modification du compte rendu de l'habitat.";
      }
    } else {
      // Si des champs ne sont pas valides, affiche un message d'erreur général
      $this->error["form"] = "Formulaire incomplet.";
    }

    // Si la mise à jour échoue ou s'il manque des informations, retourne à la vue du formulaire
    $this->index($idHabitatReport);
  }
}
