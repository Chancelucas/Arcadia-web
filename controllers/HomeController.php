<?php
class HomeController
{
    public static function displayDashboard($roleId)
    {
        switch ($roleId) {
            case 1:
                require_once '../../../views/pages/admin/admin_dashboard.php'; 
                exit();
            case 2:
                require_once '../../../views/pages/employee/employee_dashboard.php'; 
                exit();
            case 3:
                require_once '../../../views/pages/vet/vet_dashboard.php'; 
                exit();
            default:
                echo "Role non reconnu";
                break;
        }
    }
}
?>
