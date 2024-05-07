<main id="">

  <div id="">
    <h3>Liste des comptes rendu des habitats</h3>
    <?php foreach ($reportsHabitat as $reportHabitat) : ?>
      <div id="">
        <div id=""><?= $reportHabitat->id_habitat ?></div>
        <div id=""><?= $reportHabitat->opinion ?></div>
        <div id=""><?= $reportHabitat->state ?></div>
        <div id=""><?= $reportHabitat->improvement ?></div>
        <div id=""><?= $reportHabitat->date ?></div>
      </div>
    <?php endforeach; ?>
  </div>

</main>

<!-- <script src="js/pages/sessions/admin/habitat.js"></script> -->