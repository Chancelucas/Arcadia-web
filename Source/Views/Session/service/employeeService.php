<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_edit_service_admin">

  <div class="container_service_admin">
    <?php foreach ($services as $service) : ?>

      <div class="service_creaded_admin">
        <p class="item_service_admin title_service_admin"><?= securityHTML($service->name); ?></p>
        <p class="item_service_admin texte_service_admin"><?= securityHTML($service->description); ?></p>

        <div class="picture_service_view_admin">
          <img class="picture_service_admin" src="<?= securityHTML($service->picture); ?>" alt="Photo du service"">
        </div>

          <a href=" /employeeUpdateService/index/<?= securityHTML($service->id_Service) ?>" class="link_update">Modifier</a>
        </div>
    <?php endforeach; ?>
    </div>

  </div>

</div>