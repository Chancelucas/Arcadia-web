<?php
use Source\Helpers\FlashMessage;

?>


<div class="main_update_habitat_admin">

    <div>
        <a class="link_back_btn" href="javascript:history.back()">Retour</a>
    </div>

    <?= FlashMessage::displayFlashMessage(); ?>

    <div class="container_update_habitat_admin">
        <?= $habitatForm; ?>
    </div>

</div>