<?php
session_start();

@include_once('dbConnect.php');

$sql = "SELECT * FROM users WHERE Id = :Id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['Id'=>$_SESSION['newUserId']]);
$user = $stmt -> fetch();
$Email = $user->Email;
$Token = $user->EmailVerificationToken;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );                     
  $mail->isSMTP();        
  $mail->Host       = '108.177.126.109';                 
  $mail->SMTPAuth   = true;                                    
  $mail->Password   = '123123123jayo9';                               
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
  $mail->Port       = 587;                                   

  
  $mail->setFrom('doej43253@gmail.com');
  $mail->addAddress($Email);    


  $mail->isHTML(true);                                
  $mail->Subject = 'Here is the subject';
  $mail->Body    = 'http://192.168.64.2/lab3-omanadze/activate-user.php?token='. $Token.'';
  $mail->AltBody = 'http://192.168.64.2/lab3-omanadze/activate-user.php?token='. $Token.'';

  $mail->send();
  echo 'Message has been sent';

  header("Location: index.php");
  exit();

} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
