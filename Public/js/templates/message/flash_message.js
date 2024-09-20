
  const flashMessage = document.getElementById('flash-message');
  
  if (flashMessage) {
    setTimeout(() => {
      flashMessage.style.display = 'none';
    }, 5000); // 5 secondes
  }
