<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" media="screen" href="/css/style.css" type="text/css">
  <title>Vétérinaire Arcadia</title>
</head>

<body>

  <header>
    <?php require_once ROOT . '/Source/Views/Session/templates/vet_navbar.php'; ?>
  </header>

  <div style="width: 100%;min-height:40px;border:solid 2px red;margin-top:80px;">
    SESSION User :
    <pre>
      <?= var_dump($_SESSION['user']); ?>
    </pre>
    SESSION Erreur :
    <pre>
      <?= var_dump($_SESSION['error']); ?>
    </pre>
    SESSION Message :
    <pre>
      <?= var_dump($_SESSION['message']); ?>
    </pre>

  </div>

  <?= $containe; ?>


</body>

</html>