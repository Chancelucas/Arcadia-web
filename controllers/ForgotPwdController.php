<?php

require_once '../../../config/dsn.php';

if (!empty($_POST['email'])) {
    $email = $_POST['email'];

    // Vérifier si l'e-mail existe dans la base de données
    $pdo = connectToDatabase();
    $stmt = $pdo->prepare('SELECT * FROM User WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Générer un nouveau mot de passe sécurisé
        $newPassword = generateRandomPassword();

        // Mettre à jour le mot de passe de l'utilisateur dans la base de données
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare('UPDATE User SET password = :password WHERE email = :email');
        $updateStmt->bindParam(':password', $hashedPassword);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->execute();

        // Envoyer un e-mail à l'utilisateur avec le nouveau mot de passe
        $subject = "Réinitialisation de mot de passe";
        $message = "Votre nouveau mot de passe est : $newPassword";
        $headers = "From: your_email@example.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Un nouveau mot de passe a été envoyé à votre adresse e-mail.";
        } else {
            echo "Erreur lors de l'envoi du nouveau mot de passe par e-mail. Veuillez réessayer.";
        }
    } else {
        echo "Cette adresse e-mail n'existe pas dans notre base de données.";
    }
}

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,?.;/:+=ù%`£$*^¨-_)°àç!è§(\'"é&';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $password .= $characters[$index];
    }
    return $password;
}
?>
