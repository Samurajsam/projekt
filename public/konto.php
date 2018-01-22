<?php

session_start();

if(!isset($_SESSION['zalogowany'])) //nie istnieje nie jestt ustawiona - jeżeli nie jest się zalogowanym, nie wejdziemy w konto.php - nastąpi przekierowanie do index.php
{
  headr('Location: index.php');
  exit();
}






?>

<!DOCTYPE HTML>
<html lang="pl_PL">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>BUS.PL Konto</title>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="css/user.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" ariaexpanded="false">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand">
            <img style="max-width:125px; margin-left: -15px; margin-top: -15px;" src="img/logo.jpg">
          </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right" style="margin-right: 5%;">
            <li>
              <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-user"></i> <b>
                          <?php
                          echo $_SESSION['user']
                          ?>
                          </b> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" id="menu">
                          <li>
                            <a class="dropdown-item">

                                <?php
                                echo $_SESSION['email'];
                                ?>

                            </a>
                          </li>
                          <li class="divider dropdown-divider"></li>
                          <li>

                              <a class="dropdown-item" href="logout.php"><i class="fas fa-power-off"></i> Wyloguj</a>

                          </li>
                        </ul>
                  </li>


          </li>

          </ul>
        </div>
    </div>
  </nav>
  <div style="width:100%; height:60px;"></div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8 col-xs-12">
        <div class="row">
          <div class="col-md-12 col-xs-12" id="product_msg">
          </div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading">

              <?php
                echo "<b>Data wygaśnięcia biletu</b>: ".$_SESSION['dnipremium']."</p>";

                $dataczas = new DateTime();

              	/* echo "Data i czas serwera: ".$dataczas->format('Y-m-d H:i:s')."<br>"; */

              	$koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);

              	$roznica = $dataczas->diff($koniec);

              	if($dataczas<$koniec)
              	echo "<b>Bilet ważny przez: </b>".$roznica->format('%m miesięcy, %d dni, %h godz');
              	else
              	echo "<p style='color:red'><b>Brak ważnego biletu okresowego!</b></p>";

               ?>

          </div>

        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 col-xs-12">
      <div class="row">
        <div class="col-md-12 col-xs-12" id="product_msg">
        </div>
      </div>
      <div class="panel panel-info">
        <div class="panel-heading">Bilety okresowe</div>
        <div class="panel-body">
          <div id="get_product">

          </div>

          <?php

          if(isset($_POST['doladowanie'])){
            $doladowanie = $_POST['doladowanie'];
            $dni = $_SESSION['dnipremium'];
            $date124232 = date_create_from_format('Y-m-d H:i:s', $dni);

              /*echo "<br>".$date124232->format('j')."<br>";*/
            // $rok =  substr ( $dni , 0, 4 );
          //   $miesiac = substr ( $dni , 5, 2 );
            $dzien = $date124232->format('j');
            $rok = $date124232->format('Y');
            $miesiac=$date124232->format('n');
            $koniec_biletu=0;

             if($dataczas<$koniec){
               $koniec_biletu=mktime(0, 0, 0, $miesiac, $dzien + $doladowanie, $rok);
             }else{
               $dzien = $dataczas->format('j');
               $rok = $dataczas->format('Y');
               $miesiac=$dataczas->format('n');
               $koniec_biletu=mktime(0, 0, 0, $miesiac, $dzien + $doladowanie, $rok);
             }

            //  $day=$dni->format('j');
            /*echo date("y.m.d",$koniec_biletu);*/
            $do_tabeli=date("y.m.d",$koniec_biletu);
            //no$_SESSION['dnipremium']=$do_tabeli;
            $user = $_SESSION['user'];
            $con = mysqli_connect('localhost','root','','projekt');
            $query = "UPDATE uzytkownicy SET dnipremium ='$do_tabeli' WHERE user='$user'";

            $result = mysqli_query($con,$query);
                /*("INSERT INTO uzytkownicy (id, user, pass, email, dnipremium) VALUES ('', '$user', '', '$email', 'now() + INTERVAL 30 DAY')");*/
                /*("UPDATE uzytkownicy SET dnipremium ='now() + INTERVAL 30 DAY' WHERE user='$user'");*/
                /*$dni = $_POST['dnipremium'];
                $result = $mysqli->query("UPDATE uzytkownicy SET dnipremium ='$koniec + INTERVAL 30 DAY' WHERE id='$user' ");*/
            if($result){

              ?>
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hiden="true">&times;</span>
                    </button>
                    <strong>Twoje konto zostało doładowane!</strong> Zaloguj się ponownie aby sprawdzić swój obecny stan konta.
                  </div>
              <?php
              } else {
              ?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hiden="true">&times;</span>
                    </button>
                    <strong>Niepowodzenie!</strong> Wystąpił błąd doładowania, spróbuj jeszcze raz
                  </div>

              <?php
                }
            }

            ?>


          <form method="post">
            <div class="col-md-4">
              <div class="panel panel-info">
                <!--<div class="panel-heading">3 miesiące</div>-->
                <div class="panel-body">
                  <img style="max-width:200px; margin:0px auto;display:block" src="img/90plus.jpg">
                </div>
                <div class="panel-heading">200,000 zł
                  <!--<button type="submit" name="trzymiechy" style="float:right;" class="btn btn-danger btn-xs"><i class="fab fa-paypal"></i> Kup</button>-->
                  <input type="radio" name="doladowanie" value="90" style="float:right;">

                </div>
              </div>
            </div>



          <div class="col-md-4">
            <div class="panel panel-info">
              <!--<div class="panel-heading">1 miesiąc</div>-->
              <div class="panel-body">
                <img style="max-width:200px; margin:0px auto;display:block" src="img/30plus.jpg">
              </div>
              <div class="panel-heading">80,000 zł
                <input type="radio" name="doladowanie" value="30" style="float:right;">
              </div>
            </div>
          </div>



          <div class="col-md-4">
            <div class="panel panel-info">
              <!--<div class="panel-heading">2 tygodnie</div>-->
              <div class="panel-body">
                <img style="max-width:200px; margin:0px auto;display:block" src="img/14plus.jpg">
              </div>
              <div class="panel-heading">50,000 zł
                <input type="radio" name="doladowanie" value="14" style="float:right;">
              </div>
            </div>
          </div>


          <div class="col-md-12">
            <p class="text-center">
              <button type="submit" name="buy" style="float:right;" class="btn btn-danger"><i class="fab fa-paypal"></i> Kup</button>
            </p>
          </div>
        </form>

        </div>
        <div class="panel-footer"><a href="https://github.com/Samurajsam" style="color:#336699">Grzegorz Błażusiak &copy; 2018</a></div>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>

</body>
</html>
