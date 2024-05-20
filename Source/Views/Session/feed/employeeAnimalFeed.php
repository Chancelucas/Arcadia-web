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
          <p>Date du rapport: <?= $report->passage_date; ?></p>
          <p>Aliment à donné: <?= $report->proposed_food; ?></p>
          <p>Quantité à donnée en gramme: <?= $report->food_amount; ?></p>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p>Aucun rapport trouvé pour cet animal.</p>
    <?php endif; ?>
  </div>

<div>
  <p>A remplir par l'employer</p>
  <div>
    <p>Date du nourrisage : </p>
    <p>Heure du nourrisage : </p>
    <p>Nourriture donnée : </p>
    <p>Quantité donnée (en gramme) : </p>
  </div>
</div>


</main>