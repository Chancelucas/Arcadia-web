<div id="main_edit_habitats">
  <div id="container_form_habitat_admin">
    <h3>Crée un habitat</h3>
    <?= $createHabitatForm; ?>

  </div>
  <div id="habitats-list">
    <h3>Liste des habitats</h3>
    <?php foreach ($habitats as $habitat) : ?>
      <div id="habitat">
        <div id="title_habitat">
          <h4><?= $habitat->name ?></h4>
        </div>

        <div id="btns_habitat_view">
          <form method="POST" action="adminHabitat/deleteHabitat/<?= $habitat->id ?>">
            <button type="submit" class="habitat-btn" id="delete-habitat-btn" name="deleteHabitat">Supprimer</button>
          </form>
          <a href="/adminUpdateHabitat/index/<?= $habitat->id ?>" class="habitat-btn" id="update-habitat-btn">Modifier</a>
        </div>

        <div id="image_habitat_view">
          <img src="<?= $habitat->picture_url ?>" alt="Photo habitat">
        </div>

        <div id="description_habitat_view"><?= $habitat->description ?></div>
        <div id="animals_habitat_view">
          <?php foreach ($habitat->animals as $animal) : ?>

            <div id="image_animal_view">
              <img src="<?= $animal->picture_url ?>" alt="Photo animal" width="100%">
              <div id="div_breed_animal"><?= $animal->breed ?></div>
            </div>

          <?php endforeach; ?>
        </div>

      </div>
    <?php endforeach; ?>
  </div>

</div>

<!-- <script src="js/pages/sessions/admin/habitat.js"></script> -->