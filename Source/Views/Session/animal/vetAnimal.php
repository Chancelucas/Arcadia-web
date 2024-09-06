<div class="main_report_vet">

  <div class="title_vet_report">
    <h3>Liste des comptes rendu des animaux</h3>
  </div>

  <div class="all_report_vet">
    <?php foreach ($animalsReport as $animalReport) : ?>
      <div class="one_report_vet">
        <div class="labels_report_vet">

          <div class="label_report_vet">
            <p class="sous_title_report">Race de l'animal</p>
            <p><?= $animalReport->animalBreed ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Son etat</p>
            <p><?= $animalReport->state ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Nourriture proposé</p>
            <p><?= $animalReport->proposed_food ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Quantité de nourriture</p>
            <p><?= $animalReport->food_amount ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Date du derrnière repas</p>
            <p><?= $animalReport->passage_date ?></p>
          </div>
          <div class="label_report_vet">
            <p class="sous_title_report">Commentaire</p>
            <p><?= $animalReport->state_detail ?></p>
          </div>
        </div>

        <div class="btns_report_vet">
          <form method="POST" action="vetReport/deleteReportAnimal/<?= $animalReport->id_AnimalReport ?>">
            <button type="submit" class="delete_btn" name="deleteReportAnimal">Supprimer</button>
          </form>

          <a href="/vetUpdateReportAnimal/index/<?= $animalReport->id_AnimalReport ?>" class="link_update">Modifier</a>
        </div>

      </div>
    <?php endforeach; ?>
  </div>
</div>