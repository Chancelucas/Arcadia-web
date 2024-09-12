<?php
use function Source\Helpers\securityHTML;
?>

<div class="habitats_section">
  <?php if ($allHabitats) : ?>
    <?php foreach ($allHabitats as $habitat) : ?>
      <div class="habitat">
        <h4 class="habitat_name"><?= securityHTML($habitat->name); ?></h4>
        <img class="habitat_image" src="<?= securityHTML($habitat->picture_url); ?>" alt="<?php securityHTML($habitat->name) ?>"></img>

        <div class="animals_container">
          <?php foreach ($habitat->animals as $animal) : ?>
            <div class="animal" onclick="location.href='/animal/page/<?= securityHTML($animal->id) ?>'" style="background-image: url('<?= securityHTML($animal->picture_url); ?>');">
              <p class="animal_breed"><?= securityHTML($animal->breed); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <a class="btn" href="/habitat/page/<?= securityHTML($habitat->id) ?>">Voir plus</a>
    <?php endforeach; ?>
  <?php endif; ?>
</div>