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

    $this->render('templates/legal_notices', [
  
    ]);
  }

  public function PageTerms()
  {
    $this->render('templates/terms', [
    
    ]);
  }

  public function ForgotPassword()
  {
    $this->render('templates/forgot_password', [
    
    ]);
  }



}
