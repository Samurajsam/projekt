<?php

session_start();

if (isset($_POST['email']))
{
    //udana walidacja - zakładamy że tak
    $wszysko_OK=true;
    $nick = $_POST['nick'];
    if ((strlen($nick)<3)||(strlen($nick)>20))
    {
      $wszysko_OK=false;
      $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
    }

    if(ctype_alnum($nick)==false)
    {
      $wszysko_OK=false;
      $_SESSION['e_nick']="Nick nie może zawierać polskich znaków oraz znaków specjalnych (tylko litery i cyfry)";
    }

  //poprawność email
    $email = $_POST['email'];
    $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);

    if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email))
    {
      $wszysko_OK=false;
      $_SESSION['e_email']="Podanj poprawny adres email!";
    }

//poprawmosc hasła
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if ((strlen($haslo1)<8)||(strlen($haslo1)>20))
    {
      $wszysko_OK=false;
      $_SESSION['e_haslo']="Hasło musi zawierać od 8 do 20 znaków!";
    }
    if ($haslo1!=$haslo2)
    {
      $wszysko_OK=false;
      $_SESSION['e_haslo']="Podane hasła są od siebie różne";
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

//akceptacja regulaminu
    if(!isset($_POST['regulamin']))
    {
      $wszysko_OK=false;
      $_SESSION['e_regulamin']="Nie zaakceptowałeś naszego regulaminu!";
    }

//kapcza
    $sekret = "6LfeqywUAAAAALhiuetb63pZaffP82_AujAgw9is";

    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']); //sprawdzamy zawartość pliku do zmiennej łącząć sięz serverem google

    $odpowiedz = json_decode($sprawdz);
    if($odpowiedz->success==false)
    {
      $wszysko_OK=false;
      $_SESSION['e_bot']="Potwierdź że nie jesteś botem!";
    }

//zapamiętywanie wprowadzonych danch w formularzu rejestracji
    $_SESSION['form_nick'] = $nick;
    $_SESSION['form_email'] = $email;
    $_SESSION['form_haslo1'] = $haslo1;
    $_SESSION['form_haslo2'] = $haslo2;
    if (isset($_POST['regulamin'])) $_SESSION['form_regulamin']=true;

//połączenie z bazą aby sprawdzić czy ktoś nie ma np takiego samego adresu email
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT); //zamiast wyświetlania warrningów chcemy wyjątki Exception (wyjątki nie ostrzeżenia)

    try
    {
      $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
      if ($polaczenie->connect_errno!=0)
    	{
    		throw new Exception(mysqli_connect_errno()); //rzuć nowym wyjątekiem a by catch go złapał i zwrócił wyjątek (opis)
    	}
      else
      {
        //czy mail już istnieje w bazie?
        $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

        if(!$rezultat) throw new Exception($polaczenie->error);

        $ile_maili=$rezultat->num_rows;
        if($ile_maili>0)
        {
          $wszysko_OK=false;
          $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu email!";
        }

        //czy taki login już istnieje w bazie?
        $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

        if(!$rezultat) throw new Exception($polaczenie->error);

        $ile_uzytkownikow=$rezultat->num_rows;
        if($ile_uzytkownikow>0)
        {
          $wszysko_OK=false;
          $_SESSION['e_nick']="Istnieje już użytkownik o takim nicku!";
        }


        if($wszysko_OK==true)
        {
          //test ok, dodajemy gracza do bazy

          if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', now() + INTERVAL 7 DAY)"))
          {
            $_SESSION['udanarejestracja']=true;
            header('Location: witamy.php');
          }
          else
          {
            throw new Exception($polaczenie->error);
          }
        }

        $polaczenie->close();
      }

    }
    catch (Exception $e)
    {
      echo '<span style="color:red;">Błąd Serwera! Prosimy spróbować później!</span>';
      //echo '<br/>Info developerskie: '.$e;
    }

}

?>
<!DOCTYPE HTML>
<html lang="pl_PL">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <title>BUS.PL Rejestracja</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


  <link rel="stylesheet" href="css/register.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <script src='https://www.google.com/recaptcha/api.js'></script>

  <style>
  .error
  {
    color: red;
    margin-top: 10px;
    margin-bottom: 10px;
  }
  </style>

</head>

<body>
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
            <li class=""><a href="index.php">Strona główna</a></li>
            <li>
              <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Logowanie</b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                      <li>
                         <div class="row">
                            <div class="col-md-12">
                              Zaloguj
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
<div style="width:100%; height:80px;"></div>

<div class="container">
  <form method="post">
    <div class="container row justify-content-center align-items-center vertical-items-center">
      <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
      			<div class="panel-heading">
      			  <h3 class="panel-title text-center">Zarejestrowany może więcej!</h3>
            </div>
            <div class="panel-body">
              Login: <br/> <input class="form-control" type="text" placeholder="Janusz" value="<?php
                if(isset($_SESSION['form_nick']))
                  {
                    echo $_SESSION['form_nick'];
                    unset($_SESSION['form_nick']);
                  }
                ?>" name="nick" />
                    <?php
                      if (isset($_SESSION['e_nick']))
                      {
                        echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                        unset($_SESSION['e_nick']);
                      }
                    ?>


                Email: <br/> <input class="form-control" type="text" placeholder="janusz@kowalski.pl" value="<?php
                if(isset($_SESSION['form_email']))
                  {
                    echo $_SESSION['form_email'];
                    unset($_SESSION['form_email']);
                  }
                ?>" name="email" />
                    <?php
                      if (isset($_SESSION['e_email']))
                      {
                        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                        unset($_SESSION['e_email']);
                      }
                    ?>

                Hasło: <br/> <input class="form-control" type="password" value="<?php
                if(isset($_SESSION['form_haslo1']))
                  {
                    echo $_SESSION['form_haslo1'];
                    unset($_SESSION['form_haslo1']);
                  }
                ?>" name="haslo1" />
                    <?php
                      if (isset($_SESSION['e_haslo']))
                      {
                        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                        unset($_SESSION['e_haslo']);
                      }
                    ?>
                Powtórz hasło: <br/> <input class="form-control" type="password"value="<?php
                if(isset($_SESSION['form_haslo2']))
                  {
                    echo $_SESSION['form_haslo2'];
                    unset($_SESSION['form_haslo2']);
                  }
                ?>" name="haslo2" />

                <br/>
                <label>
                <input type="checkbox" name="regulamin" <?php
                if(isset($_SESSION['form_regulamin']))
                  {
                    echo "checked";
                    unset($_SESSION['form_regulamin']);
                  }
                ?>/>
                </label>

                  <a data-toggle="modal" data-target="#myModal"> Akceptuję regulamin serwisu</a>

                                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                          <h5 class="modal-title" id="myModalLabel">REGULAMIN SERWISU BUS.PL</h5>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Postanowienia ogólne</h5>
                                            Postanowienia ogólne
                                            Niniejszy regulamin określa zasady, na jakich użytkownicy Internetu mogą korzystać z Serwisu bus.pl.
                                            Z pełnej funkcjonalności Serwisu Bus.pl mogą korzystać tylko zalogowani Użytkownicy.
                                            Serwis Bus.pl udostępniając swoje zasoby systemu teleinformatycznego umożliwia przechowywanie danych przez Użytkowników. Spółka nie jest inicjatorem przekazu danych ani nie wybiera odbiorcy przekazu danych, jak również nie wybiera ani nie modyfikuje informacji zawartych w przekazie.
                                            Dostęp do treści w Serwisie bus.pl oraz korzystanie z jego funkcjonalności opisanych w Regulaminie nie podlega żadnym opłatom. Warunkiem uzyskania dostępu do funkcjonalności Serwisu Bus.pl jest skorzystanie z urządzenia komunikującego się z Internetem i wyposażonego w powszechnie używaną przeglądarkę internetową, a w przypadku Użytkowników – również posiadanie konta poczty elektronicznej działającego na dowolnym serwerze (inny niż tymczasowy lub anonimowy).
                                            Spółka może świadczyć inne usługi związane z Serwisem Bus.pl, których rodzaje i warunki świadczenia (w tym ewentualna odpłatność) określane są w odrębnych regulaminach przedkładanych do akceptacji osobom chcącym skorzystać z tych usług.
                                            <h5>Rejestracja w Serwisie BUS.PL</h5>
                                            Zarejestrować się w Serwisie Bus.pl mogą tylko osoby fizyczne, które ukończyły trzynaście lat. Użytkownikami nie mogą być przedsiębiorcy, chyba że Spółka wyrazi na to zgodę.
                                            W celu dokonania rejestracji należy podać w odpowiednim formularzu dostępnym w Serwisie bus.pl co najmniej: nazwę, pod jaką Użytkownik zamierza występować w Serwisie bus.pl (login), adres e-mail (inny niż tymczasowy lub anonimowy) oraz hasło, zaakceptować Regulamin. Po wypełnieniu danych w formularzu rejestracyjnym na podany w nim adres e-mail zostanie wysłana wiadomość wskazująca sposób potwierdzenia rejestracji oraz inne wymagane prawem informacje.
                                            Użytkownik uzyskuje dostęp do pełnej funkcjonalności Serwisu bus.pl po podaniu loginu i hasła (logowanie).
                                            Użytkownicy mają dodatkową możliwość logowania się w Serwisie bus.pl z wykorzystaniem ich danych dostępowych pochodzących z serwisów zewnętrznych, które każdorazowo są wskazane na stronach Serwisu bus.pl. Serwisy zewnętrzne mogą przewidywać dodatkowe warunki skorzystania z takiej opcji. Pierwsze takie logowanie (o ile nie następuje po rejestracji w Serwisie bus.pl w sposób opisany w powyższym punkcie 3.2.) połączone jest z akceptacją Regulaminu. Wykonanie tych czynności jest traktowane jako rejestracja w Serwisie bus.pl.
                                            Dokonanie aktywacji oznacza zakończenie rejestracji, z tą chwilą dochodzi do zawarcia pomiędzy Użytkownikiem a Spółką umowy o świadczenie usług drogą elektroniczną na warunkach określonych w Regulaminie i polegających na zapewnieniu Użytkownikowi możliwości korzystania z Serwisu bus.pl w sposób opisany w Regulaminie w odniesieniu do danego Konta.
                                            W wyniku rejestracji dla Użytkownika tworzone jest Konto. Informacje na Koncie Użytkownik może uzupełnić o własne dane, przy czym dane te może w każdej chwili usunąć.
                                            Użytkownik ma wgląd wyłącznie do informacji jawnych dotyczących kont pozostałych Użytkowników.
                                            W terminie 14 dni od zawarcia umowy, o której mowa w punkcie 3.5 powyżej, Użytkownik może od niej odstąpić bez podania przyczyn. Zasady odstąpienia od umowy, w tym wzór formularza o odstąpieniu od umowy, z którego Użytkownik może skorzystać, określone są w pouczeniu, stanowiącym załącznik nr 1 do Regulaminu. Prawo odstąpienia od umowy nie przysługuje Użytkownikowi, jeżeli wykonał on jakąkolwiek czynność w ramach Serwisu bus.pl, w szczególności: zamieścił, ocenił (oddał głos) lub skomentował Znalezisko.
                                            <h5>Podstawowa funkcjonalność Serwisu Bus.pl</h5>
                                            Użytkownicy mogą zamieszczać w Serwisie bus.pl wybrane przez siebie Znaleziska.
                                            Każde Znalezisko umieszczane jest w busalisku i przedstawiane do oceny innym Użytkownikom.
                                            Użytkownicy mogą oceniać dane Znalezisko oddając na nie głos pozytywny ("bus") albo negatywny ("zakop"). Użytkownik może oddać na dane Znalezisko tylko jeden głos. Zarówno głos pozytywny, jak i negatywny może być cofnięty. Lista osób głosujących umieszczana jest na liście przy danym Znalezisku.
                                            Jeżeli Znalezisko zdobędzie odpowiednią liczbę głosów, zostanie przeniesione do katalogu prowadzonego na stronie głównej Serwisu bus.pl (zostanie "busane"). Jeżeli nie nastąpi to w terminie 24 godzin od umieszczenia Znaleziska w busalisku - Znalezisko nie może trafić na główną stronę Serwisu bus.pl. W szczególnych przypadkach Znalezisko może zostać pozbawione możliwości przeniesienia na stronę główną Serwisu bus.pl przed upływem 24 godzin od umieszczenia Znaleziska w busalisku.
                                            Użytkownicy mogą w każdej chwili skomentować dowolne Znalezisko, jak również odpowiadać na zamieszczone już komentarze.
                                            Znaleziska mogą być oceniane również po zamieszczeniu ich w katalogu na stronie głównej Serwisu bus.pl.
                                            Użytkownikom może zostać udostępniona funkcja pozwalająca na komentowanie lub ocenianie innych treści zamieszczanych w Serwisie bus.pl oraz funkcja pozwalająca na wymianę informacji, opinii i spostrzeżeń dotyczących treści dostępnych w sieci Internet.
                                            <h5>Zasady korzystania z Serwisu Bus.pl</h5>
                                            Wszelkie działania podejmowane przez Użytkowników w ramach Serwisu bus.pl, a także cel tych działań, powinny być zgodne z obowiązującymi przepisami prawa, zasadami współżycia społecznego i dobrymi obyczajami, w szczególności zakazane jest dostarczanie przez Użytkownika treści o charakterze bezprawnym.
                                            Użytkownik ponosi pełną odpowiedzialność za swoje działania, w tym za treści, jakie zamieszcza w Serwisie bus.pl.
                                            Treści tworzone przez Użytkownika powinny być zredagowane w czytelny sposób, nie mogą mieć charakteru reklamowego i nie mogą naruszać obowiązujących przepisów prawa, zasad współżycia społecznego, dobrych obyczajów (w tym dobrych praktyk) oraz praw osób trzecich, w szczególności nie mogą zawierać:
                                            wypowiedzi wulgarnych lub obraźliwych, w tym dotyczących innych Użytkowników bus.pl
                                            wypowiedzi naruszających zasady dobrego wychowania i netykiety,
                                            treści propagujących przemoc, treści drastycznych, bądź nawołujących do szerzenia nienawiści, rasizmu, ksenofobii lub konfliktów między narodami,
                                            treści naruszających dobra osobiste (w szczególności wizerunku) lub prawa autorskie osób trzecich,
                                            treści o charakterze pornograficznym.
                                            Niedozwolone jest zamieszczanie w Serwisie bus.pl linków do stron internetowych, na których zawarte są treści, o których mowa w punkcie 5.3. powyżej.
                                            Użytkownik poprzez umieszczenie danych, wizerunku, komentarzy lub innych treści w Serwisie bus.pl wyraża zgodę na wykorzystywanie ich przez Spółkę na potrzeby prowadzenia Serwisu bus.pl oraz przez innych Użytkowników w zakresie ich osobistego użytku przez czas nieokreślony.
                                            Użytkownicy są zobowiązani do powstrzymania się od jakichkolwiek działań mających na celu manipulowanie treściami lub wynikami Znalezisk w Serwisie bus.pl, do nie spamowania Serwisu bus.pl oraz do powstrzymywania się od jakichkolwiek działań mogących utrudnić lub zakłócić funkcjonowanie Serwisu bus.pl i korzystanie z usług Serwisu bus.pl w sposób uciążliwy dla innych Użytkowników.
                                            Użytkownik może zamieszczać jedynie zdjęcia do których publikacji posiada stosowne prawa. Użytkownik wyraża zgodę na rozpowszechnianie i publiczne udostępnianie jego własnego wizerunku, oraz innych zamieszczonych przez siebie zdjęć w Serwisie bus.pl, na zasadzie wskazanej w zdaniu uprzednim. Jeżeli zdjęcie przedstawia inną osobę, Użytkownik powinien otrzymać zgodę takiej osoby na rozpowszechnianie i publiczne udostępnianie jej wizerunku.
                                        </div>
                                        <div class="modal-footer">
                                          <p class="text-center">
                                          <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Zamknij</button>
                                          </p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                    <?php
                      if (isset($_SESSION['e_regulamin']))
                      {
                        echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                        unset($_SESSION['e_regulamin']);
                      }
                    ?>

                <div class="g-recaptcha" data-sitekey="6LfeqywUAAAAAKU3boisLyDoCfUFO1-tOm33pzXh" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                    <?php
                      if (isset($_SESSION['e_bot']))
                      {
                        echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                        unset($_SESSION['e_bot']);
                      }
                    ?>

                 <input class="btn btn-m btn-success btn-block" type="submit" value="Zarejestruj się" /><br/>
              </div>

          </div>
        </div>
      </div>
    </div>

  </form>
  </div>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
