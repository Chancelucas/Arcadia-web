<?php
use Source\Helpers\securityHTML;
?>

<div class="habitats_section">
  <?php if ($allHabitats) : ?>
    <?php foreach ($allHabitats as $habitat) : ?>
      <div class="habitat">
        <h4 class="habitat_name"><?= $habitat->name; ?></h4>
        <img class="habitat_image" src="<?= $habitat->picture_url; ?>" alt="<?php $habitat->name ?>"></img>

        <div class="animals_container">
          <?php foreach ($habitat->animals as $animal) : ?>
            <div class="animal" onclick="location.href='/animal/page/<?= $animal->id ?>'" style="background-image: url('<?= $animal->picture_url; ?>');">
              <p class="animal_breed"><?= $animal->breed; ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <a class="btn" href="/habitat/page/<?= $habitat->id ?>">Voir plus</a>
    <?php endforeach; ?>
  <?php endif; ?>
</div>