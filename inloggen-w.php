<?php $page="iw"; include('header.html'); session_start(); ?>

<body>
    <div class="container col-centered">
        <div class="page-header text-center unselectable">
            <h1 class="unselectable mt-2 display-4">Inloggen als werknemer</h1>
            <p><a href="registreren-w.php">Heb je nog geen account?</a></p>
            <hr>
        </div>
    </div>
    <div class="container text-center">
        <form class="mt" name="inloggen" method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <input required type="email"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="email" placeholder="E-mail" />
            </div>
            <div class="form-group">
                <input required type="password"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="wachtwoord" placeholder="Wachtwoord" />
            </div>
            <input type="submit"
                class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0"
                name="submit" value="Inloggen" />
        </form>
    </div>
</body>

<?php
if (isset($_POST["submit"])) {
    $melding = "";
    $email = htmlspecialchars($_POST["email"]);
    $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);
    try {
        $sql = "SELECT * FROM gebruikers WHERE email = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($email));
        $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
        $wachtwoordInDatabase = $resultaat["wachtwoord"];
        $tww = password_hash($wachtwoord, PASSWORD_DEFAULT);
        if ($resultaat) {
            if (password_verify($wachtwoord, $wachtwoordInDatabase)) {
                $_SESSION["ID"] = session_id();
                $_SESSION["USER_ID"] = $resultaat["ID"];
                $_SESSION["USER_NAAM"] = $resultaat["naam"];
                $_SESSION["E-MAIL"] = $resultaat["email"];
                $_SESSION["STATUS"] = "ACTIEF";
                $_SESSION["ROL"] = $resultaat["rol"];
                if ($_SESSION["ROL"] == 0) {
                    echo "<script>location.href='g/vacatures.php'</script>";
                } else {
                    $melding .= "Je bent niet geregistreerd als werkzoekende. Vraag een administrator om hulp.";
                }
            } else {
                $melding .= "De combinatie van e-mail en wachtwoord komt ons niet bekend voor.";
            }
        } else {
            $melding .= "De combinatie van e-mail en wachtwoord komt ons niet bekend voor.";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    echo "<div class='text-center text-danger mt-3 unselectable'>$melding</div>";
}
?>

<div class="text-center mt-3 unselectable">
    <a href="wachtwoord-vergeten-w.php">Ben je je wachtwoord vergeten?</a>
</div>