<?php

require_once '../config/dsn.php';

$pdo = connectToDatabase();

$username = 'a supprier'; //User non securiser a supprimer lors de la permier connection
$email = 'a@a';
$password = 'a'; 

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$roleId = 1;

try {
    $stmt = $pdo->prepare('INSERT INTO User (username, email, password, roleId) VALUES (:username, :email, :password, :roleId)');

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':roleId', $roleId);

    $stmt->execute();

    echo "L'utilisateur admin a été créé avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de la création de l'utilisateur admin : " . $e->getMessage();
}
?>
