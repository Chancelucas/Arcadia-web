<?php

require_once '../config/dsn.php';

$pdo = connectToDatabase();

$username = 'a supprimer'; 
$email = 'a@a';
$password = 'a'; 

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$roleName = 'Admin'; 

try {
    $stmt = $pdo->prepare('INSERT INTO User (username, email, password, roleName) VALUES (:username, :email, :password, :roleName)');

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':roleName', $roleName);

    $stmt->execute();

    echo "L'utilisateur admin a été créé avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de la création de l'utilisateur admin : " . $e->getMessage();
}
?>
