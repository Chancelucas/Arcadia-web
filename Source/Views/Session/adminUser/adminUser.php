<main>

    <div id="form_create_admin">
        <?= $createUserForm; ?>
    </div>

    <?php foreach ($users as $user) : ?>

        <div id="container_user_admin">
            <div id="user_creaded_admin">
                <div class="item"><?= $user->username; ?></div>
                <div class="item"><?= $user->email; ?></div>
                <div class="item role"><?= $user->role; ?></div>
                <div class="btn_gestion_user">
                    <form method="POST" action="">
                        <button type="submit" class="delete-user-btn" name="deleteUser">Supprimer</button>
                        <input type="hidden" name="id_user" value="<?php echo $user->id_User ?>">
                    </form>
                    <form method="POST" action="/adminUpdateUser">
                        <button type="submit" class="edit-user-btn" name="updateUser">Modifier</button>
                        <input type="hidden" name="id_user" value="<?php echo $user->id_User ?>">
                    </form>
                </div>
            </div>
        </div> 
    <?php endforeach; ?>
</main>