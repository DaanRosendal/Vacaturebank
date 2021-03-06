<?php $page = "gebruikers";
include("header.html"); ?>

<script>
    function checkFormulier(form) {
        if (form.postcode.value.length > 7 || form.postcode.value.length < 6) {
            alert('Uw postcode moet 6 of 7 tekens bevatten');
            return false;
        }
        if (typeof form.telefoon.value !== 'number' && (form.telefoon.value % 1) !== 0) {
            alert('Uw telefoonnummer mag alleen nummers bevatten.');
            return false;
        }
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

<div class="container">
    <div class="page-header text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Gebruiker Aanmaken</h1>
        <hr>
    </div>
</div>
<div class="container mb-3 text-center unselectable">
    <form name="registreren" class="form mt" method="POST" enctype="multipart/form-data" onsubmit="return checkFormulier(registreren)">
        <div class="form-group">
            <input required  maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="naam" placeholder="Voor- en achternaam" />
        </div>
        <div class="form-group">
            <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="woonplaats" placeholder="Woonplaats" />
        </div>
        <div class="form-group">
            <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="straat" placeholder="Straat en huisnummer" />
        </div>
        <div class="form-group">
            <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="postcode" placeholder="Postcode" />
        </div>
        <div class="form-group">
            <input required maxlength="20" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="telefoon" placeholder="Telefoonnummer" />
        </div>
        <div class="form-group">
            <input required maxlength="45" type="email" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="email" placeholder="E-mail" />
        </div>
        <div class="form-group">
            <input required type="password" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="w1" placeholder="Wachtwoord" />
        </div>
        <div class="form-group">
            <input required type="password" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="w2" placeholder="Bevestig wachtwoord" />
        </div>
        <input type="submit" name="submit" value="Maak Aan" class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" />
</div>
</form>
</div>


<?php
if (isset($_POST["submit"])) {
    $melding = "";
    $naam = htmlspecialchars($_POST["naam"]);
    $straat = htmlspecialchars($_POST["straat"]);
    $postcode = htmlspecialchars($_POST["postcode"]);
    $woonplaats = htmlspecialchars($_POST["woonplaats"]);
    $telefoon = htmlspecialchars($_POST["telefoon"]);
    $email = htmlspecialchars($_POST["email"]);
    $wachtwoord = htmlspecialchars($_POST["w1"]);
    $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);

    //controleer of email al bestaat (geen dubbele adressen)
    $sql = "SELECT * FROM gebruikers WHERE email = ?";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($email));
    $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($resultaat) {
        echo "<script>alert('Het e-mailadres $email staat al geregistreerd in onze database.');</script>";
    } else {
        $sql = "INSERT INTO gebruikers (naam, straat, postcode, woonplaats, telefoon, email, wachtwoord, rol) VALUES (?,?,?,?,?,?,?,0)";
        $stmt = $verbinding->prepare($sql);
        try {
            $stmt->execute(array($naam, $straat, $postcode, $woonplaats, $telefoon, $email, $wachtwoordHash));
            echo "<script>alert('Gebruiker aangemaakt.'); location.href='gebruikers.php'</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Er ging iets fout bij het aanmaken de gebruiker, probeer het opnieuw of neem contact op met de website owner.');</script>";
            $e->getMessage();
        }
    }
}
?>
</body>

</html>