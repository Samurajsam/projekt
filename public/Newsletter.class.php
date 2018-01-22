<?php
class Newsletter
{
    private static $email;
    private static $datetime = null;
    private static $valid = true;
    public function __construct() {
        die('Init function is not allowed');
    }
    public static function register($email) {
      ?>

      <!DOCTYPE HTML>
      <html lang="pl_PL">
        <head>
          <meta charset="utf-8"/>
          <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
          <title>BUS.PL Newsletter</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


          <link rel="stylesheet" href="css\newsletter.css" type="text/css" />
          <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

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

        <div style="width:100%; height:100px;"></div>

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 col-xs-12">




                  <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong>

      <?php
        if (!empty($_POST)) {
            self::$email    = $_POST['signup-email'];
            self::$datetime = date('Y-m-d H:i:s');
            if (empty(self::$email)) {

                echo "Musisz wpisac adres email";
                self::$valid = false;
            } else if (!filter_var(self::$email, FILTER_VALIDATE_EMAIL)) {

                echo "Wpisz poprawny adres email";
                self::$valid = false;
            }
            if (self::$valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $existingSignup = $pdo->prepare("SELECT COUNT(*) FROM signups WHERE signup_email_address='$email'");
                $existingSignup->execute();
                $data_exists = ($existingSignup->fetchColumn() > 0) ? true : false;
                if (!$data_exists) {
                    $sql = "INSERT INTO signups (signup_email_address, signup_date) VALUES (:email, :datetime)";
                    $q = $pdo->prepare($sql);
                    $q->execute(
                        array(':email' => self::$email, ':datetime' => self::$datetime));
                    if ($q) {

                        echo "Subskrypcja została zapisana";
                    } else {

                        echo "Wystapil problem, sprobuj jeszcze raz";
                    }
                } else {

                    echo "Ten adres email posiada juz nasza subskrypcje";
                }
            }

            Database::disconnect();
        }

        ?>

        <a href="index.php"> Wróć do strony głównej.</a></strong>
      </div>

</div>

</div>
<div class="col-md-2"></div>
</div>
</div>

          <



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>

</body>
</html>

        <?php
    }
}
?>
