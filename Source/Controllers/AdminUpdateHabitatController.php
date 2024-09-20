<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\habitat\HabitatModel;
use Source\Helpers\securityHTML;

class AdminUpdateHabitatController extends AdminController
{
  /**
   * Show all habitat en BDD with form create habitat. 
   */
  public function index(int $id)
  {
    $habitatModel = new HabitatModel;
    $habitat = $habitatModel->findOneById($id);

    $description = $habitat->getDescription();
    $name = $habitat->getName();

    $habitatForm = $this->createForm($id, $description, $name);
    $this->render('habitat/adminUpdateHabitat', ['habitatForm' => $habitatForm]);
  }

  /**
   * Generate update user form
   */
  public function createForm($habitatId, $description, $name)
  {
    $form = new Form;

    $form->startForm('POST', "/adminUpdateHabitat/updateHabitat/{$habitatId}", ['class' => 'form_update_habitat_admin'])

      ->startDiv(['class' => 'div_form_update_habitat_admin'])
      ->addLabelFor('name', 'Titre :')
      ->addInput('text', 'name', ['class' => 'input_class_update_habitat_admin title_update_habitat_admin', 'value' => $name, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_habitat_admin'])
      ->addLabelFor('description', 'Description :')
      ->addTextarea('description', $description, ['class' => 'input_class_update_habitat_admin description_update_habitat_admin', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_class_update_habitat_admin'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'class' => 'btn btn_update_habitat_admin'])
      ->endDiv()

      ->endForm();

      

    return $form->create();
  }

  /**
   * Update habitat
   */
  public function updateHabitat(int $habitatId)
  {
    if (isset($_POST['save_changes'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];

      $habitatModel = new HabitatModel;
      $habitatModel->findOneById($habitatId);

      $habitatModel->setName($name)
        ->setDescription($description);

      $updateResult = $habitatModel->update($habitatId);

      if ($updateResult) {
        header("Location: /adminHabitat");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification de l'utilisateur.";
      }
    }

    Header("Location: /adminUpdateHabitat");
    exit;
  }
}
