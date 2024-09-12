<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_report_vet">
  <div class="title_vet_report">
    <h3>Les comptes rendu des habitats</h3>
  </div>

  <div class="all_report_vet">
    <?php foreach ($reportsHabitat as $reportHabitat) : ?>
      <div class="one_report_vet">
        <div class="labels_report_vet">
          <div class="label_report_vet">
            <p class="sous_title_report">Nom de l'habitat</p>
            <p><?= securityHTML($reportHabitat->name_habitat) ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Avis du vétérinaire</p>
            <p><?= securityHTML($reportHabitat->opinion) ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Etat de l'habitat</p>
            <p><?= securityHTML($reportHabitat->state) ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Commentaire</p>
            <p class="comment_report_vet"><?= securityHTML($reportHabitat->improvement) ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Date du rapport</p>
            <p><?= securityHTML($reportHabitat->date) ?></p>
          </div>
        </div>

        <div class="btns_report_vet">
          <form method="POST" action="vetReport/deleteReportHabitat">
            <input type="hidden" name="habitatReportId" value="<?= securityHTML($reportHabitat->id_HabitatReport) ?>">
            <button type="submit" class="delete_btn" name="deleteReportHabitat">Supprimer</button>
          </form>


          <a href="/vetUpdateReportHabitat/index/<?= securityHTML($reportHabitat->id_HabitatReport) ?>" class="link_update ">Modifier</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<!-- <script src="js/pages/sessions/admin/habitat.js"></script> -->