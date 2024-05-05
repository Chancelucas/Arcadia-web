<main>

  <?php if ($isAdmin) : ?>
    <div id="form_create_animal">
      <?= $createServiceForm; ?>
    </div>
  <?php endif; ?>

  <?php foreach ($services as $service) : ?>

    <div id="container_service_admin">
      <div id="service_creaded_admin">
        <div class="item"><?= $service->name; ?></div>
        <div class="item"><?= $service->description; ?></div>
        <div class="item service"><?= $service->picture_url; ?></div>

        <div class="btn_gestion_service">
          <form method="POST" action="/adminService/deleteService/<?= $service->id_Service; ?>">
            <button type="submit" class="delete-service-btn" name="deleteService">Supprimer</button>
          </form>

          <a href="/adminUpdateService/index/<?= $service->id_Service ?>">Modifier</a>

        </div>

      </div>
    </div>

  <?php endforeach; ?>
</main>