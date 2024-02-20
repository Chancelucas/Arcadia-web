<?php

require_once '../config/dsn.php';


session_start();
$pdo = connectToDatabase();


if (isset($_POST['connection'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $stmt = $pdo->prepare('SELECT * FROM User WHERE email = :email');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['userId'];
                if ($user['roleId'] == 1 ) {
                    header('Location: ../../../views/pages/admin/admin_dashboard.php');
                    exit();
                } elseif ($user['roleId'] == 2) {
                    header('Location: ../../../views/pages/employee/employee_dashboard.php'); 
                    exit();
                } elseif ($user['roleId'] == 3) {
                    header('Location: ../../../views/pages/vet/vet_dashboard.php');
                    exit();
                } else {
                    echo "Page introuvable";
                }
            } else {
                echo "Votre mot de passe ou email est incorrect";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email";
        }
    } else {
        echo "Veuillez compléter tous les champs";
    }
}

