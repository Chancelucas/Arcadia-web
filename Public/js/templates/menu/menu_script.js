const iconMenu = document.querySelector('.icon_menu');
const iconClose = document.querySelector('.icon_close');
const menuLinks = document.querySelector('.ul_links_public_nav');


iconMenu.addEventListener('click', () => {
    menuLinks.style.display = 'flex';
    iconMenu.style.display = 'none';
    iconClose.style.display = 'flex';
});

iconClose.addEventListener('click', () => {
    menuLinks.style.display = 'none';
    iconMenu.style.display = 'block';
    iconClose.style.display = 'none';
});
