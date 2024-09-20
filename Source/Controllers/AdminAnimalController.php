<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\CloudinaryManager;
use Source\Models\animal\AnimalModel;
use Source\Controllers\AdminController;
use Source\Models\habitat\HabitatModel;
use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;

class AdminAnimalController extends AdminController
{
  /**
   * Show all animal in BDD with form create animal. 
   */
  public function index()
  {

    $createAnimalForm = $this->generateCreateAnimalForm();
    $animals = $this->getAllAnimalsFromDatabase();

    $this->render('animal/adminAnimal', [
      'createAnimalForm' => $createAnimalForm,
      'animals' => $animals
    ]);
  }

  /**
   * Function with form for create Animal
   */
  private function generateCreateAnimalForm()
  {
    $habitats = $this->getHabitatsFromDatabase();
    $form = new Form;

    $form->startForm('POST', 'adminAnimal/createAnimal', ['class' => 'form_animal_admin', 'enctype' => 'multipart/form-data'])

    //Ajoute les erreurs éventuelles
    ->addError('name', $this->error)
    ->addError('breed', $this->error)
    ->addError('habitat', $this->error)
    ->addError('picture', $this->error)

      ->addInput('text', 'name', ['class' => 'animal_form_input_admin', 'placeholder' => 'Ajouter un nom', 'required' => true])

      ->addInput('text', 'breed', ['class' => 'animal_form_input_admin', 'name' => 'animal_breed', 'placeholder' => 'Ajouter une race animal', 'required' => true])

      ->addSelect('habitat', $habitats, ['class' => 'animal_form_input_admin'])

      ->startDiv(['class' => 'div_add_doc_animal_admin'])
      ->addInput('file', 'picture', ['class' => 'animal_form_input_admin', 'multiple' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_btn_add_animal'])
      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createAnimal', 'class' => 'btn btn_create_animal_admin'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * Function create Animal
   */
  public function createAnimal()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createAnimal'])) {
      $name = SecurityHelper::sanitize(InputType::String, 'name');
      $breed = SecurityHelper::sanitize(InputType::String, 'breed');
      $id_Habitat = SecurityHelper::sanitize(InputType::Int, 'habitat');
      
      // $name = $_POST['name'];
      // $breed = $_POST['breed'];
      // $id_Habitat = $_POST['habitat'];


      // Vérifie la validité des données et ajoute des messages d'erreur si nécessaire
      if (!$name) {
        $this->error["name"] = "Le nom de l'habitat n'ai pas remplie";
      }
      if (!$breed) {
        $this->error["breed"] = "La race de l'animal n'ai pas remplie";
      }
      if (!$id_Habitat) {
        $this->error["habitat"] = "L'habitat séléctioné n'existe pas";
      }

      $imageUrl = NULL; 

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
