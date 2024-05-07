<main id="">

  <div id="">
    <h3>Liste des comptes rendu des animaux</h3>
    <?php foreach ($reportsAnimal as $reportAnimal) : ?>
      <div id="">
        <div id=""><?= $reportAnimal->id_animal ?></div>
        <div id=""><?= $reportAnimal->state ?></div>
        <div id=""><?= $reportAnimal->proposed_food ?></div>
        <div id=""><?= $reportAnimal->food_amount ?></div>
        <div id=""><?= $reportAnimal->passage_date ?></div>
        <div id=""><?= $reportAnimal->state_detail ?></div>

      </div>
    <?php endforeach; ?>
  </div>

</main>