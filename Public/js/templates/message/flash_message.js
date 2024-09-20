
  // Sélectionne l'élément avec l'ID 'flash-message'
  const flashMessage = document.getElementById('flash-message');
  
  // Masque le message après 10 secondes (10 000 ms)
  if (flashMessage) {
    setTimeout(() => {
      flashMessage.style.display = 'none';
    }, 10000); // 10 secondes
  }
