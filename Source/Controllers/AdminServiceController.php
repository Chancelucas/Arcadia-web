<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\service\ServiceModel;
use Source\Controllers\AdminController;

class AdminServiceController extends AdminController
{
  public function index()
  {
    $createServiceForm = $this->generateCreateServiceForm();
    $services = $this->getAllServices();
    $this->render('service/adminService', ['createServiceForm' => $createServiceForm, 'services' => $services]);
  }

  /**
   * Generate form for create service.
   */
  private function generateCreateServiceForm()
  {
    $form = new Form;

    $form->startForm('POST', 'adminService/createService')

      ->startDiv(['id' => 'div_create_service', 'class' => 'div_create'])
      ->addInput('text', 'name', ['id' => 'name', 'placeholder' => 'Nom du service', 'required'])
      ->endDiv()

      ->startDiv(['id' => 'div_create_description', 'class' => 'div_create'])
      ->addInput('description', 'description', ['id' => 'description', 'placeholder' => 'Description'])
      ->endDiv()

      ->startDiv(['id' => 'div_add_picture_service'])
      ->addInput('file', 'picture', ['id' => 'service_add_picture', 'class' => 'service_form_input', 'placeholder' => 'Choisir des photos', 'multiple'])
      ->endDiv()

      ->startDiv(['class' => 'input_btn_login input_login div_create'])
      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'btn_add_service', 'name' => 'createservice'])
      ->endDiv()

      ->endForm();


    return $form->create();
  }

  /**
   * Traite la soumission du formulaire de création d'utilisateur.
   */
  public function createService()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createservice'])) {
      $name = $_POST['name'];
      $description = $_POST['description'];
      $picture_url = $_POST['picture'];

      $existingService = (new ServiceModel)->findOneByName($name);

      if (!is_null($existingService)) {
        echo "Le nom du service est déjà utilisé.";
        return;
      } else {

        try {
          $service = new ServiceModel;

          $service->setName($name)
            ->setDescription($description)
            ->setPicture($picture_url);

          $service->createService();

          $_SESSION['message'] = "Le service a été créé avec succès.";
        } catch (\Exception $e) {
          
          $_SESSION['error'] = "Une erreur s'est produite lors de la création du service : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun service n'a été renseigné";
    }

    Header("Location: /adminService");
    exit;
  }

  /**
   * Delete One service
   */
  public function deleteService(int $serviceId)
  {
    if (isset($_POST['deleteService'])) {
      $serviceModel = new ServiceModel;

      $serviceModel->setId($serviceId);
      $deleteService = $serviceModel->delete();

      if ($deleteService) {
        $_SESSION['message'] = "✅ Service supprimé avec succès.";
      } else {
        $_SESSION['error'] = "❌ Une erreur s'est produite lors de la suppression du service.";
      }
    }

    Header("Location: /adminService");
    exit;
  }

  /**
   * Get all service with role(label) on database
   */
  private function getAllServices()
  {
    $model = new ServiceModel;
    $servicesModel = $model->getAll();

    $allServices = [];
    foreach ($servicesModel as $serviceModel) {
      $service = new \stdClass();
      $service->id_Service = $serviceModel->getId();
      $service->name = $serviceModel->getName();
      $service->description = $serviceModel->getDescription();
      $service->picture_url = $serviceModel->getPicture();

      $allServices[] = $service;
    }

    return $allServices;
  }

}
