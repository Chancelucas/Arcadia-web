<?php

session_start();

if(!$_SESSION['password']) {
    header('Location: ../views/pages/public/login_page.php');
}

echo 'Bienvuenu sur l\'espace admin';