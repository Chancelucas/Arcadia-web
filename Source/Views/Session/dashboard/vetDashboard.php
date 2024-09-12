<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_container_vet">
  <h2 class="title_page">Dashboard</h2>
  <h3>Liste des repas donnée</h3>

  <div class="form_search_foodgiven_vet">
    <?= securityHTML($filterForm); ?>
  </div>

  <div class="container_foodgiven_vet">
    <?php if ($allFoodGiven) : ?>
      <?php foreach ($allFoodGiven as $foodGiven) : ?>
        <div class="element_foodgiven_vet">
          <div class="item_foodgiven_vet">L'animal nourrie : <?= securityHTML($foodGiven->animal->breed); ?></div>
          <div class="item_foodgiven_vet">Date du repas : <?= securityHTML($foodGiven->day); ?></div>
          <div class="item_foodgiven_vet">Heure du repas : <?= securityHTML($foodGiven->hour); ?></div>
          <div class="item_foodgiven_vet">Nourriture donnée : <?= securityHTML($foodGiven->food); ?></div>
          <div class="item_foodgiven_vet">Quantité donnée : <?= securityHTML($foodGiven->quantity); ?></div>
          <div class="item_foodgiven_vet">Qui a donnée : <?= securityHTML($foodGiven->user->username); ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>