<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">

    <title>Horaire du zoo</title>
</head>

<body>
    <?php
    require_once '../../componants/admin/admin_navbar.php';
    require_once '../../../config/dsn.php';

    session_start();
    $pdo = connectToDatabase();

    if (!$_SESSION['user_id']) {
        header('Location: ../views/pages/public/login_page.php');
    }

    $collectUser = $pdo->query('SELECT * FROM User');

    require_once '../../componants/admin/form_add_employee.php';

    while ($user = $collectUser->fetch()) {
    ?>
        <p>
            <?php
            echo $user['email'];
            ?>
            <a href="../../../controllers/crud/admin/DeleteUser.php?userId=<?= $user['userId']; ?>">
                Supprimer
            </a>
            <a href="../../../controllers/crud/admin/ModifyUser.php?userId=<?= $user['userId']; ?>">
                Modifier
            </a>
        </p>
    <?php
    };

    ?>
</body>

</html>