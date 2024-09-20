<?php use Source\Helpers\FlashMessage; ?>

<main class="main_login">

  <div class="container_form_login">
    <?= $loginForm ?>
    <?php FlashMessage::displayFlashMessage(); ?>
    <div class="div">
      <a href="/templates/ForgotPassword" class="link_forgot_pass">Mot de passe oublié ?</a>
    </div>
  </div>

</main>