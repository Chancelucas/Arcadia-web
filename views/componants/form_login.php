<form action="login.php" method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <input type="submit" value="Connexion">
    </div>
</form>
<div>
    <a href="forgot_password_page.php">Mot de passe oublié ?</a>
</div>

<?php if(isset($err_email)){echo $err_email;}?>


<?php


require_once '../../controllers/AuthController.php';



?>