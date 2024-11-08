<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\MongoDBAtlasManager;
use Source\Models\animal\AnimalModel;
use Source\Controllers\AdminController;

class AdminDashboardController extends AdminController
{
  /**
   * Index function on Admin Dashboard Controller
   */
  public function index()
  {
    $this->generateLogoutForm();
  }

  /**
   * Function logout [session = 'user']
   */
  public function logout()
  {
    session_destroy();
    header("Location: /login");
    exit;
  }

  /**
   * Form for logout session and click increment for each animal
   */
  private function generateLogoutForm()
  {
    $form = new Form();
    $mongoDBManager = new MongoDBAtlasManager();
    $animalModel = new AnimalModel();

    // Récupérer les animaux depuis la base relationnelle
    $allAnimalsRelational = $animalModel->getAllAnimals();

    // Récupérer les informations de clics des animaux depuis MongoDB
    $allAnimalsMongo = $mongoDBManager->readDocuments();

    // Associer les données MongoDB avec celles de la base relationnelle
    $animalsWithClicks = [];
    foreach ($allAnimalsRelational as $animal) {
      $relationalId = (string)$animal->id_Animal;

      // Rechercher le document MongoDB correspondant à cet animal en utilisant relational_id
      $mongoAnimal = array_filter($allAnimalsMongo, function ($mongoAnimal) use ($relationalId) {
        return $mongoAnimal['relational_id'] == $relationalId;
      });

      $mongoAnimal = reset($mongoAnimal); // Récupérer le premier résultat correspondant

      // Construire les informations de l'animal avec le nombre de clics
      $animalsWithClicks[] = [
        'breed' => $animal->breed, // Nom de l'animal
        'click_count' => $mongoAnimal['click_count'] ?? 0 // Nombre de clics (ou 0 par défaut)
      ];
    }

    // Transmettre ces données à la vue
    $this->render('dashboard/adminDashboard', [
      'logoutForm' => $form->create(),
      'animalsWithClicks' => $animalsWithClicks
    ]);
  }


  /**
   * Créer un formulaire pour incrémenter le compteur de clics d'un animal
   */
  private function createFormAnimalClick($animal)
  {
    $form = new Form();
    $form->startForm('POST', 'adminDashboard/incrementAnimalClick')
      ->addInput('hidden', 'animal_id', ['value' => (string)$animal['_id']])
      ->addBouton('Incrémenter', ['type' => 'submit'])
      ->endForm();
    return $form->create();
  }

  /**
   * Incrémente le compteur de clic d'un animal en fonction de son ID
   */
  public function incrementAnimalClick()
  {
    if (isset($_POST['animal_id'])) {
      $animalId = $_POST['animal_id'];

      // Vérifier si l'ID est un ObjectId valide
      if (strlen($animalId) === 24 && ctype_xdigit($animalId)) {
        $mongoDBManager = new MongoDBAtlasManager();
        if ($mongoDBManager->incrementClickCount($animalId)) {
          echo "Animal ID reçu et compteur incrémenté : $animalId";
        } else {
          echo "Erreur lors de l'incrémentation pour l'ID : $animalId";
        }
      } else {
        echo "L'ID fourni n'est pas un ObjectId valide.";
      }
    } else {
      echo "Aucun ID d'animal n'a été reçu.";
    }

    // Redirection vers le tableau de bord
    header("Location: /adminDashboard");
    exit;
  }
}






// public function createCliksCompter()
// {

//     $database = $dataOnMongoDB->getDatabase();
//     $test = $database->test->findOne(['_id' => '67255f283b7879fbad01bf86']);
//     $test = $database->test->findOne(['_id' => new MongoDB\BSON\ObjectId('67255f283b7879fbad01bf86')]);
//     print_r($test);

//     $doc =  $dataOnMongoDB->readDocuments(["_id" => "67255f283b7879fbad01bf86"]);
//     print_r($doc);
//     $dataOnMongoDB->updateOne(["_id" => "67255f283b7879fbad01bf86"], ["Tamere"]);
//     $dataOnMongoDB->createDocument(["Tamere" => 42]);
// }