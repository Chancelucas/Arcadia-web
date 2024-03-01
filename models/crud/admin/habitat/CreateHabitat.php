<?php

require_once '../../../config/dsn.php';
require_once '../../../vendor/autoload.php';

use Cloudinary\Api\Upload\UploadApi;

$pdo = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitat_name = $_POST['habitat_name'];
    $habitat_description = $_POST['habitat_description'];

    // Vérifier si des fichiers ont été téléchargés
    if (isset($_FILES['habitat_photo']) && is_array($_FILES['habitat_photo']['tmp_name'])) {
        require_once '../../../config/config.php';

        // Parcourir chaque fichier téléchargé
        foreach ($_FILES['habitat_photo']['tmp_name'] as $index => $file_tmp_name) {
            //Uploader l'image sur Cloudinary
            $uploadApi = new UploadApi();
            $upload_result = $uploadApi->upload($file_tmp_name);
            $image_url = $upload_result['secure_url'];

            // Insérer l'habitat dans la base de données avec l'URL de l'image
            if ($index === 0) { // Insérer uniquement pour le premier fichier
                $query = "INSERT INTO Habitat (name, description, photo_url) VALUES (:name, :description, :photo_url)";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(':name' => $habitat_name, ':description' => $habitat_description, ':photo_url' => $image_url));
            }
        }
    } else {
        // Si aucune image n'a été téléchargée, insérer l'habitat dans la base de données sans URL d'image
        $query = "INSERT INTO Habitat (name, description) VALUES (:name, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':name' => $habitat_name, ':description' => $habitat_description));
    }

    header("Location: ../../../views/pages/admin/admin_edit_habitats.php");
    exit();
}
?>