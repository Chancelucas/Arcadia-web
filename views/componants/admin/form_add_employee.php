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
        <select id="roleName" name="roleName" required>
            <option value="Admin">Admin</option>
            <option value="Employer">Employer</option>
            <option value="Vétérinaire">Vétérinaire</option>
        </select>
    </div>
    <div>
        <button type="submit" value="Create_employee" name="Create_employee"><img src="../../../../assets/images/icons/add.svg" alt="btn-add"></button>
    </div>
    <div>
        <button type="submit" value="search" name="search"><img src="../../../assets/images/icons/recherche.svg" alt="btn-search"></button>
    </div>
</form>

