<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">

    <title>Animaux</title>
</head>

<body>
    <?php
    require_once '../../componants/admin/admin_navbar.php';
    ?>
    <h3>Les animaux</h3>
    <?php
        require_once '../../componants/admin/form_add_animal.php';
    ?>
</body>

</html>