<?php

namespace Source\Controllers;

use Lib\config\Form;
use Lib\config\CloudinaryManager;
use Source\Controllers\AdminController;
use Source\Models\service\ServiceModel;
use function Source\Helpers\securityHTML;

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
      $name = $_POST['name'];
      $description = $_POST['description'];
      $picture_url = $_POST['picture'];

      $imageUrl = NULL; // Définissez une valeur par défaut ou une URL vide

      // Vérifie si un fichier a été téléchargé
      if (!empty($_FILES['picture']['tmp_name'])) {
        // Télécharge l'image sur Cloudinary
        $imageUrl = CloudinaryManager::uploadImage($_FILES['picture']['tmp_name']);
        if (!$imageUrl) {
          $_SESSION['error'] = "Une erreur s'est produite lors du téléchargement de l'image.";
          header("Location: /adminService");
          exit;
        }
      }

      $existingService = (new ServiceModel)->findOneByName($name);

      if (!is_null($existingService)) {
        echo "Le nom du service est déjà utilisé.";
        return;
      } else {

        try {
          $service = new ServiceModel;

          $service->setName($name)
            ->setDescription($description)
            ->setPictureUrl($imageUrl);

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
    $allServices = $model->getAllServices();

    return $allServices;
  }
}
