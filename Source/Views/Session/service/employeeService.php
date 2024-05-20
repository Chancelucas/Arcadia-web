<main id="main_edit_service">
  <?php foreach ($services as $service) : ?>

    <div id="container_service_admin">
      <div id="service_creaded_admin">
        <div class="item"><?= $service->name; ?></div>
        <div class="item"><?= $service->description; ?></div>

        <div id="picture_service_view">
          <img src="<?= $service->picture; ?>" alt="Photo du service"">
        </div>


          <a href="/employeeUpdateService/index/<?= $service->id_Service ?>" class="link_update_service">Modifier</a>

        </div>

      </div>
    </div>

  <?php endforeach; ?>

</main>