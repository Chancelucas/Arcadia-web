<?php
use Source\Helpers\FlashMessage; 
?>

<?= FlashMessage::displayFlashMessage(); ?>

<div class="main_admin_update_user">

    <div class="admin_update_user_link_back">
        <a class="link_back_btn" href="javascript:history.back()" >Retour</a>
    </div>
    <div class="container_update_user">
        <?= $userForm; ?>
    </div>

</div>