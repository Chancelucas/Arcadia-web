<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_update_habitat_admin">

    <div>
        <a class="link_back_btn" href="javascript:history.back()">Retour</a>
    </div>
    <div class="container_update_hour_admin">
        <?= securityHTML($hourForm); ?>
    </div>

</div>