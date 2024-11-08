<?php
?>


<nav class="session_navbar">
  <div class="div_nav_session">
    <div class="icons_menu_session">
      <img class="icon_menu_session" src="/assets/images/icons/menu.png" alt="Menu">
      <img class="icon_close_session" src="/assets/images/icons/croix.png" alt="Fermer">
    </div>

    <div class="user_dashboard">
      <p class="name_user_dashboard"><?= $user->getUsername() ?></p>
      <p class="role_user_dashboard"><?= $user->getRole() ?></p>
    </div>

    <ul class="ul_links_session_nav">
      <li class="li_link_session_nav"><a href="/vetDashboard">Dashboard</a></li>
      <li class="li_link_session_nav"><a href="/vetHabitat">Habitats</a></li>
      <li class="li_link_session_nav"><a href="/vetAnimal">Animaux</a></li>
      <li class="li_link_session_nav"><a href="/vetReport">Comptes rendus</a></li>
    </ul>
    <a class="link_logout" href="/vetDashboard/logout">Déconnexion</a>
  </div>
</nav>