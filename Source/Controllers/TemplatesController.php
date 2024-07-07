<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class TemplatesController extends Controller
{

  public function PageCookies()
  {
    $this->render('templates/cookies', [
    
    ]);
  }

  public function PageLegalNotices()
  {
    $show = $this->show();

    $this->render('templates/legal_notices', [
      'show' => $show
    
    ]);
  }

  public function PageTerms()
  {
    $this->render('templates/terms', [
    
    ]);
  }

  function show()
  {
    echo "Hello world";
  }


}
