<?php
use function Source\Helpers\securityHTML;
?>


<main class="main_element_on_click">
  <a class="link_back_btn" href="javascript:history.back()">Retour</a>
  <div class="div_element_on_click">
    <h3 class="name_element_on_click"><?= securityHTML($service->name) ?></h3>
    <img class="img_element_on_click" src=" <?= securityHTML($service->picture_url) ?>" alt="<?= securityHTML($service->name) ?>">
    <p class="description_element_on_click"><?= securityHTML($service->description) ?></p>
  </div>
</main>