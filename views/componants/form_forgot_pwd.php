<form action="login_page.php" method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <input type="submit" value="demander un nouveau mot de passe" name="new-pwd">
    </div>
</form>

<?php

    require_once '../../../controllers/ForgotPwdController.php';

?>