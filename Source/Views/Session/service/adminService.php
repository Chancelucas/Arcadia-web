<?php
use function Source\Helpers\securityHTML;
?>


<div class="main_edit_service_admin">


  <div class="div_form_create_service_admin">
    <?= $createServiceForm; ?>
  </div>



  <div class="container_service_admin">
    <?php foreach ($services as $service) : ?>

      <div class="service_creaded_admin">
        <p class="item_service_admin title_service_admin"><?= securityHTML($service->name); ?></p>
        <p class="item_service_admin texte_service_admin"><?= securityHTML($service->description); ?></p>

        <div class="picture_service_view_admin">
          <img class="picture_service_admin" src="<?= securityHTML($service->picture); ?>" alt="Photo du service"">
        </div>

        <div class=" btn_gestion_service_admin">
          <form method="POST" action="/adminService/deleteService/<?= securityHTML($service->id_Service); ?>">
            <button type="submit" class="delete_btn" name="deleteService">Supprimer</button>
          </form>

          <a href="/adminUpdateService/index/<?= securityHTML($service->id_Service) ?>" class="link_update">Modifier</a>

        </div>

      </div>
    <?php endforeach; ?>

  </div>


  <script>
    const nameElement = document.querySelector('#name')
    const slugElement = document.querySelector('#slug')

    const createSlug = (name) => {
      // Convertir la chaîne de caractères en minuscules
      let slug = name.toLowerCase();

      // Remplacer les caractères spéciaux et les accents
      slug = slug.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

      // Remplacer les espaces et autres caractères non désirés par des tirets
      slug = slug.replace(/[^a-z0-9]+/g, '-');

      // Supprimer les tirets en début et fin de chaîne
      slug = slug.replace(/^-+|-+$/g, '');

      return slug;
    }

    const slugify = (e) => {
      const name = e.target.value
      slugElement.value = createSlug(name)
    }

    nameElement.addEventListener('keyup', slugify)
  </script>