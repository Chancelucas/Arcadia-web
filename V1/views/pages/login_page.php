<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/public/css/style.css" type="text/css">
    <title>Connexion</title>
</head>

<body id="body_login_page">

    <?php require_once('../templates/navbar/navbar.php') ;?>

    <main id="main_login_page">
        <div id="form_login_page">
            <?php
            require_once ('../../../config/connect_bdd.php');
            require_once ('../templates/form/form_login_page.php');
            ?>
        </div>
    </main>

</body>

</html>