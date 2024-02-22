<?php
require_once '../../../config/dsn.php';
$pdo = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitat_name = $_POST['habitat_name'];
    $habitat_description = $_POST['habitat_description'];

    $query = "INSERT INTO Habitat (name, description) VALUES (:name, :description)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':name' => $habitat_name, ':description' => $habitat_description));

    $habitat_id = $pdo->lastInsertId();

    if (isset($_POST['animals'])) {
        foreach ($_POST['animals'] as $animal_id) {
            // Vérifier si l'entrée existe déjà dans la table Animal
            $query_check = "SELECT * FROM Animal WHERE animalId = :animalId";
            $stmt_check = $pdo->prepare($query_check);
            $stmt_check->execute(array(':animalId' => $animal_id));
            $existing_animal = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($existing_animal) {
                // L'animal existe déjà, mettre à jour l'habitatId
                $query_update = "UPDATE Animal SET habitatId = :habitatId WHERE animalId = :animalId";
                $stmt_update = $pdo->prepare($query_update);
                $stmt_update->execute(array(':habitatId' => $habitat_id, ':animalId' => $animal_id));
            } else {
                // L'animal n'existe pas encore, l'insérer avec l'habitatId
                $query_insert = "INSERT INTO Animal (animalId, habitatId) VALUES (:animalId, :habitatId)";
                $stmt_insert = $pdo->prepare($query_insert);
                $stmt_insert->execute(array(':animalId' => $animal_id, ':habitatId' => $habitat_id));
            }
        }
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="text" id="habitat_name" name="habitat_name" placeholder="Ajouter un nom" required>
    <input type="text" id="habitat_description" name="habitat_description" placeholder="Ajouter une description" required>
    <input type="file" name="habitat_photo">
    <select name="animals[]" id="animals" multiple required>
        <?php
        $query = "SELECT animalId, breed FROM Animal";
        $stmt = $pdo->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['animalId'] . "'>" . $row['breed'] . "</option>";
        }
        ?>
    </select>
    <button type="submit" name="enregistrer">enregistrer</button>
</form>

