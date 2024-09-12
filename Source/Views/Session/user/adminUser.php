<?php
use function Source\Helpers\securityHTML;
?>


<div class="main-admin-user">
  <div class="overlay"></div>
  <h3>Gestion des salariés</h3>

  <div class="form-create-admin">
    <h3>Créer un employé</h3>
    <?= securityHTML($createUserForm); ?>
    <img class="icon_close" src="/assets/images/icons/croix.png" alt="Fermer">
  </div>

  <div class="section-filter-admin-user">
    <?= securityHTML($filterFormUser) ?>
  </div>

  <button class="btn_popup_create_user btn">Créer un utilisateur</button>
  <?php foreach ($users as $u) : ?>
    <div class="container-user-admin">
      <div class="user-created-admin">
        <div class="user-item username"><?= securityHTML($u->username); ?></div>
        <div class="user-item email"><?= securityHTML($u->email); ?></div>
        <div class="user-item role"><?= securityHTML($u->role); ?></div>
        <div class="btn-gestion-user">
          <form method="POST" action="adminUser/deleteUser/<?= securityHTML($u->id_User) ?>">
            <button type="submit" class="delete_btn" name="deleteUser">Supprimer</button>
          </form>
          <form method="POST" action="/adminUpdateUser">
            <button type="submit" class="btn_update" name="updateUser">Modifier</button>
            <input type="hidden" name="id_user" value="<?= securityHTML($u->id_User) ?>">
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script src="/js/pages/sessions/admin/create_user.js"></script>