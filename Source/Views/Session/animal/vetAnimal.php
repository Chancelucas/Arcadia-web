<main>
<?php foreach ($animals as $animal) : ?>

<div id="container_animal_vet">
  <div id="animal_creaded_vet">
    <div class="item"><?= $animal->name; ?></div>
    <div class="item"><?= $animal->breed; ?></div>
    <div class="item habitat"><?= $animal->habitat; ?></div>

    <div id="image_animal_view">
      <img src="<?= $animal->picture ?>" alt="Photo animal" >
    </div>

    <div class="btn_gestion_animal">
      <form method="POST" action="adminAnimal/deleteAnimal/<?= $animal->id_Animal ?>">
        <button type="submit" class="delete-animal-btn" name="deleteAnimal">Supprimer</button>
      </form>

      <a href="/adminUpdateAnimal/index/<?= $animal->id_Animal ?>" class="link_update_animal">Modifier</a>

      </form>
    </div>
  </div>
</div>

<?php endforeach; ?>
</main>