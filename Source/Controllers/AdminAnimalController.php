<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\CloudinaryManager;
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
    $animals = $this->getAllAnimalsFromDatabase();
    $this->render('animal/adminAnimal', ['createAnimalForm' => $createAnimalForm, 'animals' => $animals]);
  }

  /**
   * Function with form for create Animal
   */
  private function generateCreateAnimalForm()
  {
    $habitats = $this->getHabitatsFromDatabase();
    $form = new Form;

    $form->startForm('POST', 'adminAnimal/createAnimal', ['id' => 'form_animal', 'enctype' => 'multipart/form-data'])

      ->addInput('text', 'name', ['class' => 'animal_form_input', 'id' => 'animal_name', 'placeholder' => 'Ajouter un nom', 'required' => true])

      ->addInput('text', 'breed', ['class' => 'animal_form_input', 'id' => 'animal_breed', 'name' => 'animal_breed', 'placeholder' => 'Ajouter une race animal', 'required' => true])

      ->addSelect('habitat', $habitats, ['id' => 'animals_add_habitat', 'class' => 'animal_form_input'])

      ->startDiv(['id' => 'div_add_doc_animal'])
      ->addInput('file', 'picture', ['id' => 'animal_add_picture', 'class' => 'animal_form_input', 'multiple' => true])
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
      $id_Habitat = $_POST['habitat'];


      $imageUrl = NULL; // Définissez une valeur par défaut ou une URL vide

      // Vérifie si un fichier a été téléchargé
      if (!empty($_FILES['picture']['tmp_name'])) {
        // Télécharge l'image sur Cloudinary
        $imageUrl = CloudinaryManager::uploadImage($_FILES['picture']['tmp_name']);
        if (!$imageUrl) {
          $_SESSION['error'] = "Une erreur s'est produite lors du téléchargement de l'image.";
          header("Location: /adminAnimal");
          exit;
        }
      }

      $existingAnimal = (new AnimalModel)->findOneByBreed($breed);

      if (!is_null($existingAnimal)) {
        echo "Le nom de l'animal existe déjà.";
        return;
      } else {

        try {
          $animal = new AnimalModel;

          $animal->setName($name)
            ->setBreed($breed)
            ->setPictureUrl($imageUrl)
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
  private function getHabitatsFromDatabase()
  {
    $model = new HabitatModel;
    $habitats = $model->getAllNameHabitat();

    return $habitats;
  }

  /**
   * Get all Animals 
   * 
   */
  public function getAllAnimalsFromDatabase()
  {
    $model = new AnimalModel;
    $animalsModel = $model->getAllAnimals();

    return $animalsModel;
  }
}
