<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\service\ServiceModel;


class AdminUpdateServiceController extends AdminController
{
  /**
   * Show all habitat en BDD with form create habitat. 
   */
  public function index(int $id)
  {
    $serviceModel = new ServiceModel;
    $service = $serviceModel->findOneById($id);

    $name = $service->getName();
    $description = $service->getDescription();

    $serviceForm = $this->createForm($id, $name, $description);
    $this->render('adminUpdateService/adminUpdateService', ['serviceForm' => $serviceForm]);
  }



  /**
   * Generate update service form
   */
  public function createForm($serviceId, $name, $description)
  {

    $form = new Form;

    $form->startForm('POST', "/adminUpdateService/updateService/{$serviceId}", ['id' => 'form_update_service'])
      ->startDiv(['class' => 'div_form_update_service'])
      ->addLabelFor('name', 'Nom :')
      ->addInput('text', 'name', ['id' => 'name', 'class' => 'input_class_update_service', 'value' => $name, 'required' => true])
      ->endDiv()
      ->startDiv(['class' => 'div_form_update_service'])
      ->addLabelFor('description', 'description :')
      ->addInput('text', 'description', ['id' => 'description', 'class' => 'input_class_update_service', 'value' => $description, 'required' => true])
      ->endDiv()
      ->startDiv(['id' => 'div_id_update_service', 'class' => 'div_class_update_service'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'id' => 'btn_update_service'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * Update habitat
   */
  public function updateService(int $serviceId)
  {
    if (isset($_POST['save_changes'])) {
      $name = $_POST['name'];
      $description = $_POST['description']; 

      $serviceModel = new ServiceModel;
      $serviceModel->findOneById($serviceId);

      $serviceModel->setName($name)
        ->setDescription($description);

      $updateResult = $serviceModel->update($serviceId);

      if ($updateResult) {
        header("Location: /adminService");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification du service.";
      }
    }

    Header("Location: /adminUpdateService");
    exit;
  }
}
