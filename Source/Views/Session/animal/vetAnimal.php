<main id="">

  <div id="">
    <h3>Liste des comptes rendu des animaux</h3>

    <?php foreach ($animalsReport as $animalReport) : ?>

      <div id="">
        <div id=""><?= $animalReport->animalBreed ?></div>
        <div id=""><?= $animalReport->state ?></div>
        <div id=""><?= $animalReport->proposed_food ?></div>
        <div id=""><?= $animalReport->food_amount ?></div>
        <div id=""><?= $animalReport->passage_date ?></div>
        <div id=""><?= $animalReport->state_detail ?></div>
      </div>

      <div class="">
        <form method="POST" action="vetReport/deleteReportAnimal/<?= $animalReport->id_AnimalReport ?>">
          <button type="submit" class="" name="deleteReportAnimal">Supprimer</button>
        </form>

        <a href="/vetUpdateReportAnimal/index/<?= $animalReport->id_AnimalReport ?>" class="">Modifier</a>
      </div>
    <?php endforeach; ?>
  </div>

</main>