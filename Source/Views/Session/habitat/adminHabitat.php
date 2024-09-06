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
          <h4><?= $habitat->name ?></h4>
        </div>
        <div class="btns-habitat-view-admin">
          <form method="POST" action="adminHabitat/deleteHabitat/<?= $habitat->id ?>">
            <button type="submit" class="delete_btn" name="deleteHabitat">Supprimer</button>
          </form>
          <a href="/adminUpdateHabitat/index/<?= $habitat->id ?>" class="link_update">Modifier</a>
        </div>
        <div class="image-habitat-view-admin">
          <img src="<?= $habitat->picture_url ?>" alt="Photo habitat">
        </div>
        <div class="description-habitat-view-admin"><?= $habitat->description ?></div>
        <div class="animals-habitat-view-admin">
          <?php foreach ($habitat->animals as $animal) : ?>
            <div class="image-animal-view-admin animal" style="background-image: url('<?= $animal->picture_url; ?>');" >
              <p class="div-breed-animal-admin"><?= $animal->breed ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
