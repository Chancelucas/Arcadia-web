<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_vet_report">

  <div class="div_form_create_report_vet">
    <h3>Créer un comptes rendu pour un habitat</h3>
    <?= securityHTML($createReportHabitatForm); ?>
  </div>

  <div class="div_form_create_report_vet">
    <h3>Créer un comptes rendu pour un animal</h3>
    <?= securityHTML($createReportAnimalForm); ?>
  </div>

</div>