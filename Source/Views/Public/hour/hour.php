<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_hour">
<?php foreach ($hours as $hour) : ?>
  <div class="container_hour">
    <div class="hour_day"><?= securityHTML($hour->day); ?></div>
    <div class=""><?= securityHTML($hour->opening_time); ?></div>
    <div class=""><?= securityHTML($hour->closing_time); ?></div>
  </div>
<?php endforeach; ?>
</div>