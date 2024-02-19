<form action="../../../controllers/AuthController.php" method="POST">
    <div>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Email" 
            value="<?php if(isset($email)){echo $email;}?>"
        >
    </div>
    <div>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Mot de passe" 
            value="<?php if(isset($password)){echo $password;}?>" 
        >
    </div>
    <div>
        <input type="submit" value="Connexion" name="connection">
    </div>
</form>
<div>
    <a href="forgot_password_page.php">Mot de passe oublié ?</a>
</div>

<?php if(isset($err_email)){echo $err_email;}?>


