<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\CloudinaryManager;
use Source\Models\animal\AnimalModel;
use Source\Controllers\AdminController;
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
    $this->render('habitat/adminHabitat', [
      'createHabitatForm' => $createHabitatForm, 
      'habitats' => $habitats
    ]);
  }

  /**
   * Function with form for create habitat
   */
  private function generateCreateHabitatForm()
  {
    $form = new Form;

    $form->startForm('POST', 'adminHabitat/createHabitat', ['class' => 'form-habitat-admin', 'enctype' => 'multipart/form-data'])
      ->addInput('text', 'habitat_name', ['class' => 'habitat-form-input-admin', 'placeholder' => 'Ajouter un nom', 'required' => true])
      ->addTextarea('habitat_description', '', ['class' => 'habitat-form-input-admin', 'name' => 'description', 'placeholder' => 'Ajouter une description', 'required' => true])
      ->startDiv(['class' => 'div-add-doc-habitat-admin'])
      ->addInput('file', 'picture', ['class' => 'habitat-form-input-admin', 'multiple' => true, 'accept' => '.png, .jpeg, .jpg'])
      ->endDiv()
      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createHabitat', 'class' => 'btn btn_add_habitat_admin'])
      ->endForm();

    return $form->create();
  }

  public function createHabitat()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createHabitat'])) {
      $name = $_POST['habitat_name'];
      $description = $_POST['habitat_description'];
      $imageUrl = NULL;

      if (!empty($_FILES['picture']['tmp_name'])) {
        $imageUrl = CloudinaryManager::uploadImage($_FILES['picture']['tmp_name']);
        if (!$imageUrl) {
          $_SESSION['error'] = "Une erreur s'est produite lors du téléchargement de l'image.";
          header("Location: /adminHabitat");
          exit;
        }
      }

      $existingHabitat = (new HabitatModel)->findOneByName($name);

      if (!is_null($existingHabitat)) {
        echo "Le nom de l'habitat existe déjà.";
        return;
      } else {
        try {
          $habitat = new HabitatModel;
          $habitat->setName($name)
            ->setDescription($description)
            ->setPictureUrl($imageUrl);
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
   * Get all habitat 
   */
  private function getAllHabitats()
  {
    $allHabitats = (new HabitatModel)->getAllWithAnimals();
    return $allHabitats;
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
