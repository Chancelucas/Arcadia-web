<?php
require_once '../../../config/dsn.php';
require_once '../../../config/config.php';
require_once '../../../vendor/autoload.php';

$pdo = connectToDatabase();
var_dump(class_exists('Cloudinary\Uploader'));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitat_name = $_POST['habitat_name'];
    $habitat_description = $_POST['habitat_description'];

    // Gérer le téléchargement de l'image sur Cloudinary
    if (isset($_FILES['habitat_photo']) && $_FILES['habitat_photo']['error'] === UPLOAD_ERR_OK) {
        // Récupérer le chemin temporaire du fichier téléchargé
        $file_tmp_name = $_FILES['habitat_photo']['tmp_name'];

        // L'envoyer sur Cloudinary
        $upload_result = \Cloudinary\Uploader::upload($file_tmp_name);

        // Récupérer l'URL de l'image téléchargée sur Cloudinary
        $image_url = $upload_result['secure_url'];

        // Insérer les données de l'habitat dans la base de données avec l'URL de l'image
        $query = "INSERT INTO Habitat (name, description, photo_url) VALUES (:name, :description, :photo_url)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':name' => $habitat_name, ':description' => $habitat_description, ':photo_url' => $image_url));
    } else {
        // Gérer le cas où aucune image n'est téléchargée
        // Insérer les données de l'habitat sans URL de l'image
        $query = "INSERT INTO Habitat (name, description) VALUES (:name, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':name' => $habitat_name, ':description' => $habitat_description));
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="text" id="habitat_name" name="habitat_name" placeholder="Ajouter un nom" required>
    <input type="text" id="habitat_description" name="habitat_description" placeholder="Ajouter une description" required>
    
    <input type="file" name="habitat_photo">
    

    <button type="submit" name="enregistrer">Enregistrer</button>
</form>

<script src="../../../public/js/componants/admin/modal_cloudinary.js" ></script>
