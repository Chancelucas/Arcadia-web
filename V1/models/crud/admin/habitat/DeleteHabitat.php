<?php
require_once '../../../config/dsn.php';
session_start();
$pdo = connectToDatabase();

// Vérifie si l'ID de l'habitat à supprimer est passé en paramètre
if (isset($_GET['delete_habitat'])) {
    $habitat_id = $_GET['delete_habitat'];

    // Mettre à jour les animaux associés à cet habitat en définissant leur habitatId à NULL
    $update_query = "UPDATE Animal SET habitatId = NULL WHERE habitatId = :habitatId";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute(array(':habitatId' => $habitat_id));

    // Supprimer l'habitat
    $delete_query = "DELETE FROM Habitat WHERE habitatId = :habitatId";
    $delete_stmt = $pdo->prepare($delete_query);
    $delete_stmt->execute(array(':habitatId' => $habitat_id));

    // Rediriger vers la page admin_edit_habitats.php
    header("Location: ../../../views/pages/admin/admin_edit_habitats.php");
    exit();
} else {
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    echo "ID de l'habitat non spécifié.";
}
?>
