<?php
use function Source\Helpers\securityHTML;
?>


<main class="main_services_page">
  <h3 class="main_title_page">Les services du zoo</h3>

  <div class="all_services_page">
    <?php if ($allServices) : ?>
      <?php foreach ($allServices as $service) : ?>
        <div class="element_service_page" onclick="location.href='/services/page/<?= securityHTML($service->id_Service) ?>'" style="background-image: url('<?= securityHTML($service->picture); ?>');">
          <!-- <div onclick="location.href='/services/page/<?= securityHTML($service->slug) ?>'"> -->
          <p class="title_element_service_page"><?= securityHTML($service->name); ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>