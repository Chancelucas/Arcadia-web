<form action="../../../controllers/AuthController.php" method="POST" class="formulaire" id="form_login">
    <div class="input_text_login input_login">
        <input type="email" id="email" name="email" placeholder="Email" require value="<?php if (isset($email)) {echo $email;} ?>" class="input" id="input_email_login">
    </div>
    <div class="input_text_login input_login">
        <input type="password" id="password" name="password" placeholder="Mot de passe" require value="<?php if (isset($password)) {echo $password;} ?>" class="input" id="input_password_login">
    </div>
    <div class="input_btn_login input_login">
        <input type="submit" value="Connexion" name="connection" id="btn_connect_login" class="btn">
    </div>
</form>
<div id="link_forgot_login_page">
    <a href="forgot_password_page.php" class="link" id="link_login">Mot de passe oublié ?</a>
</div>

<?php if (isset($err_email)) {
    echo $err_email;
} ?>