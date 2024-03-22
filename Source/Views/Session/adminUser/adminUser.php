<main>
    <h3>Gestion des salariés</h3>

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
                    <button type="button" class="delete-user-btn"><?= $deleteUser ?>Supprimer</button>
                    <button type="button" class="edit-user-btn"><?= $updateUser ?>Modifier</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</main>
