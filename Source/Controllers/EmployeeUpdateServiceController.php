<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Helpers\InputType;
use Source\Helpers\FlashMessage;
use Source\Helpers\SecurityHelper;
use Source\Models\service\ServiceModel;
use Source\Controllers\EmployeeController;


class EmployeeUpdateServiceController extends EmployeeController
{
  /**
   * Donne les données à la vue. 
   */
  public function index(int $id)
  {
    // Vérifie si des changements ont été soumis via le formulaire
    if (isset($_POST['save_changes'])) {
      // Récupère les données saisies dans le formulaire
      $service = $_POST['service'];
      $name = $_POST['name'];
      $description = $_POST['description'];
    } else {
      // Si aucune soumission, récupère les données existantes du compte rendu pour le formulaire
      $serviceModel = new ServiceModel;
      $service = $serviceModel->findOneById($id);
      // Récupération des valeurs existantes pour peupler le formulaire
      $name = $service->getName();
      $description = $service->getDescription();
    }

    // Création du formulaire de mise à jour
    $serviceForm = $this->createForm($id, $name, $description);

    // Rend la vue pour afficher le formulaire de mise à jour
    $this->render('service/adminUpdateService', [
      'serviceForm' => $serviceForm
    ]);
  }

  /**
   * Génère le formulaire de mise à jour.
   */
  public function createForm($serviceId, $name, $description)
  {

    $form = new Form;

    $form->startForm('POST', "/employeeUpdateService/updateService/{$serviceId}", ['class' => 'form_update_service_admin'])

      ->startDiv(['class' => 'div_form_update_service_admin'])
      ->addLabelFor('name', 'Nom :')
      ->addInput('text', 'name', ['id' => 'name', 'class' => 'input_class_update_service_admin', 'value' => $name, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_service_admin'])
      ->addLabelFor('description', 'description :')
      ->addTextarea('description', $description, ['id' => 'description', 'class' => 'input_update_service_admin input_class_update_service_admin', 'required' => true])
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

      $name = SecurityHelper::sanitize(InputType::String, 'name');
      $description = SecurityHelper::sanitize(InputType::String, 'description');

      $serviceModel = new ServiceModel;
      $serviceModel->findOneById($serviceId);

      $serviceModel->setName($name)
        ->setDescription($description);

      $updateResult = $serviceModel->update($serviceId);

      if ($updateResult) {
        header("Location: /employeeService");
        FlashMessage::addMessage("Modification effectuer avec succes", 'success');
        exit;

      } else {
        FlashMessage::addMessage("Une erreur s'est produite lors de la modification du service.", 'error');
      }
    }

    Header("Location: /employeeUpdateService");
    exit;
  }
}
