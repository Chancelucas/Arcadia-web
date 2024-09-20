<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\animal\AnimalModel;
use Source\Controllers\AdminController;
use Source\Helpers\securityHTML;

class AdminUpdateAnimalController extends AdminController
{
  /**
   * Show all animal en BDD with form create animal. 
   */
  public function index(int $id)
  {
    $animalModel = new AnimalModel;
    $animal = $animalModel->findOneById($id);

    $name = $animal->getName();
    $breed = $animal->getBreed();

    $animalForm = $this->createForm($id, $name, $breed);
    $this->render('animal/adminUpdateAnimal', ['animalForm' => $animalForm]);
  }

  /**
   * Generate update user form
   */
  public function createForm($animalId, $name, $breed)
  {

    $form = new Form;

    $form->startForm('POST', "/adminUpdateAnimal/updateAnimal/{$animalId}", ['class' => 'form_update_animal_admin'])
      ->startDiv(['class' => 'div_form_update_animal_admin'])
      ->addLabelFor('name', 'Nom :')
      ->addInput('text', 'name', ['id' => 'name', 'class' => 'input_class_update_animal_admin', 'value' => $name, 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_form_update_animal_admin'])
      ->addLabelFor('breed', 'Race :')
      ->addInput('text', 'breed', ['id' => 'breed', 'class' => 'input_class_update_animal_admin', 'value' => $breed, 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_id_update_animal_admin'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'class' => 'btn btn_update_animal_admin'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * Update animal
   */
  public function updateAnimal(int $animalId)
  {
    if (isset($_POST['save_changes'])) {
      $name = $_POST['name'];
      $breed = $_POST['breed']; 

      $animalModel = new AnimalModel;
      $animalModel->findOneById($animalId);

      $animalModel->setName($name)
        ->setBreed($breed);

      $updateResult = $animalModel->update($animalId);

      if ($updateResult) {
        header("Location: /adminAnimal");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification de l'animal.";
      }
    }

    Header("Location: /adminUpdateAnimal");
    exit;
  }
}
