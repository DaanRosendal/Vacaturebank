<?php
//deze dependencies laten we automatisch in
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
//deze function stuurt e-mails via Gmail
function mailen($ontvangerStraat, $ontvangerNaam, $onderwerp, $bericht){
    $mail = new PHPMailer();
    
    //verbinden met Gmail
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;

    //identificeer jezelf bij Gmail
    $mail->Username = "phpmailertestmailaddress@gmail.com";
    $mail->Password = "Tester12!@!";

    //E-mail opstellen
    $mail->isHTML(true);
    $mail->SetFrom("phpmailertestmailaddress@gmail.com", "PowerJobs Vacaturebank");
    $mail->Subject = $onderwerp;
    $mail->CharSet = "UTF-8";
    $bericht = "<body style=\"font-family: Verdana, Verdana, Geneva, sans-serif; font-size: 14px; color: #000;\">" . $bericht . "</body></html>";
    $mail->AddAddress($ontvangerStraat, $ontvangerNaam);
    $mail->Body = $bericht;

    //stuur mail
    $mail->Send();
}
