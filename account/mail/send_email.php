<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer();

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.web.de';                 // Specify main and backup server                                   // Set the SMTP port
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'noreply.nopex@web.de';                // SMTP username
$mail->Password = 'Jacob1234';                  // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'noreply.nopex@web.de';
$mail->FromName = 'Nopex.net';
$mail->addAddress($email); // Der Name ist dabei optional
$mail->addReplyTo('noreply.nopex@web.de', 'noreply'); // Antwortadresse festlegen
$mail->isHTML(true); // Mail als HTML versenden
$mail->Subject = $subject;
$mail->Body = $_EMAIL_CONTENT;

$mail->send();
?>
