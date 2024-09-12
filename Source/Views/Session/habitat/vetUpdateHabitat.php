<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_update_report_vet">

    <a class="link_back_btn" href="javascript:history.back()">Retour</a>

    <div class="container_form_update_report_vet">
        <?= securityHTML($habitatReportForm); ?>
    </div>

</div>