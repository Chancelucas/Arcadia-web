<?php
require_once '../../../config/dsn.php';

$pdo = connectToDatabase();

if (isset($_POST['Create_employee'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $roleId = $_POST['roleId'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   
    $stmt = $pdo->prepare('INSERT INTO User (username, email, password, roleId) VALUES (:username, :email, :password, :roleId)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword); 
    $stmt->bindParam(':roleId', $roleId);

    if ($stmt->execute()) {
        header('Location: ../admin/admin_create_user.php');
        exit();
    } else {
        echo "Une erreur s'est produite lors de la création de l'utilisateur.";
    }
}
?>
