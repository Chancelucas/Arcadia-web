<main id="main_edit_service">


  <div id="div_form_create_service">
    <?= $createServiceForm; ?>
  </div>


  <?php foreach ($services as $service) : ?>

    <div id="container_service_admin">
      <div id="service_creaded_admin">
        <div class="item"><?= $service->name; ?></div>
        <div class="item"><?= $service->description; ?></div>

        <div id="picture_service_view">
          <img src="<?= $service->picture; ?>" alt="Photo du service"">
        </div>

        <div class=" btn_gestion_service">
          <form method="POST" action="/adminService/deleteService/<?= $service->id_Service; ?>">
            <button type="submit" class="delete-service-btn" name="deleteService">Supprimer</button>
          </form>

          <a href="/adminUpdateService/index/<?= $service->id_Service ?>" class="link_update_service">Modifier</a>

        </div>

      </div>
    </div>

  <?php endforeach; ?>
</main>

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