<?php
use Source\Helpers\securityHTML;
?>


<div class="main_edit_hour_admin">
  <div class="div_form_create_hour_admin">
    <?= $createHourForm; ?>
  </div>

  <div class="container_hour_admin">
    <?php foreach ($hours as $hour) : ?>

      <div class="hour_creaded_admin">
        <div class="item_hour_admin"><?= $hour->day ?></div>
        <div class="item_hour_admin"><?= $hour->opening_time ?></div>
        <div class="item_hour_admin"><?= $hour->closing_time ?></div>

        <div class="btn_gestion_hour_admin">
          <form method="POST" action="/adminHour/deleteHour/<?= $hour->id_Hour ?>">
            <button type="submit" class="delete_btn" name="deleteHour">Supprimer</button>
          </form>

          <a href="/adminUpdateHour/index/<?= $hour->id_Hour ?>" class="link_update">Modifier</a>

        </div>

      </div>
    <?php endforeach; ?>

  </div>
</div>