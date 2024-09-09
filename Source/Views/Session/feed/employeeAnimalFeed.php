<div class="main_animal_feed">
  <div class="div_animal_feed">
    <p>Liste des animaux</p>
    <?= $selectAnimalForm; ?>
  </div>

  <div class="">
    <p>Comptes rendu sur : <?= $animalsBreed ?></p>
    <?php if ($reportAnimal) : ?>
      <?php foreach ($reportAnimal as $report) : ?>
        <div class="">
          <p>Date du rapport : <?= $report->passage_date; ?></p>
          <p>Aliment à donné : <?= $report->proposed_food; ?></p>
          <p>Quantité à donnée en gramme : <?= $report->food_amount; ?></p>
          <p>Note du vétérinaire : <?= $report->state_detail; ?></p>

        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p>Aucun rapport trouvé pour cet animal.</p>
    <?php endif; ?>
  </div>

  <div>
    <?= $givenFoodForm; ?>
  </div>

</div>