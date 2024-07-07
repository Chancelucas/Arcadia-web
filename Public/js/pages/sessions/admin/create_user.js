document.addEventListener('DOMContentLoaded', () => {
  const createButton = document.querySelector('.btn_popup_create_user');
  const formCreateAdmin = document.querySelector('.form-create-admin');
  const overlay = document.querySelector('.overlay');
  const closeIcon = document.querySelector('.icon_close');

  createButton.addEventListener('click', () => {
    formCreateAdmin.style.display = 'flex';
    overlay.style.display = 'block';
  });

  closeIcon.addEventListener('click', () => {
    formCreateAdmin.style.display = 'none';
    overlay.style.display = 'none';
  });

  overlay.addEventListener('click', () => {
    formCreateAdmin.style.display = 'none';
    overlay.style.display = 'none';
  });
});
