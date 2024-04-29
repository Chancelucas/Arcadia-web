<main id="main_edit_habitats">
  <div id="container_form_habitat_admin">
    <h3>Crée un habitat</h3>
    <?= $createHabitatForm; ?>
  </div>
  <div id="habitats-list">
    <h3>Liste des habitats</h3>
    <table>
      <tbody id="view_habitats">
        <?php foreach ($habitats as $habitat) : ?>
          <tr id="habitat">
            <td id="title_habitat">
              <h4><?= $habitat->name ?></h4>
            </td>

            <td id="btns_habitat_view">
              <form method="POST" action="adminHabitat/deleteHabitat/<?= $habitat->id ?>">
                <button type="submit" class="habitat-btn" id="delete-habitat-btn" name="deleteHabitat">Supprimer</button>
              </form>
              <a href="/adminUpdateHabitat/index/<?= $habitat->id ?>" class="habitat-btn" id="update-habitat-btn">Modifier</a>
            </td>

            <td id="image_habitat_view"> 
              <img src="<?= $habitat->picture_url ?>" alt="Photo habitat">
            </td>

            <td id="description_habitat_view"><?= $habitat->description ?></td>
            <td id="animals_habitat_view">
              <?php foreach ($habitat->animals as $animal) : ?>
                <?= $animal->breed ?><br>
                <?= $animal->picture ?><br>

              <?php endforeach; ?>
            </td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>