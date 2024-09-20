
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
        <?= $containe; ?>
    <footer class="footer_public">
        <?php require_once ROOT . '/Source/Views/public/templates/footer.php'; ?>
    </footer>
    <script src="/js/templates/menu/menu_script.js"></script>
    <script src="/js/templates/welcome/anime_welcome_page.js"></script>
    <script src="/js/templates/message/flash_message.js"></script>

</body>

</html>