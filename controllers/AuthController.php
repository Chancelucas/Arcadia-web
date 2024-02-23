<?php

require_once '../config/dsn.php';
require_once 'HomeController.php';
require_once '../scripts/create_admin.php';

session_start();
$pdo = connectToDatabase();

if (isset($_POST['connection'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare('SELECT * FROM User WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['roleId'] == 1) {
                $adminPassword = $user['password'];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                if (password_verify($password, $adminPassword)) {
                    $_SESSION['user_id'] = $user['userId'];
                    HomeController::displayDashboard($user['roleId']);
                } else {
                    $err_email = "Mot de passe incorrect";
                }
            } else {
                $err_email = "Vous n'êtes pas autorisé à accéder à cette fonctionnalité.";
            }
        } else {
            $err_email = "Aucun utilisateur trouvé avec cet email";
        }
    } else {
        $err_email = "Veuillez compléter tous les champs";
    }
}
?>
