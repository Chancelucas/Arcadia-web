<nav class="admin_navbar">
  <div class="div_nav_admin">
    <div class="icons_menu_admin">
      <img class="icon_menu_admin" src="/assets/images/icons/menu.png" alt="Menu">
      <img class="icon_close_admin" src="/assets/images/icons/croix.png" alt="Fermer">
    </div>

    <div class="user_dashboard">
      <p class="name_user_dashboard"><?= $user->getUsername() ?></p>
      <p class="role_user_dashboard"><?= $user->getRole(); ?></p>
    </div>

    <ul class="ul_links_admin_nav">
      <li class="li_link_admin_nav"><a href="/adminDashboard">Dashboard</a></li>
      <li class="li_link_admin_nav"><a href="/adminUser">Salariés</a></li>
      <li class="li_link_admin_nav"><a href="/adminHabitat">Habitats</a></li>
      <li class="li_link_admin_nav"><a href="/adminAnimal">Animaux</a></li>
      <li class="li_link_admin_nav"><a href="/adminService">Services</a></li>
      <li class="li_link_admin_nav"><a href="/adminHour">Horaire</a></li>
      <li class="li_link_admin_nav"><a href="/adminReport">Comptes rendus</a></li>
    </ul>
    <a class="link_logout" href="/adminDashboard/logout">Déconnexion</a>
  </div>