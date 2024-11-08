<?php

namespace Source\Controllers;

use Source\Helpers\FlashMessage;
use Source\Controllers\Controller;
use Lib\config\MongoDBAtlasManager;
use Source\Models\animal\AnimalModel;
use Source\Models\filter\FilterModel;
use Source\Models\animal\FoodGivenModel;
use Source\Models\report\AssessmentModel;
use Source\Models\report\AnimalReportModel;


class AnimalController extends Controller
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $animal = $this->getAllAnimal();

    $this->render('animal/animal', [
      'allHabitats' => $animal,
    ]);
  }

  private function getAllAnimal()
  {
    $model = new AnimalModel;
    $allAnimals = $model->getAllAnimals();

    return $allAnimals;
  }

  public function page(int $idAnimal)
  {
    $model = (new AnimalModel)->findBy(['id' => $idAnimal])[0];
    $reportOfVet = $this->getLastReportVet($idAnimal);
    $foodGiven = $this->getLastFoodGiven($idAnimal);
  
    $this->render('animal/page', [
      'animal' => $model,
      'report' => $reportOfVet,
      'food' => $foodGiven
    ]);
  }
  

  private function getLastElementByField($items, $field)
  {
    $model = new FilterModel;
    $lastElementModel = $model->getLastElementByField($items, $field);

    return $lastElementModel;
  }


  private function getLastReportVet($idAnimal)
  {
    $reportModel = new AnimalReportModel;

    $allReports = $reportModel->getReportsByAnimalId($idAnimal);

    $lastReport = $this->getLastElementByField($allReports, 'passage_date');

    $assessment = (new AssessmentModel())->findOneById($lastReport->state)->getState();
    $lastReport->state = $assessment;

    return $lastReport;
  }

  private function getLastFoodGiven($idAnimal)
  {
    $foodGivenModel = new FoodGivenModel;
    $allFoodGiven = $foodGivenModel->getFoodGivenByAnimalId($idAnimal);

    return $this->getLastElementByField($allFoodGiven, 'food_given_date');
  }

  public function clickAndRedirect($animalId)
  {
    $mongoDBManager = new MongoDBAtlasManager();

    try {
      // Rechercher l'animal par relational_id
      $existingAnimal = $mongoDBManager->readDocuments(['relational_id' => (string)$animalId]);

      if (empty($existingAnimal)) {
        // Si l'animal n'existe pas, créez un document avec relational_id
        $mongoDBManager->createDocument([
          'relational_id' => (string)$animalId,
          'click_count' => 1
        ]);
      } else {
        // Si l'animal existe, incrémentez le compteur de clics
        $mongoDBManager->incrementClickCount($animalId);
      }

      // Redirection vers la page de l'animal
      header("Location: /animal/page/" . urlencode($animalId));
      exit;
    } catch (Exception $e) {
      FlashMessage::addMessage("Erreur lors de la redirection et de l'incrémentation", 'warning');
    }
  }
}
