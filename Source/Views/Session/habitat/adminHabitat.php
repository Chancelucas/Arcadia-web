<?php
use function Source\Helpers\securityHTML;
?>


<div class="main-edit-habitats-admin">
  <div class="container-form-habitat-admin">
    <h3>Crée un habitat</h3>
    <?= $createHabitatForm; ?>
  </div>
  <div class="habitats-list-admin">
    <h3>Liste des habitats</h3>
    <?php foreach ($habitats as $habitat) : ?>
      <div class="habitat-admin">
        <div class="title-habitat-admin">
          <h4><?= securityHTML($habitat->name) ?></h4>
        </div>
        <div class="btns-habitat-view-admin">
          <form method="POST" action="adminHabitat/deleteHabitat/<?= securityHTML($habitat->id) ?>">
            <button type="submit" class="delete_btn" name="deleteHabitat">Supprimer</button>
          </form>
          <a href="/adminUpdateHabitat/index/<?= securityHTML($habitat->id) ?>" class="link_update">Modifier</a>
        </div>
        <div class="image-habitat-view-admin">
          <img src="<?= securityHTML($habitat->picture_url) ?>" alt="Photo habitat">
        </div>
        <div class="description-habitat-view-admin"><?= securityHTML($habitat->description) ?></div>
        <div class="animals-habitat-view-admin">
          <?php foreach ($habitat->animals as $animal) : ?>
            <div class="image-animal-view-admin animal" style="background-image: url('<?= securityHTML($animal->picture_url); ?>');" >
              <p class="div-breed-animal-admin"><?= securityHTML($animal->breed) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
