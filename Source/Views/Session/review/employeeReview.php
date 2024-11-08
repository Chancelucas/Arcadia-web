<?php
use Source\Helpers\FlashMessage; 
?>


<div class="main_review_employee">
  <h3 class="title_review_employee">Avis des clients</h3>

  <div class="container_all_review_employee">
    <?= FlashMessage::displayFlashMessage() ?>
    <?php foreach ($allReviews as $reviews) : ?>
      <?php $label = $reviews->status == 1 ? "Désactiver" : "Activer" ?>
      <?php $stylebtn = $reviews->status == 1 ? "delete_btn" : "btn_update" ?>
      <div class="one_review_employee">
        <p class="text_review_employee"><?= $reviews->pseudo ?></p>
        <p class="text_review_employee"><?= $reviews->review ?></p>
        <form method="POST" action="employeeReview/toggleStatus/<?= $reviews->id ?>">
          <button class="<?= $stylebtn ?>" type="submit" name="toggleStatusReviews"><?= $label ?></button>
        </form>
      </div>

    <?php endforeach; ?>
  </div>
</div>
