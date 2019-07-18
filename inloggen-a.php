<?php $page = "inloggen";
session_start();
include('header.html');
?>

<body>
    <div class="container col-centered">
        <div class="page-header text-center unselectable">
            <h1 class="unselectable mt-2 display-4">Inloggen als administrator</h1>
            <hr>
        </div>
    </div>
    <div class="container text-center">
        <form class="mt" name="inloggen" method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <input required type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="naam" placeholder="Naam" />
            </div>
            <div class="form-group">
                <input required type="password" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="wachtwoord" placeholder="Wachtwoord" />
            </div>
            <input type="submit" class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" name="submit" value="Inloggen" />
        </form>
    </div>
</body>

<?php
if (isset($_POST["submit"])) {
    $melding = "";
    $naam = htmlspecialchars($_POST["naam"]);
    $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);
    try {
        $sql = "SELECT * FROM admins WHERE naam = ? AND wachtwoord = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($naam, $wachtwoord));
        $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
        $wachtwoordInDatabase = $resultaat["wachtwoord"];
        if ($resultaat) {
            $_SESSION["ID"] = session_id();
            $_SESSION["ADMIN_ID"] = $resultaat["ID"];
            $_SESSION["ADMIN_NAAM"] = $resultaat["naam"];
            $_SESSION["ADMIN_STATUS"] = "ACTIEF";
            echo "<script>location.href='a/bedrijven.php'</script>";
        } else {
            $melding .= "De combinatie van e-mail en wachtwoord komt ons niet bekend voor.";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    echo "<div class='text-center text-danger mt-3 unselectable'>$melding</div>";
}
?>