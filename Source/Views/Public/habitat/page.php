<?php
use function Source\Helpers\securityHTML;
?>

<main class="main_element_on_click">
  <a class="link_back_btn" href="javascript:history.back()">Retour</a>

  <div class="div_element_on_click">
    <h3 class="name_element_on_click"><?= securityHTML($habitat->name) ?></h3>
    <img class="img_element_on_click" src="<?= securityHTML( $habitat->picture_url); ?>" alt="<?= securityHTML($habitat->name) ?>"></img>

    <p class="description_element_on_click"><?= securityHTML($habitat->description) ?></p>

    <div class="animals_container">
      <?php if (isset($animalsInHabitat) && is_array($animalsInHabitat)) : ?>
        <?php foreach ($animalsInHabitat as $animal) : ?>
          <div class="animal" onclick="location.href='/animal/page/<?= securityHTML($animal->id_Animal) ?>'" style="background-image: url('<?= securityHTML($animal->picture); ?>');">
            <p class="animal_breed"><?= securityHTML($animal->breed); ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>


  </div>

</main>