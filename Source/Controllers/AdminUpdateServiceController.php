<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\service\ServiceModel;
use Source\Helpers\securityHTML;


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
    $this->render('service/adminUpdateService', ['serviceForm' => $serviceForm]);
  }



  /**
   * Generate update service form
   */
  public function createForm($serviceId, $name, $description)
  {

    $form = new Form;

    $form->startForm('POST', "/adminUpdateService/updateService/{$serviceId}", ['class' => 'form_update_service_admin'])

      ->startDiv(['class' => 'div_form_update_service_admin'])
      ->addLabelFor('name', 'Nom :')
      ->addInput('text', 'name', ['class' => 'input_class_update_service_admin', 'value' => $name, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_service_admin'])
      ->addLabelFor('description', 'description :')
      ->addTextarea('description', $description, ['class' => 'input_class_update_service_admin input_update_service_admin', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_service_admin div_btns_update_service_admin'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'class' => 'btn btn_update_service'])
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
