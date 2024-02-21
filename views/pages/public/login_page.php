<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">
    <title>Connexion</title>
</head>

<body>
    <?php require_once '../../componants/navbar.php'; ?>

    <h2>Connexion</h2>

    <?php
    require_once '../../../config/dsn.php';
    require_once '../../componants/form_login.php';
    ?>

</body>

</html>