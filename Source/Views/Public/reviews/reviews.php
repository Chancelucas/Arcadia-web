<?php

use Source\Helpers\FlashMessage;

?>


<main class="main_reviews_page">

  <h2 class="title_reviews_page">Nous contacter</h2>
  
  <?= FlashMessage::displayFlashMessage() ?>

  <?= $formContact ?>


  <h2 class="title_reviews_page">Laissez nous votre avis</h2>

  <?= $formReviews ?>
  <section class="reviews_section">
    <div class="slider">
      <div class="slide-track">
        <?php if ($allReviews) : ?>
          <?php for ($i = 0; $i < 4; $i++) : ?>
            <?php foreach ($allReviews as $review) : ?>
              <div class="slide review">
                <p class="review_pseudo"><?= $review->pseudo ?></p>
                <p class="review_text"><?= $review->review ?></p>
              </div>
            <?php endforeach; ?>
          <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>



</main>