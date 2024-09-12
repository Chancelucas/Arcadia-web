<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_report_admin">
  <div class="title_report_admin">
    <h2>Liste de tout les comptes rendu des vétérinaires</h2>
  </div>

  <div class="container_form_report_admin container_form_report_animal_admin">
    <?= securityHTML($filterFormReportAnimal); ?>
  </div>

  <div class="all_items_report_admin">
    <?php if ($animalsReport) : ?>
      <?php foreach ($animalsReport as $animalReport) : ?>
        <div class="one_elements_report_admin">
          <div class="item_report_admin">L'animal : <?= securityHTML($animalReport->animalBreed) ?></div>
          <div class="item_animal_report_admin">Son etat : <?= securityHTML($animalReport->state) ?></div>
          <div class="item_animal_report_admin">Nourriture : <?= securityHTML($animalReport->proposed_food) ?></div>
          <div class="item_animal_report_admin">Quantité : <?= securityHTML($animalReport->food_amount) ?></div>
          <div class="item_animal_report_admin">Date de passage : <?= securityHTML($animalReport->passage_date) ?></div>
          <div class="item_animal_report_admin">Commentaire : <?= securityHTML($animalReport->state_detail) ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>


  <div class="container_form_report_admin container_form_report_habitat_admin">
    <?= securityHTML($filterFormReportHabitat); ?>
  </div>

  <div class="all_items_report_admin">
    <?php if ($reportsHabitat) : ?>
      <?php foreach ($reportsHabitat as $reportHabitat) : ?>
        <div class="one_elements_report_admin">
          <div class="item_report_admin"><?= securityHTML($reportHabitat->name_habitat) ?></div>
          <div class="item_report_admin"><?= securityHTML($reportHabitat->opinion) ?></div>
          <div class="item_report_admin"><?= securityHTML($reportHabitat->state) ?></div>
          <div class="item_report_admin"><?= securityHTML($reportHabitat->improvement) ?></div>
          <div class="item_report_admin"><?= securityHTML($reportHabitat->date) ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>


</div>