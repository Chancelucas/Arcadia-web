<div>
  <div>
    <h2>Liste de tout les comptes rendu des vétérinaires</h2>
  </div>

  <div>
    <?= $filterFormReportAnimal; ?>
  </div>

  <div>
    <?php if ($animalsReport) : ?>
      <?php foreach ($animalsReport as $animalReport) : ?>
        <div>
          <p>L'animal :<?= $animalReport->animalBreed ?></p>
          <p>Son etat :<?= $animalReport->state ?></p>
          <p>Nourriture :<?= $animalReport->proposed_food ?></p>
          <p>Quantité :<?= $animalReport->food_amount ?></p>
          <p>Date de passage :<?= $animalReport->passage_date ?></p>
          <p>Commentaire :<?= $animalReport->state_detail ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>


  <div>
    <?= $filterFormReportHabitat; ?>
  </div>

  <div>
    <?php if ($reportsHabitat) : ?>
      <?php foreach ($reportsHabitat as $reportHabitat) : ?>
        <div id="">
          <div id=""><?= $reportHabitat->name_habitat ?></div>
          <div id=""><?= $reportHabitat->opinion ?></div>
          <div id=""><?= $reportHabitat->state ?></div>
          <div id=""><?= $reportHabitat->improvement ?></div>
          <div id=""><?= $reportHabitat->date ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>


</div>