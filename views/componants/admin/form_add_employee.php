<?php
require_once '../../../controllers/crud/admin/CreateUser.php'
?>

<form action="../../pages/admin/admin_create_user.php" method="POST">
    <div>
        <input type="text" id="username" name="username" placeholder="Nom" required>
    </div>
    <div>
        <input type="email" id="email" name="email" placeholder="Email" required>
    </div>
    <div>
        <input type="password" id="password" name="password" placeholder="Mot de passe">
    </div>
    <div>
        <select id="roleId" name="roleId" required>
            <option value="1">Admin</option>
            <option value="2">Employé</option>
            <option value="3">Vétérinaire</option>
        </select>
    </div>
    <div>
        <button type="submit" value="Create_employee" name="Create_employee">Créer</button>
    </div>
</form>

