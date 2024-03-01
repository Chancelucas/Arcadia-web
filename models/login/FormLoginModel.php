<?php

require_once '../../../config/connect_bdd.php';
include_once '../templates/AdminFirstLogin.php';

session_start();
$pdo = connectToDatabase();

if (isset($_POST['connection'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare('SELECT User.*, Role.roleName FROM User INNER JOIN Role ON User.roleName = Role.roleName WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hashedPassword = $user['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $user['userId'];
                ProfileController::show($user['roleName']);
            } else {
                $err_email = "Mot de passe incorrect";
            }
        } else {
            $err_email = "Aucun utilisateur trouvé avec cet email";
        }
    } else {
        $err_email = "Veuillez compléter tous les champs";
    }
}
?>
