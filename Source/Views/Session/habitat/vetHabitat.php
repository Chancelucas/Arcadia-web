<main id="">


  <div id="">
    <h3>Liste des comptes rendu des habitats</h3>
    <?php foreach ($reportsHabitat as $reportHabitat) : ?>
      <div id="">
        <div id=""><?= $reportHabitat->name_habitat ?></div>
        <div id=""><?= $reportHabitat->opinion ?></div>
        <div id=""><?= $reportHabitat->state ?></div>
        <div id=""><?= $reportHabitat->improvement ?></div>
        <div id=""><?= $reportHabitat->date ?></div>
      </div>

      <div class="">
        <form method="POST" action="vetHabitat/deleteReportHabitat/<?= $reportHabitat->id_ReportHabitat ?>">
          <button type="submit" class="" name="deleteReportHabitat">Supprimer</button>
        </form>

        <a href="/adminUpdateReportHabitat/index/<?= $reportHabitat->id_ReportHabitat ?>" class="">Modifier</a>
      </div>
    <?php endforeach; ?>
  </div>

</main>

<!-- <script src="js/pages/sessions/admin/habitat.js"></script> -->