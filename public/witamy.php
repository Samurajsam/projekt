<?php

  session_start();

  if(!isset($_SESSION['udanarejestracja']))
  {
    header('Location: index.php');
    exit();
  }
  else
  {
    unset($_SESSION['udanarejestracja']);
  }

  //Usuwamy zmiennych sesyjnych używanych do zapamiętywania wartości podczas udanej walidacji
  if (isset($_SESSION['form_nick'])) unset($_SESSION['form_nick']);
  if (isset($_SESSION['form_email'])) unset($_SESSION['form_email']);
  if (isset($_SESSION['form_haslo1'])) unset($_SESSION['form_haslo1']);
  if (isset($_SESSION['form_haslo2'])) unset($_SESSION['form_haslo2']);
  if (isset($_SESSION['form_regulamin'])) unset($_SESSION['form_regulamin']);

  //usuwanie zmiennych sesyjnych z błędami
  if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
  if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
  if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
  if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
  if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);


?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>BUS.PL</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


  <link rel="stylesheet" href="css/welcome.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <script src="stronkabootstrap.js"></script>

</head>

<body>
  <nav class="navbar navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">
            <img style="max-width:125px; margin-left: -15px; margin-top: -15px;" src="img/logo.jpg">
          </a>
        </div>
      </div>
  </nav>

<div style="width:100%; height:200px;"></div>
<div class="container-fluid">
    <img style="max-width:500px;" src="img/welcome.png" class="img-responsive center-block">
</div>

<div>
<p class="text-center">
Przejdź do strony głównej i <a href="index.php">zaloguj się na swoje konto</a>
</p>
</div>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
