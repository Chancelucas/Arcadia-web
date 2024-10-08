<?php
use Source\Helpers\FlashMessage; 
?>


<div class="main_container_animal_admin">
  <div class="form_create_animal_admin">
    <?= $createAnimalForm; ?>
  </div>

  <?= FlashMessage::displayFlashMessage(); ?>


  <div class="container_animal_admin">
    <?php foreach ($animals as $animal) : ?>
      <div class="animal_creaded_admin">
        <div class="item_animal_admin"><?= $animal->name; ?></div>
        <div class="item_animal_admin"><?= $animal->breed; ?></div>
        <div class="item_animal_admin habitat_animal_admin"><?= $animal->habitat; ?></div>

        <div class="image_animal_view_admin">
          <img src="<?= $animal->picture ?>" alt="Photo animal">
        </div>

        <div class="btn_gestion_animal">
          <form method="POST" action="adminAnimal/deleteAnimal/<?= $animal->id_Animal ?>">
            <button type="submit" class="delete_btn" name="deleteAnimal">Supprimer</button>
          </form>
          <a href="/adminUpdateAnimal/index/<?= $animal->id_Animal ?>" class="link_update">Modifier</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</div>