<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" media="screen" href="/css/style.css" type="text/css">
  <title> Admin Arcadia</title>
</head>

<body>

  <header>
    <?php require_once ROOT . '/Source/Views/Session/templates/admin_navbar.php'; ?>
  </header>

  <div style="width: 100%;min-height:40px;border:solid 2px red;">
    <?php
    var_dump("SESSION User : {$_SESSION['user']}");
    echo "<br>";
    var_dump("SESSION Erreur : {$_SESSION['error']}");
    echo "<br>";
    var_dump("SESSION Message : {$_SESSION['message']}");
    ?>
  </div>

  <?= $containe; ?>

  <footer>
    <?php require_once ROOT . '/Source/Views/Session/templates/admin_footer.php'; ?>
  </footer>

</body>

</html>