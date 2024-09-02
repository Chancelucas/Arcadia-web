<nav class="session_navbar">
  <div class="div_nav_session">
    <div class="icons_menu_session">
      <img class="icon_menu_session" src="/assets/images/icons/menu.png" alt="Menu">
      <img class="icon_close_session" src="/assets/images/icons/croix.png" alt="Fermer">
    </div>

    <div class="user_dashboard">
      <p class="name_user_dashboard"><?= $user->getUsername() ?></p>
      <p class="role_user_dashboard"><?= $user->getRole(); ?></p>
    </div>

    <ul class="ul_links_session_nav">
      <li class="li_link_session_nav"><a href="/employeeDashboard">Dashboard</a</li>
      <li class="li_link_session_nav"><a href="/employeeReview">Avis des clients</a></li>
      <li class="li_link_session_nav"><a href="/employeeService">Service</a></li>
      <li class="li_link_session_nav"><a href="/employeeFoodGiven">Historique des repas</a></li>
      <li class="li_link_session_nav"><a href="/employeeAnimalFeed">Nourrir un animal</a></li>
    </ul>
    <a class="link_logout" href="/employeeDashboard/logout">Déconnexion</a>
  </div>
</nav>