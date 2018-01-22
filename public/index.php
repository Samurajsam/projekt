<?php

session_start();

if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany']==true)) //zalogowany cały czas
{
  header('Location: konto.php');
  exit(); //kończy połączenie z bazą ale nadal zalogowany
}
?>
<!DOCTYPE html>
<html lang="pl_PL">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>BUS.PL</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


  <link rel="stylesheet" href="style.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />


  	<script src="newsletter.js"></script>

    <script>
    function myMap() {
    var mapOptions = {
      center: new google.maps.LatLng(50.0655, 19.923),
      zoom: 17,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBb9PhuKWnZF3YMhRhvBKrkO9Ix_0IN1nA&callback=myMap"></script>

    <script>
    function jumptogallery() {
        var elmnt = document.getElementById("galeria");
        elmnt.scrollIntoView();
    }
    </script>
    <script>
    function jumptoplan() {
        var elmnt = document.getElementById("plan");
        elmnt.scrollIntoView();
    }
    </script>
    <script>
    function jumptocontact() {
        var elmnt = document.getElementById("kontakt");
        elmnt.scrollIntoView();
    }
    </script>
  </head>

 <body onload="myMap()">
			<nav class="navbar navbar-inverse navbar-fixed-top">
				  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" ariaexpanded="false">
								<span class="sr-only">Toggle navigation</span>
							</button>
							<a class="navbar-brand" href="index.php">
								<img style="max-width:125px; margin-left: -15px; margin-top: -15px;" src="img/logo.jpg">
							</a>
						</div>
						<div class="collapse navbar-collapse" id="navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
							  <li><a onclick="jumptogallery()">Galeria</a></li>
                <li><a onclick="jumptoplan()">Rozkład</a></li>
							  <li><a onclick="jumptocontact()">Kontakt</a></li>
                <li>
                  <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Logowanie</b> <span class="caret"></span></a>
                  			<ul id="login-dp" class="dropdown-menu">
                  				<li>
                  					 <div class="row">
                  							<div class="col-md-12">

                                  <form action="zaloguj.php" method="post" id="login-nav">
                                    <fieldset>
                  										<div class="form-group">
                  											 <input class="form-control" placeholder="Login" type="text" name="login" id="exampleInputEmail2"/> <!--  required przed name-->
                  										</div>
                  										<div class="form-group">
                  											 <input class="form-control" placeholder="Hasło" type="password" name="haslo" id="exampleInputPassword2"/> <!--  required -->
                                      </div>

                                      <?php
                                        if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
                                      ?>

                  										<div class="form-group">
                  											 <input type="submit" class="btn btn-primary btn-block" value="Zaloguj"/>
                  										</div>
                                    </fieldset>
                  								 </form>
                  							</div>
                  							<div class="bottom text-center">
                  								Jesteś tu nowy? <a href="rejestracja.php"><b>Zarejestruj się</b></a>
                  							</div>
                  					 </div>
                  				</li>
                  			</ul>
                      </li>


              </li>

							</ul>
						</div>
				</div>
			</nav>


      <header class="masthead text-center d-flex">
        <div class="container my-auto">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-lg-8 mx-auto">
              <h1 class="text-uppercase" style="color:white; text-shadow: 2px 2px 2px #000000">
                <strong>Zarejestruj się i zyskaj 7 dni darmowych przejazdów!</strong>
              </h1>
              <hr>
            </div>
            <div class="col-md-2"></div>
            <div class="col-lg-12 mx-auto">
              <a class="btn btn-primary btn-lg" href="rejestracja.php">REJESTRACJA</a>
            </div>
          </div>
        </div>
      </header>


    <div class="container-fluid">
      <div style="width:100%;height:80px;"></div>
      <div class="col-md-12">
          <img style="max-width:400px;" src="img/naglowek2.png" class="img-responsive center-block">
      </div>
      <div class="row" id="opis">
        <div class="col-md-1">

       </div>

        <div class="col-md-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>


        <div class="col-md-5">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>

        <div class="col-md-1">

        </div>
      </div>
      <div style="width:100%;height:80px;"></div>
    </div>

    <div class="container-fluid">

          <div id="galeria">
					<div id="carouselID" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carouselID" data-slide-to="0"
							class="active"></li>
							<li data-target="#carouselID" data-slide-to="1"></li>
							<li data-target="#carouselID" data-slide-to="2"></li>
							<li data-target="#carouselID" data-slide-to="3"></li>
						</ol>
							<div class="carousel-inner" role="listbox">
								<div class="item active">
									<img src="img/15.jpg" alt="1">
									<div class="carousel-caption">Przyjemna podróż</div>
								</div>
								<div class="item">
									<img src="img/17.jpg" alt="2">
									<div class="carousel-caption">Piękne miejsca</div>
								</div>
								<div class="item">
									<img src="img/16.jpg" alt="3">
									<div class="carousel-caption">Niezapomniane przeżycia</div>
								</div>
								<div class="item">
									<img src="img/basel.jpg" alt="4">
									<div class="carousel-caption">Świat nigdy nie był tak blisko</div>
								</div>
							</div>
							<a class="left carousel-control" href="#carouselID" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" ariahidden="true"></span>
								<span class="sr-only">Poprzedni</span>
							</a>
							<a class="right carousel-control" href="#carouselID" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" ariahidden="true"></span>
							<span class="sr-only">Następny</span>
							</a>

					</div>
          </div>

      </div>


			</br>
			</br>

		<div class="container-fluid" id="plan">
      <div style="width:100%;height:20px;"></div>
          <div class="col-md-12">
              <img style="max-width:400px;" src="img/naglowek.png" class="img-responsive center-block">
          </div>
					<div class="row">
					  <div class="col-md-1">

					 </div>

					  <div class="col-md-5">
                <img style="max-width:380px;" src="img/krk.png" class="img-responsive center-block">
					  </div>


					  <div class="col-md-5">
                <img style="max-width:380px;" src="img/kato.png" class="img-responsive center-block">
					  </div>

            <div class="col-md-1">

					  </div>
					</div>
				</div>

			</br>
      </br>
      </br>

        <section class="pierwsza pierwsza-1">
          <div id="newsletterform">
              <div class="wrap" style="text-shadow: 2px 2px 2px #000000">
                  <h3>Chcesz być na bieżąco?</h3>
                  <p>Zapisz się na newsletter i bądź na bieżąco z Naszą ofertą</p>
                  <form action="send.php" method="post" id="newsletter" name="newsletter">
                      <input type="email" name="signup-email" id="signup-email" value="" placeholder="Wpisz tutaj swój adres email" />
                      </br>
                      <input type="submit" value="ZAPISZ SIĘ!" name="signup-button" id="signup-button">
                      <span class="arrow"></span>
                  </form>
              </div>
          </div>
        </section>


      </br>

<div class="container" id="kontakt">


<div style="width:100%;height:60px;"></div>
        <div class="col-md-6">
          <div id="tekst2">
            <h4>Po szczegółowe informacje zapraszamy do naszej siedziby</h4>
          </div>
          <div id="map" style="width:100%;height:350px;"></div>
        </div>

        <div class="col-md-6" id="mail">
            <form class="form-horizontal" action="mailer.php" method="POST">
              <div class="form-group">
                <label for="inputEmail" class="control-label"></label>
                <div class="col-sm-12">
                  <h4>Napisz do Nas</h4>
                  <input type="email" name="from_email" class="form-control" id="inputEmail" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="inputSubject" class="control-label"></label>
                <div class="col-sm-12">
                <input type="text" name="mail_subject" class="form-control" id="inputSubject" placeholder="Temat">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                <label for="inputMessage" class="control-label"></label>
                <textarea class="form-control" name="mail_body" rows="8" id="inputMessage" placeholder="Treść"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <p class="text-right">
                  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> WYŚLIJ</button>
                </div>
              </div>
              </form>
          </div>
</div>


    </br>

			<footer>
				<div class="container-fluid">

          <div class="col-md-12">
          <p class="text-center">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="polityka">
					Polityka prywatności
					</button>
          </p>
          </div>
          <div class="col-md-12"><a href="https://github.com/Samurajsam"><p class="text-center" id="github">Grzegorz Błażusiak &copy; 2018</p></a></div>
				</div>
			</footer>

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title" id="myModalLabel">POLITYKA PRYWATNOŚCI</h4>
						</div>
						<div class="modal-body">
							<p>Serwis szanuje prywatność swoich użytkowników. Przeczytaj dokładnie poniższe informacje, aby lepiej zapoznać się z naszą polityką prywatności.
								<br><br><h4>Prawa autorskie</h4><br>
								Serwis zawiera przekierowania (linki) do innych stron www wraz ze zwięzłym opisem. Treści zawarte na tych stronach są przedmiotem praw autorskich przysługujących ich twórcy i podlegają ochronie zgodnie z prawem autorskim.
								<br><br><h4>Zastrzeżenia prawne i odpowiedzialność</h4><br>
								Wszelkie materiały zawarte w serwisie są bezpłatne. Użytkownicy oraz zespół serwisu nie odpowiadają za jakiekolwiek szkody wynikłe z ich korzystania. Serwis zastrzega sobie możliwość edycji i usuwania wpisów oraz blokowania użytkowników, którzy naruszają regulamin serwisu.
								<br><br><h4>Informacje logowania</h4><br>
								Podczas korzystania z serwisu bus.pl nasze serwery automatycznie rejestrują informacje przesyłane przez przeglądarkę użytkownika w trakcie wyświetlania witryny. Dzienniki serwera mogą zawierać takie informacje jak: żądanie sieciowe, adres IP, typ przeglądarki, język przeglądarki, data i godzina przesłania żądania oraz co najmniej jeden plik cookie.
								<br><br><h4>Cookies (ciasteczka)</h4><br>
								Pliki cookie to małe pliki tekstowe wykorzystywane do zapisywania pewnych informacji na Twoim komputerze. Cookies nie są szkodliwe ani dla Ciebie, ani dla Twojego komputera i danych, dlatego zalecamy niewyłączanie ich obsługi w przeglądarkach. Funkcja logowania w serwisie wymaga obsługi ciasteczek. Stosowanie cookies umożliwia podnoszenie jakości naszych usług oraz zwiększania zadowolenia naszych użytkowników dzięki przechowywaniu ich preferencji oraz śledzeniu trendów i sposobów poruszania się po serwisie.
							</p>
						</div>
						<div class="modal-footer">
							<p class="text-center">
							<button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Zamknij</button>
							</p>
						</div>
					</div>
				</div>
			</div>

				<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
				<!-- Include all compiled plugins (below), or include individual files as needed -->
				<script src="js/bootstrap.min.js"></script>


  </body>
</html>
