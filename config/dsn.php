<?php
function connectToDatabase()
{
    $host = 'localhost';
    $port = 8889;
    $dbname = 'arcadia';
    $username = 'root';
    $pass = 'root';
    $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname;

    try {
        $pdo = new PDO($dsn, $username, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Impossible de se connecter à la base de données : ' . $e->getMessage();
        exit(); // Arrête le script en cas d'erreur de connexion
    }
}
?>
