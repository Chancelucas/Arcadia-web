<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\CloudinaryManager;
use Source\Controllers\AdminController;
use Source\Models\service\ServiceModel;
use Source\Helpers\FlashMessage;
use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;

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

    $form->startForm('POST', 'adminService/createService', ['class' => 'form_create_service_admin', 'enctype' => 'multipart/form-data'])

      ->startDiv(['class' => 'div_create_service_admin'])
      ->addInput('text', 'name', ['class' => 'input_create_service_admin', 'id' => 'name', 'placeholder' => 'Nom du service', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_create_service_admin'])
      ->addInput('hidden', 'slug', ['class' => 'input_create_service_admin', 'id' => 'slug', 'placeholder' => '***', 'required' => true, 'disabled' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_create_service_admin'])
      ->addTextarea('description', '', ['class' => 'input_create_service_admin', 'id' => 'description', 'name' => 'description', 'placeholder' => 'Ajouter une description', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_create_service_admin '])
      ->addInput('file', 'picture', ['class' => 'service_form_input', 'placeholder' => 'Choisir des photos', 'multiple' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_btn_create_service_admin'])
      ->addBouton('Créer', ['class' => 'btn btn_create_service_admin', 'type' => 'submit', 'value' => 'submit', 'id' => 'btn_add_service', 'name' => 'createService'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * Traite la soumission du formulaire de création d'utilisateur.
   */
  public function createService()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createService'])) {

      $name = SecurityHelper::sanitize(InputType::String, 'name');
      $description = SecurityHelper::sanitize(InputType::String, 'description');

      $imageUrl = NULL; 

      // Vérifie si un fichier a été téléchargé
      if (!empty($_FILES['picture']['tmp_name'])) {
        // Télécharge l'image sur Cloudinary
        $imageUrl = CloudinaryManager::uploadImage($_FILES['picture']['tmp_name']);
        if (!$imageUrl) {
          FlashMessage::addMessage("Une erreur s'est produite lors du téléchargement de l'image.", 'error');

          header("Location: /adminService");
          exit;
        }
      }

      $existingService = (new ServiceModel)->findOneByName($name);

      if (!is_null($existingService)) {
        FlashMessage::addMessage("Le nom du service est déjà utilisé.", 'error');
        return;
      } else {

        try {
          $service = new ServiceModel;

          $service->setName($name)
            ->setDescription($description)
            ->setPictureUrl($imageUrl);

          $service->createService();

          FlashMessage::addMessage("Le service a été créé avec succès.", 'success');
        } catch (\Exception $e) {
          FlashMessage::addMessage("Une erreur s'est produite lors de la création du service.", 'error');
        }
      }
    } else {
      FlashMessage::addMessage("Aucun service n'a été renseigné", 'warning');
    }

    header("Location: /adminService");
    exit;
  }

  /**
   * Delete One service
   */
  public function deleteService(string $serviceId)
  {

    if (isset($_POST['deleteService'])) {
      
      $serviceModel = new ServiceModel;
      $serviceModel->setId($serviceId);
      $deleteService = $serviceModel->delete();

      if ($deleteService) {
        FlashMessage::addMessage("Une erreur s'est produite lors de la suppression du service.", 'warning');

      } else {
        FlashMessage::addMessage("Service supprimé avec succès.", 'success');

      }
    }

    header("Location: /adminService");
    exit;
  }

  /**
   * Get all service with role(label) on database
   */
  private function getAllServices()
  {
    $model = new ServiceModel;
    $allServices = $model->getAllServices();

    return $allServices;
  }
}
