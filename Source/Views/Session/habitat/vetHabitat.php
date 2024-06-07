<main id="main_vet_habitat">


  <div id="container_vet_habitat">
    <h3>Liste des comptes rendu des habitats</h3>
    <div class="one_habitat subtitle_habitat_vet">
      <div class="labels_habitat">
        <div class="label_habitat">Nom de l'habitat</div>
        <div class="label_habitat">Avis du vétérinaire</div>
        <div class="label_habitat">Etat de l'habitat</div>
        <div class="label_habitat">Commentaire</div>
        <div class="label_habitat">Date du rapport</div>
      </div>
    </div>
    <?php foreach ($reportsHabitat as $reportHabitat) : ?>
      <div class="one_habitat">
        <div class="labels_habitat">
          <div class="label_habitat"><?= $reportHabitat->name_habitat ?></div>
          <div class="label_habitat"><?= $reportHabitat->opinion ?></div>
          <div class="label_habitat"><?= $reportHabitat->state ?></div>
          <div class="label_habitat"><?= $reportHabitat->improvement ?></div>
          <div class="label_habitat"><?= $reportHabitat->date ?></div>
        </div>

        <div class="btns_habitat_vet">
          <form method="POST" action="vetReport/deleteReportHabitat">
            <input type="hidden" name="habitatReportId" value="<?= $reportHabitat->id_HabitatReport ?>">
            <button type="submit" class="btn_habitat_vet delete_btn_habitat_vet" name="deleteReportHabitat">Supprimer</button>
          </form>


          <a href="/vetUpdateReportHabitat/index/<?= $reportHabitat->id_HabitatReport ?>" class="btn_habitat_vet ">Modifier</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</main>

<!-- <script src="js/pages/sessions/admin/habitat.js"></script> -->