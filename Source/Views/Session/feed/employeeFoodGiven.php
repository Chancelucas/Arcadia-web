<main>

  <div>
    <?= $filterForm ;?>
  </div>

  <div>
    <p>Liste des repas donnée aux animaux</p>
    <?php if ($allFoodGiven) : ?>
      <?php foreach ($allFoodGiven as $foodGiven) : ?>
        <div>
          <p>L'animal nourrie : <?= $foodGiven->animal->getBreed(); ?></p>
          <p>Date du repas : <?= $foodGiven->day; ?></p>
          <p>Heure du repas : <?= $foodGiven->hour; ?></p>
          <p>Nourriture donnée : <?= $foodGiven->food; ?></p>
          <p>Quantité donnée : <?= $foodGiven->quantity; ?></p>
          <p>Qui a donnée : <?= $foodGiven->user->getUsername(); ?></p>
        </div>
        <hr />
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>