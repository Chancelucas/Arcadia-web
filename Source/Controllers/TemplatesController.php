<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class TemplatesController extends Controller
{

  public function showPageCookies()
  {
    $this->render('templates/cookies', [
    
    ]);
  }

  public function showPageLegalNotice()
  {
    $show = $this->show();

    $this->render('templates/legal_notices', [
      'show' => $show
    
    ]);
  }

  public function showPageTerms()
  {
    $this->render('templates/terms', [
    
    ]);
  }

  function show()
  {
    echo "Hello world";
  }


}
