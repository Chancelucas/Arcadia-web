<?php

use Source\Helpers\FlashMessage;
?>


<div class="main_vet_report">

    
    <?= FlashMessage::displayFlashMessage() ?>

  <div class="div_form_create_report_vet">
    <h3>Créer un comptes rendu pour un habitat</h3>
    <?= $createReportHabitatForm ?>
  </div>

  <div class="div_form_create_report_vet">
    <h3>Créer un comptes rendu pour un animal</h3>
    <?= $createReportAnimalForm ?>
  </div>

</div>