<div class="main_hour">
<?php foreach ($hours as $hour) : ?>
  <div class="container_hour">
    <div class="hour_day"><?= $hour->day; ?></div>
    <div class=""><?= $hour->opening_time; ?></div>
    <div class=""><?= $hour->closing_time; ?></div>
  </div>
<?php endforeach; ?>
</div>