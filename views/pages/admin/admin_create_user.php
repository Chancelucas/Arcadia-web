<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">

    <title>Gestion des salariés</title>
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
    ?>
    <div id="form_create_admin">
        <?php
        require_once '../../componants/admin/form_add_employee.php';
        ?>
    </div>
    <?php
    while ($user = $collectUser->fetch()) {
    ?>
        <div id="container_user_admin">
            <div id="user_creaded_admin">
                <div class="item"><?= $user['username']; ?></div>
                <div class="item"><?= $user['email']; ?></div>
                <div class="item role"><?= $user['roleId']; ?></div>

                <div class="btn_gestion_user">
                    <a href="../../../controllers/crud/admin/ModifyUser.php?userId=<?= $user['userId']; ?>"><img src="../../../assets/images/icons/modifier.svg" alt="btn-supprier"></a>
                    <a href="../../../controllers/crud/admin/DeleteUser.php?userId=<?= $user['userId']; ?>"><img src="../../../assets/images/icons/supprier.svg" alt="btn-supprier"></a>

                </div>
            </div>
        </div>
    <?php
    };

    ?>
</body>

</html>