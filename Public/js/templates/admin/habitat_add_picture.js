document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('habitat_add_picture');
    const label = document.querySelector('label[for="habitat_add_picture"]');
    const labelVal = label.textContent;
    const selectedFiles = document.getElementById('selected_files');

    input.addEventListener('change', function (e) {
        let fileNames = '';
        for (let i = 0; i < this.files.length; i++) {
            if (i === 0) {
                fileNames += this.files[i].name;
            } else {
                fileNames += ', ' + this.files[i].name;
            }
        }
        selectedFiles.innerHTML = fileNames || labelVal;
    });
});
