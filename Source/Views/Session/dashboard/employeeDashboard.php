<?php

use Source\Helpers\FlashMessage;

?>


<main>

  <h2>Dashboard Employer</h2>

  <div>
    <a href="https://accounts.google.com/AccountChooser/signinchooser?service=mail&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&flowName=GlifWebSignIn&flowEntry=AccountChooser&ec=asw-gmail-globalnav-signin&ddm=0" target="_blank" title="Arcadia mail">Boite mail</a>
  </div>

  <?= FlashMessage::displayFlashMessage(); ?>



</main>