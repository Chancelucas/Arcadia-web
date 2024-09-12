<?php
use function Source\Helpers\securityHTML;
?>

<main class="main_home_page">

  <div class="first_section_home_page">
    <h2 class="title_home_page">Arcadia</h2>
  </div>

  <section class="habitats_section">
    <?php if ($allHabitats) : ?>
      <?php foreach ($allHabitats as $habitat) : ?>
        <div class="habitat">
          <a class="see_more" href="/habitat/page/<?= securityHTML($habitat->id) ?>">
            <h3 class="habitat_name"><?= securityHTML($habitat->name); ?></h3>
            <img class="habitat_image" src="<?= securityHTML($habitat->picture_url); ?>" alt="<?= securityHTML($habitat->name) ?>">
          </a>
          <div class="animals_container">
            <?php foreach ($habitat->animals as $animal) : ?>
              <div class="animal" onclick="location.href='/animal/page/<?= securityHTML($animal->id) ?>'" style="background-image: url('<?= securityHTML($animal->picture_url); ?>');">
                <p class="animal_breed"><?= securityHTML($animal->breed); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <a class="btn see_all" href="/habitat">Voir tous les habitats</a>
  </section>

  <section class="services_section">
    <h3 class="section_title">Les services du zoo</h3>
    <?php if ($allServices) : ?>
      <?php foreach ($allServices as $service) : ?>
        <div class="service" onclick="location.href='/services/page/<?= securityHTML($service->id_Service) ?>'" style="background-image: url('<?= securityHTML($service->picture); ?>');">
          <p class="service_name"><?= securityHTML($service->name); ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <a class="btn see_all" href="/services">Voir tous les services</a>
  </section>

  <section class="reviews_section">
    <h3 class="section_title">Avis client</h3>
    <div class="slider">
      <div class="slide-track">
        <?php if ($allReviews) : ?>
          <?php for ($i = 0; $i < 4; $i++) : ?>
            <?php foreach ($allReviews as $review) : ?>
              <div class="slide review">
                <p class="review_pseudo"><?= securityHTML($review->pseudo) ?></p>
                <p class="review_text"><?= securityHTML($review->review) ?></p>
              </div>
            <?php endforeach; ?>
          <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
    <a class="btn see_all" href="/reviews">Laissez un commentaire</a>
  </section>

</main>
