<h3>Les services du zoo</h3>

<div>
  <?php if ($allServices) : ?>
    <?php foreach ($allServices as $service) : ?>
      <div onclick="location.href='/services/page/<?= $service->id_Service ?>'">
        <!-- <div onclick="location.href='/services/page/<?= $service->slug ?>'"> -->
        <p>Nom du service : <?= $service->name; ?></p>
        <img class="image" src="<?= $service->picture; ?>" alt="<?= $service->name; ?>"></img>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>