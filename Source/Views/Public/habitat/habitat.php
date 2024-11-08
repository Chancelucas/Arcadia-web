<?php

use Source\Helpers\FlashMessage;

?>

<div class="habitats_section">
  <?= FlashMessage::displayFlashMessage() ?>
  <?php if ($allHabitats) : ?>
    <?php foreach ($allHabitats as $habitat) : ?>
      <div class="habitat">
        <h4 class="habitat_name"><?= $habitat->name; ?></h4>
        <img class="habitat_image" src="<?= $habitat->picture_url; ?>" alt="<?php $habitat->name ?>"></img>

        <div class="animals_container">
          <?php foreach ($habitat->animals as $animal) : ?>
            <a href="/animal/clickAndRedirect/<?= htmlspecialchars($animal->id) ?>" class="animal" style="background-image: url('<?= htmlspecialchars($animal->picture_url) ?>');">
              <p class="animal_breed"><?= htmlspecialchars($animal->breed) ?></p>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <a class="btn" href="/habitat/page/<?= $habitat->id ?>">Voir plus</a>
    <?php endforeach; ?>
  <?php endif; ?>
</div>