<?php
use function Source\Helpers\securityHTML;
?>


<div>

    <div>
        <a class="link_back_btn" href="javascript:history.back()">Retour</a>
    </div>
    <div class="container_update_service_admin">
        <?= securityHTML($serviceForm); ?>
    </div>

</div>