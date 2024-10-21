<?php

namespace Lib\config;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PhpMailerConfig
{
  private $mail;

  public function __construct()
  {
    //Instantiation and passing `true` enables exceptions
    $this->mail = new PHPMailer(true);

    $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $this->mail->IsSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = true;  // Authentification SMTP active
    $this->mail->Username = 'zooarcadia5@gmail.com';
    $this->mail->Password = 'sfor aopr akeh qecx'; // https://support.google.com/accounts/answer/185833?hl=fr
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = 587;
  }

  function sendMail($to, $from, $subject, $body)
  {
    $this->mail->SetFrom('from@example.com', 'Mailer');
    $this->mail->AddAddress($to);

    $this->mail->isHTML(true);
    $this->mail->Subject = $subject;
    $this->mail->Body = $body;

    if ($this->mail->Send()) {
      return true;
    } else {
      return 'Mail error: ' . $this->mail->ErrorInfo;
    }
  }
}
