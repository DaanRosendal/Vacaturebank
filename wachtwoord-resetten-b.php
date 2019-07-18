<!DOCTYPE html>
<html lang="nl">

<head>
    <script>
        function wachtwoordCheck(form) {
            if (form.w1.value !== form.w2.value) {
                alert('De wachtwoorden zijn ongelijk.');
                return false;
            }
            if (form.w1.value.length < 6) {
                alert('Uw wachtwoord moet minimaal 6 tekens lang zijn.');
                return false;
            }
            return true;
        }
    </script>
    <title>Wachtwoord resetten</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <?php include('DBconfig.php');?>
    <script src="js/functies.js"></script>
</head>

<body>

    <body>
        <div class="container">
            <div class="page-header text-center unselectable">
                <h1 class="unselectable mt-2 display-4">Wachtwoord veranderen</h1>
                <hr>
            </div>
        </div>
        <div class="container text-center unselectable">
            <form name="resetformulier" method="POST" enctype="multipart/form-data" action=""
                onsubmit="return wachtwoordCheck(resetformulier)">
                <div class="form-group">
                    <input required type="email"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                        name="email" placeholder="E-mail" />
                </div>
                <div class="form-group">
                    <input required type="password"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                        name="w1" placeholder="Wachtwoord" />
                </div>
                <div class="form-group">
                    <input required type="password"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                        name="w2" placeholder="Bevestig wachtwoord" />
                </div>
                <input type="submit" name="submit" value="Verander wachtwoord"
                    class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" />
        </div>
        </form>
        </div>
    </body>

</html>
<?php
    if(isset($_POST["submit"])){
        if(isset($_GET["token"]) && isset($_GET["timestamp"])){
            //token en timestamp uit de link halen
            $token = $_GET["token"];
            $timestamp1 = $_GET["timestamp"];
            $melding = "";
            $email = htmlspecialchars($_POST["email"]);
            $wachtwoord = htmlspecialchars($_POST["w1"]);
            $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            //hier checken we of het token en de email geldig zijn
            try {
               $sql = "SELECT * FROM bedrijven WHERE email = ? AND token = ?";
               $stmt = $verbinding->prepare($sql);
               $stmt->execute(array($email, $token));
               $r = $stmt->fetch(PDO::FETCH_ASSOC); 
               if ($r["email"] == $email){
                   //hier controleren we of de link verlopen is
                   $timestamp2 = new Datetime("now");
                   $timestamp2 = $timestamp2->getTimestamp();
                   $dif = $timestamp2 - $timestamp1;
                   //als de link geldig is slaan we het nieuwe wachtwoord op
                   if($dif <= 43200) {
                       $query = "UPDATE bedrijven SET wachtwoord = ? WHERE email = ?";
                       $stmt = $verbinding->prepare($query);
                       $stmt = $stmt->execute(array($wachtwoordHash, $email));
                       if($stmt){
                          echo "<script>alert('Uw wachtwoord is veranderd.'); location.href='inloggen-b.php'</script>";
                       }
                   } else {
                    echo "<script>alert('Uw link is verlopen. Vraag opnieuw een link aan.'); location.href='wachtwoord-vergeten-b.php'</script>";
                   }
               } else {
                echo '<div class="container mt-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-10 offset-1" >
                        <div class="alert alert-danger text-center">
                            U heeft een verkeerd e-mail adres ingevuld. Probeer het opnieuw.
                        </div>
                    </div>';
               }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>