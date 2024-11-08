const iconMenuSession = document.querySelector('.icons_menu_session .icon_menu_session');
const iconCloseSession = document.querySelector('.icons_menu_session .icon_close_session');
const menuLinksSession = document.querySelector('.ul_links_session_nav');

iconMenuSession.addEventListener('click', () => {
    menuLinksSession.style.display = 'flex';
    iconMenuSession.style.display = 'none';
    iconCloseSession.style.display = 'flex';
});

iconCloseSession.addEventListener('click', () => {
    menuLinksSession.style.display = 'none';
    iconMenuSession.style.display = 'flex';
    iconCloseSession.style.display = 'none';
});
