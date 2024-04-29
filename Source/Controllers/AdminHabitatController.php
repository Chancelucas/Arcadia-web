<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;

class AdminHabitatController extends AdminController
{

  /**
   * Show all habitat in BDD with form create habitat. 
   */
  public function index()
  {
    $createHabitatForm = $this->generateCreateHabitatForm();
    $habitats = $this->getAllHabitats();
    $this->render('habitat/adminHabitat', ['createHabitatForm' => $createHabitatForm, 'habitats' => $habitats]);
  }

  /**
   * Function with form for create habitat
   */
  private function generateCreateHabitatForm()
  {
    $form = new Form;

    $form->startForm('POST', 'adminHabitat/createHabitat', ['id' => 'form_habitat'])

      ->addInput('text', 'habitat_name', ['class' => 'habitat_form_input', 'id' => 'habitat_name', 'placeholder' => 'Ajouter un nom', 'required' => true])

      ->addTextarea('habitat_description', '', ['class' => 'habitat_form_input', 'id' => 'habitat_description', 'name' => 'description', 'placeholder' => 'Ajouter une description', 'required' => true])

      ->startDiv(['id' => 'div_add_doc_habitat'])
      ->addInput('file', 'habitat_picture', ['id' => 'habitat_add_picture', 'class' => 'habitat_form_input', 'multiple' => true, 'accept' => '.png, .jpeg, .jpg'])
      ->endDiv()

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'habitat_btn_save', 'name' => 'createHabitat', 'class' => 'habitat_form_input'])

      ->endForm();

    return $form->create();
  }

  /**
   * Function create habitat
   */
  public function createHabitat()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createHabitat'])) {
      $name = $_POST['habitat_name'];
      $description = $_POST['habitat_description'];
      $picture = $_POST['habitat_picture'];

      $existingHabitat = (new HabitatModel)->findOneByName($name);

      if (!is_null($existingHabitat)) {
        echo "Le nom de l'habitat existe déjà.";
        return;
      } else {

        try {
          $habitat = new HabitatModel;

          $habitat->setName($name)
            ->setDescription($description)
            ->setPicture($picture);

          $habitat->createHabitat();

          $_SESSION['message'] = "L'habitat a été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création de l'habitat : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun habitat n'a été renseigné";
    }

    header("Location: /adminHabitat");
    exit;
  }

  /**
   * function get one animal from database
   */
  public function getAnimalsFromDatabase()
  {
    $model = new AnimalModel;
    $animals = $model->getAll();

    $animalsList = [];

    foreach ($animals as $animal) {
      $animalsList[$animal->getId()] = $animal->getBreed();
    }
    return $animalsList;
  }

  /**
   * Get all habitat 
   */
  private function getAllHabitats()
  {
    $model = new HabitatModel;
    $allHabitats = $model->getAllWithAnimals();

    return $allHabitats;
  }

  /**
   * Get all Animals 
   */
  public function getAllAnimals()
  {
    $model = new AnimalModel;
    $animalsModel = $model->getAll();

    $allanimals = [];
    foreach ($animalsModel as $animalModel) {
      $animal = new \stdClass();
      $animal->id_Animal = $animalModel->getId();
      $animal->name = $animalModel->getName();
      $animal->breed = $animalModel->getBreed();
      $animal->picture = $animalModel->getPicture();
      $animal->id_Habitat = $animalModel->getIdHabitat();
      $animal->habitat = $animalModel->getHabitat();

      $allanimals[] = $animal;
    }

    return $allanimals;
  }

  /**
   * Delete One habitat
   */
  public function deleteHabitat(int $habitatId)
  {
    if (isset($_POST['deleteHabitat'])) {
      $habitatModel = new HabitatModel;

      $habitatModel->setIdHabitat($habitatId);

      $deleteHabitat = $habitatModel->delete();

      if ($deleteHabitat) {
        $_SESSION['message'] = "✅ Habitat supprimé avec succès.";
      } else {
        $_SESSION['error'] = "❌ Une erreur s'est produite lors de la suppression de l'habitat.";
      }
    }
    
    // AJOUTER UNE ERREUR SI ON ESSAYE DE SUPPRMIER UN HABITAT ALORS QU'IL Y A ANIMAL ENCORE ASSOCIER A CETTE HABITAT.

    Header("Location: /adminHabitat");
    exit;
  }

  public function compareIdHabitatOnAnimal(int $idHabitat, int $animalIdHabitat)
  {

    $animalModel = new AnimalModel;
    $animals = $animalModel->getAll();

    foreach ($animals as $animal) {
      if ($animal->id_Habitat === $idHabitat && $animal->id_Habitat === $animalIdHabitat) {
        return $animal->breed;
      } else {
        $_SESSION['error'] = "Aucun animal n'a été trouvé pour cet habitat.";
      }
    }
  }
}
