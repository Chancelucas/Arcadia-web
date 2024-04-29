<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\animal\AnimalModel;
use Source\Controllers\AdminController;
use Source\Models\habitat\HabitatModel;

class AdminAnimalController extends AdminController
{
  /**
   * Show all animal in BDD with form create animal. 
   */
  public function index()
  {
    $createAnimalForm = $this->generateCreateAnimalForm();
    $animals = $this->getAllAnimals();
    $this->render('animal/adminAnimal', ['createAnimalForm' => $createAnimalForm, 'animals' => $animals]);
  }

  /**
   * Function with form for create Animal
   */
  private function generateCreateAnimalForm()
  {
    $habitats = $this->getHabitatsFromDatabase();
    $form = new Form;

    $form->startForm('POST', 'adminAnimal/createAnimal', ['id' => 'form_animal'])

      ->addInput('text', 'name', ['class' => 'animal_form_input', 'id' => 'animal_name', 'placeholder' => 'Ajouter un nom', 'required'])

      ->addInput('text', 'breed', ['class' => 'animal_form_input', 'id' => 'animal_breed', 'name' => 'animal_breed', 'placeholder' => 'Ajouter une race animal', 'required'])

      ->addSelect('habitat', $habitats, ['id' => 'animals_add_habitat', 'class' => 'animal_form_input'])

      ->startDiv(['id' => 'div_add_doc_animal'])
      ->addInput('file', 'picture', ['id' => 'animal_add_picture', 'class' => 'animal_form_input', 'multiple'])
      ->endDiv()

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'animal_btn_save', 'name' => 'createAnimal', 'class' => 'animal_form_input'])

      ->endForm();

    return $form->create();
  }

  /**
   * Function create Animal
   */
  public function createAnimal()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createAnimal'])) {
      $name = $_POST['name'];
      $breed = $_POST['breed'];
      $picture = $_POST['picture'];
      $id_Habitat = $_POST['habitat'];

      $existingAnimal = (new AnimalModel)->findOneByBreed($breed);

      if (!is_null($existingAnimal)) {
        echo "Le nom de l'animal existe déjà.";
        return;
      } else {

        try {
          $animal = new AnimalModel;

          $animal->setName($name)
            ->setBreed($breed)
            ->setPicture($picture)
            ->setIdHabitat($id_Habitat);

          $animal->createAnimal();

          $_SESSION['message'] = "L'animal a été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création de l'animal : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun animal n'a été renseigné";
    }

    header("Location: /adminAnimal");
    exit;
  }

  /**
   * Delete One animal
   */
  public function deleteAnimal(int $animalId)
  {

    if (isset($_POST['deleteAnimal'])) {
      $animalModel = new AnimalModel;
      $animalModel->setId($animalId);
      $deleteAnimal = $animalModel->delete();

      if ($deleteAnimal) {
        $_SESSION['message'] = "✅ Animal supprimé avec succès.";
      } else {
        $_SESSION['error'] = "❌ Une erreur s'est produite lors de la suppression de l'animal.";
      }
    }

    Header("Location: /adminAnimal");
    exit;
  }

  /**
   * function get one animal from database
   */
  public function getHabitatsFromDatabase()
  {
    $model = new HabitatModel;
    $habitats = $model->getAll();

    $habitatList = [];

    foreach ($habitats as $habitat) {
      $habitatList[$habitat->getId()] = $habitat->getName();
    }
    return $habitatList;
  }

  /**
   * Get all Animals 
   * 
   * A FINIR pour afficher correctement tout les animaux des les habitat afficher
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

}
