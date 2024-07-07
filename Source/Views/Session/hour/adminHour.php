<div id="main_edit_hour">
    <div id="div_form_create_hour">
        <?= $createHourForm; ?>
    </div>

    <?php foreach ($hours as $hour) : ?>
      <div id="container_hour_admin">
      <div id="hour_creaded_admin">
        <div class="item"><?= $hour->day; ?></div>
        <div class="item"><?= $hour->opening_time; ?></div>
        <div class="item service"><?= $hour->closing_time; ?></div>

        <div class="btn_gestion_hour">
          <form method="POST" action="/adminHour/deleteHour/<?= $hour->id_Hour ;?>">
            <button type="submit" class="delete-hour-btn" name="deleteHour">Supprimer</button>
          </form>

          <a href="/adminUpdateHour/index/<?= $hour->id_Hour ?>" class="link_update_hour">Modifier</a>

        </div>

      </div>
    </div>
    <?php endforeach; ?>
</div>
