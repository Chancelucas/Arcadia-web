<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="screen" href="/css/style.css" type="text/css">
    <title>Arcadia</title>
</head>

<body>

    <header>
        <?php require_once ROOT . '/Source/Views/public/templates/navbar.php'; ?>
    </header>

    <main>
        <div class="container">
            <?= $containe; ?>
        </div>
    </main>

    <footer>
        <?php require_once ROOT . '/Source/Views/public/templates/footer.php'; ?>
    </footer>

</body>

</html>