<?php
class HomeController
{
    public static function displayDashboard($roleName)
    {
        if ($roleName == 'Admin') {
            header('Location: ../../../views/pages/admin/admin_dashboard.php');
            exit(); 
        } elseif ($roleName == 'Employer') {
            header('Location: ../../../views/pages/employee/employee_dashboard.php');
            exit(); 
        } elseif ($roleName == 'Vétérinaire') {
            header('Location: ../../../views/pages/vet/vet_dashboard.php');
            exit(); 
        } else {
            echo "Rôle non reconnu";
            exit(); 
        }
    }
}
?>
