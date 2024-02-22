<?php
require_once '../../../config/dsn.php';
session_start();
$pdo = connectToDatabase();

// Sélectionner tous les habitats
$select_query = "SELECT * FROM Habitat";
$select_stmt = $pdo->query($select_query);
$habitats = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

// Sélectionner les animaux pour chaque habitat
foreach ($habitats as &$habitat) {
    $animal_query = "SELECT breed FROM Animal WHERE habitatId = :habitatId";
    $animal_stmt = $pdo->prepare($animal_query);
    $animal_stmt->execute(array(':habitatId' => $habitat['habitatId']));
    $animals = $animal_stmt->fetchAll(PDO::FETCH_ASSOC);
    $habitat['animals'] = $animals;
}
unset($habitat); // Désactive la référence à la dernière valeur

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">
    <title>Habitats</title>
</head>

<body>
    <?php require_once '../../componants/admin/admin_navbar.php'; ?>
    <main>
        <div>
            <?php require_once '../../componants/admin/form_add_habitat.php'; ?>
        </div>
        <div>
            <h2>Liste des habitats</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Animaux</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($habitats as $habitat) : ?>
                        <tr>
                            <td><?= $habitat['name'] ?></td>
                            <td><?= $habitat['description'] ?></td>
                            <td>
                                <?php foreach ($habitat['animals'] as $animal) : ?>
                                    <?= $animal['breed'] ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <a href="../../../controllers/crud/admin/DeleteHabitat.php?delete_habitat=<?= $habitat['habitatId'] ?>">Supprimer</a>
                                <a href="../../../controllers/crud/admin/ModifyHabitat.php?modify_habitat=<?= $habitat['habitatId'] ?>">Modifier</a>
                                <!-- Ajoutez d'autres actions comme Modifier, etc. -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
