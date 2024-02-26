<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

<form id="form_habitat_admin" action="" method="post" enctype="multipart/form-data">
    <input type="text" class="habitat_form_input" id="habitat_name" name="habitat_name" placeholder="Ajouter un nom" required>
    <textarea type="text" class="habitat_form_input" id="habitat_description" name="habitat_description" placeholder="Ajouter une description" required></textarea>
    <select name="animals" id="habitat_add_animals" class="habitat_form_input">
        <option value="<?php ; ?>"><?php ; ?></option>
    </select>
    <div id="div_add_doc_habitat">
        <input type="file" name="habitat_photo[]" id="habitat_add_picture" class="habitat_form_input" multiple />
        <label for="habitat_add_picture">Choisir des photos</label>
        <span id="selected_files"></span>
    </div>

    <button type="submit" name="enregistrer" id="habitat_btn_save" class="habitat_form_input">Enregistrer</button>
</form>