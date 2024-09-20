<?php
use Source\Helpers\securityHTML;
?>


<div class="main_animal_feed">
  <div class="div_animal_feed">
    <p>Liste des animaux</p>
    <?= $selectAnimalForm; ?>
  </div>

  <div class="div_report_vet_employee">
    <?php if ($reportAnimal) : ?>
      <?php foreach ($reportAnimal as $report) : ?>
        <div class="one_report_vet_employee">
          <div class="one_container_report_employee">
            <p class="label_report_employee">Comptes rendu sur : </p>
            <p class="input_report_employee"><?= $animalsBreed ?></p>
          </div>
          <div class="one_container_report_employee">
            <p class="label_report_employee">Date du rapport : </p>
            <p class="input_report_employee"><?= $report->passage_date ?></p>
          </div>
          <div class="one_container_report_employee">
            <p class="label_report_employee">Aliment à donné : </p>
            <p class="input_report_employee"><?= $report->proposed_food ?></p>
          </div>
          <div class="one_container_report_employee">
            <p class="label_report_employee">Quantité à donnée en gramme : </p>
            <p class="input_report_employee"><?= $report->food_amount ?></p>
          </div>
          <div class="one_container_report_employee">
            <p class="label_report_employee">Note du vétérinaire : </p>
            <p class="input_report_employee"><?= $report->state_detail ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>


<div class="div_given_food_animal_feed_page">
  <?= $givenFoodForm; ?>
</div>

</div>