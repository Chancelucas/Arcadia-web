<?php
?>


<div class="main_report_admin">
  <div class="title_report_admin">
    <h2>Liste de tout les comptes rendu des vétérinaires</h2>
  </div>

  <div class="container_form_report_admin container_form_report_animal_admin">
    <?= $filterFormReportAnimal; ?>
  </div>

  <div class="all_items_report_admin">
    <?php if ($animalsReport) : ?>
      <?php foreach ($animalsReport as $animalReport) : ?>
        <div class="one_elements_report_admin">
          <div class="item_report_admin">L'animal : <?= $animalReport->animalBreed ?></div>
          <div class="item_animal_report_admin">Son etat : <?= $animalReport->state ?></div>
          <div class="item_animal_report_admin">Nourriture : <?= $animalReport->proposed_food ?></div>
          <div class="item_animal_report_admin">Quantité : <?= $animalReport->food_amount ?></div>
          <div class="item_animal_report_admin">Date de passage : <?= $animalReport->passage_date ?></div>
          <div class="item_animal_report_admin">Commentaire : <?= $animalReport->state_detail ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>


  <div class="container_form_report_admin container_form_report_habitat_admin">
    <?= $filterFormReportHabitat; ?>
  </div>

  <div class="all_items_report_admin">
    <?php if ($reportsHabitat) : ?>
      <?php foreach ($reportsHabitat as $reportHabitat) : ?>
        <div class="one_elements_report_admin">
          <div class="item_report_admin">L'habitat : <?= $reportHabitat->name_habitat ?></div>
          <div class="item_report_admin">Avis du vétérinaire : <?= $reportHabitat->opinion ?></div>
          <div class="item_report_admin">Etat de l'habitat : <?= $reportHabitat->state ?></div>
          <div class="item_report_admin">Amélioration à apporter : <?= $reportHabitat->improvement ?></div>
          <div class="item_report_admin">Date de passage : <?= $reportHabitat->date ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>


</div>