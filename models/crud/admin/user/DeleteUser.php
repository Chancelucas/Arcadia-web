<?php
require_once '../../../config/dsn.php';

session_start();
$pdo = connectToDatabase();

if (isset($_GET['userId']) AND !empty($_GET['userId']))
{
    $getid = $_GET['userId'];    
    $collectUser = $pdo->prepare('SELECT * FROM User WHERE userId = ?');
    $collectUser->execute(array($getid));
    if($collectUser->rowCount() > 0){
        $deleteUser = $pdo->prepare('DELETE FROM User WHERE userId = ?');
        $deleteUser->execute(array($getid));

        header('Location:../../../../../views/pages/admin/admin_create_user.php');
    }else
    {
        echo "Aucun salarié n'a été trouvé";
    }
}else
{
    echo "L'identifiant n'a pas été récupéré"; 
}