<main>
  <div>
    <h2>Liste de tout les comptes rendu des vétérinaires</h2>
  </div>

  <div>
    <?php foreach ($animalsReport as $animalReport) : ?>

      <div id="">
        <div id=""><?= $animalReport->animalBreed ?></div>
        <div id=""><?= $animalReport->state ?></div>
        <div id=""><?= $animalReport->proposed_food ?></div>
        <div id=""><?= $animalReport->food_amount ?></div>
        <div id=""><?= $animalReport->passage_date ?></div>
        <div id=""><?= $animalReport->state_detail ?></div>
      </div>
    <?php endforeach; ?>
  </div>
  
  <div>
    <?php foreach ($reportsHabitat as $reportHabitat) : ?>
      <div id="">
        <div id=""><?= $reportHabitat->name_habitat ?></div>
        <div id=""><?= $reportHabitat->opinion ?></div>
        <div id=""><?= $reportHabitat->state ?></div>
        <div id=""><?= $reportHabitat->improvement ?></div>
        <div id=""><?= $reportHabitat->date ?></div>
      </div>
    <?php endforeach; ?>
  </div>


</main>