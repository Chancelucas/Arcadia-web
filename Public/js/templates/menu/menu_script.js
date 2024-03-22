const iconMenu = document.getElementById('icon_menu');
const iconClose = document.getElementById('icon_close');
const menuLinks = document.getElementById('ul_links_pulic');

iconMenu.addEventListener('click', () => {
    menuLinks.style.display = 'flex';
    iconMenu.style.display = 'none';
    iconClose.style.display = 'block';
});

iconClose.addEventListener('click', () => {
    menuLinks.style.display = 'none';
    iconMenu.style.display = 'block';
    iconClose.style.display = 'none';
});
