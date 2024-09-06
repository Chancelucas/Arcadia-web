document.addEventListener('DOMContentLoaded', () => {
  // Sélectionnez tous les boutons avec la classe 'btn_reviews_employee'
  const changeBtns = document.querySelectorAll('.btn_reviews_employee');

  // Parcourez tous les boutons sélectionnés
  changeBtns.forEach(changeBtn => {
    changeBtn.addEventListener('click', (event) => {
      // Empêche le formulaire de soumettre immédiatement
      event.preventDefault();

      // Vérifiez le texte du bouton pour déterminer l'action à effectuer
      if (changeBtn.textContent.trim() === false) {
        changeBtn.classList.add('delete-user-btn');  // Ajoute la classe 'delete-user-btn'
        //changeBtn.classList.remove('btn'); // Supprime la classe 'btn' si elle existe
      } else if (changeBtn.textContent.trim() === true) {
        changeBtn.classList.add('btn');  // Ajoute la classe 'btn'
        //changeBtn.classList.remove('delete-user-btn'); // Supprime la classe 'delete-user-btn' si elle existe
      }

      // Optionnel : Soumet le formulaire après la modification des classes
      changeBtn.closest('form').submit();
    });
  });
});
