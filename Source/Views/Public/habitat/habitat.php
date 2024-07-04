<h3>Les habitats</h3>


<div>
  <?php if ($allHabitats) : ?>
    <?php foreach ($allHabitats as $habitat) : ?>
      <div>
        <h4><?= $habitat->name; ?></h4>
        <img class="image" src="<?= $habitat->picture_url; ?>" alt="<?php $habitat->name ?>"></img>

        <?php foreach ($habitat->animals as $animal) : ?>
          <div onclick="location.href='/animal/page/<?= $animal->id ?>'">
            <p><?= $animal->breed; ?></p>
            <img class="image" src="<?= $animal->picture_url ?>" alt="<?= $animal->breed ?>">

          </div>
        <?php endforeach; ?>
        <a href="/habitat/page/<?= $habitat->id ?>">Voir plus</a>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>