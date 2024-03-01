<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: ../views/pages/public/login_page.php');

class LogoutController 
{
    public function NomDeLaFunction()
    {
    
    }
}



