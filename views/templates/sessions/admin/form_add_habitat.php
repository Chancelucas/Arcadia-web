<form id="form_habitat_admin" action="" method="post" enctype="multipart/form-data">
    <input type="text" class="habitat_form_input" id="habitat_name" name="habitat_name" placeholder="Ajouter un nom" required>
    <textarea type="text" class="habitat_form_input" id="habitat_description" name="habitat_description" placeholder="Ajouter une description" required></textarea>
    <select name="animals" id="habitat_add_animals" class="habitat_form_input">
        <option value="<?php ; ?>"><?php ; ?></option>
    </select>
    <div id="div_add_doc_habitat">
        <input type="file" name="habitat_photo[]" id="habitat_add_picture" class="habitat_form_input" multiple />
        <label for="habitat_add_picture">Choisir des photos</label>
        <span id="selected_files"></span>
    </div>

    <button type="submit" name="enregistrer" id="habitat_btn_save" class="habitat_form_input">Enregistrer</button>
</form>