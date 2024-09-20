<?php
use Source\Helpers\securityHTML;
?>


<div class="main_food_given_employee">

  <div class="div_form_food_given_employee">
    <?= $filterForm; ?>
  </div>

  <div class="all_food_given_employee">
    <?php if ($allFoodGiven) : ?>
      <?php foreach ($allFoodGiven as $foodGiven) : ?>
        <div class="one_food_given_employee">
          <p>L'animal nourrie : <?= $foodGiven->animal->breed; ?></p>
          <p>Date du repas : <?= $foodGiven->day; ?></p>
          <p>Heure du repas : <?= $foodGiven->hour; ?></p>
          <p>Nourriture donnée : <?= $foodGiven->food; ?></p>
          <p>Quantité donnée : <?= $foodGiven->quantity; ?></p>
          <p>Qui a donnée : <?= $foodGiven->user->username; ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>