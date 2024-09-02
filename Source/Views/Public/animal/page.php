<main class="main_element_on_click">
  <a class="btn_back" href="javascript:history.back()">Retour</a>
  <div class="div_element_on_click">
    <h3 class="name_element_on_click"><?= $animal->name ?></h3>
    <p class="breed_element_on_click"><?= $animal->breed ?></p>
    <img class="img_element_on_click" src="<?= $animal->picture_url ?>" alt="<?= $animal->breed ?>">
    <p>
     
    </p>
  </div>
</main>