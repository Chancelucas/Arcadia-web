<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">

    <title>Dashboard Admin</title>
</head>

<body>

    <nav>
    <?php require_once '../../componants/admin/admin_navbar.php'; ?>

    </nav>
    <?php
    session_start();
    if (!$_SESSION['user_id']) {
        header('Location: ../views/pages/public/login_page.php');
    }
    echo 'Bienvuenu sur l\'espace admin';
    ?>

    <a class="link" href="../../../controllers/Logout.php">Deconnexion</a>
    <a class="link" href="../../pages/admin/admin_edit_hour.php">Horaires</a>

    <footer>
    </footer>

</body>

</html>