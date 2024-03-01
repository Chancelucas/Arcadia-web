<?php
require_once '../../../../../config/dsn.php';

$pdo = connectToDatabase();

if (isset($_POST['Create_employee'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifie si le champ "roleName" est défini dans le formulaire
    $roleName = isset($_POST['roleName']) ? $_POST['roleName'] : null;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Vérifie si le nom d'utilisateur ou l'adresse e-mail existe déjà
    $stmt = $pdo->prepare('SELECT * FROM User WHERE username = :username OR email = :email');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // Affiche un message d'erreur si le nom d'utilisateur ou l'adresse e-mail existe déjà
        echo "Le nom d'utilisateur ou l'adresse e-mail est déjà utilisé.";
    } else {
        // Insère l'utilisateur dans la base de données s'il est unique
        $stmt = $pdo->prepare('INSERT INTO User (username, email, password, roleName) VALUES (:username, :email, :password, :roleName)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':roleName', $roleName);

        if ($stmt->execute()) {
            header('Location: ../admin/admin_create_user.php');
            exit();
        } else {
            echo "Une erreur s'est produite lors de la création de l'utilisateur.";
        }
    }
}
?>
