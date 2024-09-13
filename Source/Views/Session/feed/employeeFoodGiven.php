<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_food_given_employee">

  <div class="div_form_food_given_employee">
    <?= $filterForm; ?>
  </div>

  <div class="all_food_given_employee">
    <?php if ($allFoodGiven) : ?>
      <?php foreach ($allFoodGiven as $foodGiven) : ?>
        <div class="one_food_given_employee">
          <p>L'animal nourrie : <?= securityHTML($foodGiven->animal->breed); ?></p>
          <p>Date du repas : <?= securityHTML($foodGiven->day); ?></p>
          <p>Heure du repas : <?= securityHTML($foodGiven->hour); ?></p>
          <p>Nourriture donnée : <?= securityHTML($foodGiven->food); ?></p>
          <p>Quantité donnée : <?= securityHTML($foodGiven->quantity); ?></p>
          <p>Qui a donnée : <?= securityHTML($foodGiven->user->username); ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>