<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

function send_mail($config)
{
      $mail = new PHPMailer;

      //$mail->SMTPDebug = 3;                               // Enable verbose debug output
      $mail->CharSet = 'UTF-8';
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'ac34bf99ee5c24';                 // SMTP username
      $mail->Password = '97ec8348dc89fc';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                 // TCP port to connect to

      $mail->setFrom('gblazusiak@gmail.com', 'Grzesiek');
      $mail->addAddress('gblazusiak@gmail.com', 'Grzesiek');     // Add a recipient

      $mail->addReplyTo($config->from_email, $config->from_name);

      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = $config->mail_subject;
      $mail->Body    = $config->mail_body;

      $html = new \Html2Text\Html2Text($mail->Body);
      $mail->AltBody = $html->getText();

      if(!$mail->send()) {
          echo "<script>alert('Wiadomość nie może zostać wysłana. Błąd:') .$mail->ErrorInfo</script>";

      } else {
          echo "<script>alert('Wiadomość została wysłana pomyślnie')</script>";
      }


}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$config = (object) [
		'from_email' => $_POST['from_email'],
		'from_name' => $_POST['from_name'],
		'mail_subject' => $_POST['mail_subject'],
		'mail_body' => $_POST['mail_body'],
	];
	send_mail($config);

}
session_unset();

header('Location: index.php');

?>
