const iconMenuAdmin = document.querySelector('.icons_menu_admin .icon_menu_admin');
const iconCloseAdmin = document.querySelector('.icons_menu_admin .icon_close_admin');
const menuLinksAdmin = document.querySelector('.ul_links_admin_nav');

iconMenuAdmin.addEventListener('click', () => {
    menuLinksAdmin.style.display = 'flex';
    iconMenuAdmin.style.display = 'none';
    iconCloseAdmin.style.display = 'flex';
});

iconCloseAdmin.addEventListener('click', () => {
    menuLinksAdmin.style.display = 'none';
    iconMenuAdmin.style.display = 'flex';
    iconCloseAdmin.style.display = 'none';
});
