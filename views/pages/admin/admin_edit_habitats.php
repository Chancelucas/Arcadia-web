<?php
require_once '../../../config/dsn.php';
session_start();
$pdo = connectToDatabase();

function fetchHabitats(PDO $pdo)
{
    $select_query = "SELECT * FROM Habitat";
    $select_stmt = $pdo->query($select_query);
    $habitats = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($habitats as &$habitat) {
        $animal_query = "SELECT breed FROM Animal WHERE habitatId = :habitatId";
        $animal_stmt = $pdo->prepare($animal_query);
        $animal_stmt->execute(array(':habitatId' => $habitat['habitatId']));
        $animals = $animal_stmt->fetchAll(PDO::FETCH_ASSOC);
        $habitat['animals'] = $animals;
    }
    unset($habitat);

    return $habitats;
}

$habitats = fetchHabitats($pdo);
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
    <main id="main_edit_habitats">
        <div id="container_form_habitat_admin">
            <h3>Crée un habitat</h3>
            <?php require_once '../../componants/admin/form_add_habitat.php'; ?>
        </div>
        <div id="habitats-list">
            <h3>Liste des habitats</h3>
            <table>
                <tbody id="view_habitats">
                    <?php foreach ($habitats as $habitat) : ?>
                        <tr id="habitat">
                            <td id="title_habitat"><h4><?= $habitat['name'] ?></h4></td>
                            <td id="btns_habitat_view">
                                <a class="btn_habitat_view delete_btn_habitat_view" href="../../../controllers/crud/admin/DeleteHabitat.php?delete_habitat=<?= $habitat['habitatId'] ?>">Supprimer</a>
                                <a class="btn_habitat_view" href="../../../controllers/crud/admin/ModifyHabitat.php?modify_habitat=<?= $habitat['habitatId'] ?>">Modifier</a>
                            </td>
                            <td id="image_habitat_view"> <img src="<?= $habitat['photo_url'] ?>" alt="Photo habitat">
                            </td>
                            <td id="description_habitat_view"><?= $habitat['description'] ?></td>
                            <td id="animals_habitat_view">
                                <?php foreach ($habitat['animals'] as $animal) : ?>
                                    <?= $animal['breed'] ?><br>
                                <?php endforeach; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>