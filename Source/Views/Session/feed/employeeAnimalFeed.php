<main>

  <div>
    <p>Liste des animaux</p>
    <?= $selectAnimalForm; ?>

  </div>

  <div>
    <p>Comptes rendu sur : <?= $animalsBreed ?></p>
    <?php if ($reportAnimal) : ?>
      <?php foreach ($reportAnimal as $report) : ?>
        <div>
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
  <div>
    <?= $givenFoodForm; ?>
  </div>
</div>


</main>