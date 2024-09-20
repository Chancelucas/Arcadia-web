<?php

use Source\Helpers\securityHTML;
?>

<main class="main_element_on_click">
  <a class="link_back_btn" href="javascript:history.back()">Retour</a>
  <div class="div_element_on_click">
    <h3 class="name_element_on_click"><?= $animal->name ?></h3>
    <p class="breed_element_on_click"><?= $animal->breed ?></p>
    <img class="img_element_on_click" src="<?= $animal->picture_url ?>" alt="<?= $animal->breed ?>">
    <p>

    <div class="container_report_animal_public">
      <div class="div_report_animal_public">
        <p class="label_report_animal_public">date du derrinier passage du vétérinaire :</p>
        <p class="input_report_animal_public"><?= $report->passage_date ?></p>
      </div>

      <div class="div_report_animal_public">
        <p class="label_report_animal_public">Etat de l'animal :</p>
        <p class="input_report_animal_public"><?= $report->state ?></p>
      </div>

      <div class="div_report_animal_public">
        <p class="label_report_animal_public">Date du dernier repas donnée par un employé :</p>
        <p class="input_report_animal_public"><?= $food->day ?></p>
      </div>

      <div class="div_report_animal_public">
        <p class="label_report_animal_public">Ce l'employer lui à donné à manger :</p>
        <p class="input_report_animal_public"><?= $food->food ?></p>
      </div>

      <div class="div_report_animal_public">
        <p class="label_report_animal_public">Commentaire du vétérinaire :</p>
        <p class="input_report_animal_public"><?= $report->state_detail ?></p>
      </div>
    </div>

</main>