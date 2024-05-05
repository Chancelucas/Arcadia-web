<main id="main_container_animal">
  <div id="form_create_animal">
    <?= $createAnimalForm; ?>
  </div>

  <?php foreach ($animals as $animal) : ?>

    <div id="container_animal_admin">
      <div id="animal_creaded_admin">
        <div class="item"><?= $animal->name; ?></div>
        <div class="item"><?= $animal->breed; ?></div>
        <div class="item habitat"><?= $animal->habitat; ?></div>

        <div id="image_animal_view">
          <img src="<?= $animal->picture ?>" alt="Photo animal" width="100%">
        </div>

        <div class="btn_gestion_animal">
          <form method="POST" action="adminAnimal/deleteAnimal/<?= $animal->id_Animal ?>">
            <button type="submit" class="delete-animal-btn" name="deleteAnimal">Supprimer</button>
          </form>

          <a href="/adminUpdateAnimal/index/<?= $animal->id_Animal ?>">Modifier</a>

          </form>
        </div>
      </div>
    </div>

  <?php endforeach; ?>
</main>