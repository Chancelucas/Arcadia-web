<?php
class HomeController
{
    public static function displayDashboard($roleId)
    {
        if ($roleId == 1) {
            header('Location: ../../../views/pages/admin/admin_dashboard.php');
            exit(); // Ajout de exit() pour terminer le script après la redirection
        } elseif ($roleId == 2) {
            header('Location: ../../../views/pages/employee/employee_dashboard.php');
            exit(); // Ajout de exit() pour terminer le script après la redirection
        } elseif ($roleId == 3) {
            header('Location: ../../../views/pages/vet/vet_dashboard.php');
            exit(); // Ajout de exit() pour terminer le script après la redirection
        } else {
            echo "Rôle non reconnu";
            exit(); // Assurez-vous de terminer le script si le rôle n'est pas reconnu
        }
    }
}
?>
