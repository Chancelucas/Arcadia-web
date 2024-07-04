<main>
<a href="javascript:history.back()">Retour</a>

  <h3><?= $habitat->name ?></h3>
  <?= $habitat->description ?>
  <img class="image" src="<?= $habitat->picture_url; ?>" alt="<?= $habitat->name ?>"></img>

  <?php if (isset($animalsInHabitat) && is_array($animalsInHabitat)) : ?>
    <?php foreach ($animalsInHabitat as $animal) : ?>
      <div onclick="location.href='/animal/page/<?= $animal->id_Animal ?>'">
        <p><?= $animal->breed; ?></p>
        <img class="image" src="<?= $animal->picture ?>" alt="<?= $animal->name ?>">
      </div>
    <?php endforeach; ?>

  <?php endif; ?>
</main>
