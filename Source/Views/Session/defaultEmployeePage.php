<?php
use function Source\Helpers\securityHTML;
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" media="screen" href="/css/style.css" type="text/css">
  <title>Employee Arcadia</title>
</head>

<body>

  <header>
    <?php require_once ROOT . '/Source/Views/Session/templates/employee_navbar.php'; ?>
  </header>


  <main class="session_dashboard">
    <?= securityHTML($containe); ?>
  </main>

  <script src="/js/templates/menu/menu_script_session.js"></script>
</body>

</html>