<?php
require_once '../../../controllers/HomeController.php';
require_once '../../../config/dsn.php';


session_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['connection'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        // Connexion à la base de données
        $pdo = connectToDatabase();

        // Préparation de la requête SQL pour récupérer l'utilisateur en fonction de l'email
        $stmt = $pdo->prepare('SELECT * FROM User WHERE email = :email');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($user);

        // Vérification si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Sauvegarde de l'identifiant de l'utilisateur en session si nécessaire
            header('Location: ../admin/admin_dashboard.php');
            exit(); // Important pour arrêter l'exécution du script après la redirection
        } else {
            echo "Votre mot de passe ou email est incorrect";
        }
    } else {
        echo "Veuillez compléter tous les champs";
    }
}






// if(isset($_POST['connection'])){
//     if(!empty($_POST['email']) AND !empty($_POST['password'])){
//         $pdo = connectToDatabase();
//         $email_defaut = $bdd->prepare('SELECT * FROM User WHERE email');
//         $password_defaut = $bdd->prepare('SELECT * FROM User WHERE password');

//         $email_write = htmlspecialchars($_POST['email']);
//         $password_write = htmlspecialchars($_POST['password']);

//         if ($email_write == $email_defaut AND $password_write == $password_defaut) {
//             $_SESSION['password'] = $password_write ;
//             header('Location: ../admin/admin_dashboard.php');
//         }else {
//             echo "Votre mot de passe ou email et incorrect";
//         }

//     }else{
//         echo "Veuillez compléter les tous champs";
//     }
// }





if(isset($_POST['connection'])){
    if(!empty($_POST['email']) AND !empty($_POST['password'])){
        $email_defaut = "admin@test.com";
        $password_defaut = "123";

        $email_write = htmlspecialchars($_POST['email']);
        $password_write = htmlspecialchars($_POST['password']);

        if ($email_write == $email_defaut AND $password_write == $password_defaut) {
            $_SESSION['password'] = $password_write ;
            header('Location: ../admin/admin_dashboard.php');
        }else {
            echo "Votre mot de passe ou email et incorrect";
        }

    }else{
        echo "Veuillez compléter les tous champs";
    }
}



?>
