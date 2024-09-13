<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_container_animal_admin">
  <div class="form_create_animal_admin">
    <?= $createAnimalForm; ?>
  </div>


  <div class="container_animal_admin">
    <?php foreach ($animals as $animal) : ?>
      <div class="animal_creaded_admin">
        <div class="item_animal_admin"><?= securityHTML($animal->name); ?></div>
        <div class="item_animal_admin"><?= securityHTML($animal->breed); ?></div>
        <div class="item_animal_admin habitat_animal_admin"><?= securityHTML($animal->habitat); ?></div>

        <div class="image_animal_view_admin">
          <img src="<?= securityHTML($animal->picture) ?>" alt="Photo animal">
        </div>

        <div class="btn_gestion_animal">
          <form method="POST" action="adminAnimal/deleteAnimal/<?= securityHTML($animal->id_Animal) ?>">
            <button type="submit" class="delete_btn" name="deleteAnimal">Supprimer</button>
          </form>
          <a href="/adminUpdateAnimal/index/<?= securityHTML($animal->id_Animal) ?>" class="link_update">Modifier</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</div>