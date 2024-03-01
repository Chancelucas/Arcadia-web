<?php

require_once ('app/models/routeur/UserRouteur.php');

class ProfileController 
{
    public function show(string $roleName) 
    {
        $user = $this->getUser($roleName);

        if ($roleName == 'Admin') {
            header('Location: /app/views/pages/admin/admin_dashboard.php');
            exit(); 
        } elseif ($roleName == 'Employer') {
            header('Location: /app/views/pages/employee/employee_dashboard.php');
            exit(); 
        } elseif ($roleName == 'Vétérinaire') {
            header('Location: /app/views/pages/vet/vet_dashboard.php');
            exit(); 
        } else {
            echo "Rôle non reconnu";
            exit(); 
        }
    }

    private function getUser(string $roleName) 
    {
        // Code pour récupérer l'utilisateur avec l'identifiant $id dans la base de données
        // Retourne une instance de la classe User
    }
}