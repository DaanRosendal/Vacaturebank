<?php
    $page='profielb';include('header.html');
    try {
        $sql = "SELECT * FROM bedrijven WHERE email = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array( $_SESSION["E-MAIL"] ));
        $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
<script>
        function checkFormulier(form) {
            if (form.postcode.value.length > 7 || form.postcode.value.length < 6) {
                alert('Uw postcode moet 6 of 7 tekens bevatten.');
                return false;
            }
            if (typeof form.telefoon.value !=='number' && (form.telefoon.value%1)!==0){
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
        <h1 class="unselectable mt-2 display-4">Profiel bewerken</h1>
        <p class="text-secondary">BedrijfID: <?php echo $resultaat["ID"] ?> </p>
        <hr>
    </div>
</div>
<form name="profielBewerken" method="POST" class="unselectable text-center" enctype="multipart/form-data"
            onsubmit="return checkFormulier(profielBewerken)">
    <div class="form-group">
        <label for="naam">Bedrijfsnaam</label>
        <input required maxlength="45" type="text" name="naam" id="naam" value="<?php echo $resultaat['naam']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group">
        <label for="straat">Straat en huisnummer</label>
        <input required maxlength="45" type="text" name="straat" id="straat" value="<?php echo $resultaat['straat']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group">
        <label for="postcode">Postcode</label>
        <input required maxlength="7" type="text" name="postcode" value="<?php echo $resultaat['postcode']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group">
        <label for="hq">Locatie hoofdvestiging</label>
        <input required maxlength="45" type="text" name="hq" value="<?php echo $resultaat['hq']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group">
        <label for="telefoon">Naam van contactpersoon</label>
        <input required maxlength="45" type="text" name="persoon" value="<?php echo $resultaat['persoon']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group">
        <label for="telefoon">Telefoonnummer van contactpersoon</label>
        <input required maxlength="20" type="text" name="telefoon" value="<?php echo $resultaat['telefoon']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group">
        <label for="email">E-mailadres van contactpersoon</label>
        <input required maxlength="45" type="email" name="email" value="<?php echo $resultaat['email']; ?>"
            class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
    </div>
    <div class="form-group mb-3">
        <input type="submit" name="submit" value="Bewerk profiel"
            class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" />
    </div>
</form>

<?php
    if (isset($_POST["submit"])){
        $naam = htmlspecialchars($_POST["naam"]);
        $straat = htmlspecialchars($_POST["straat"]);
        $postcode = htmlspecialchars($_POST["postcode"]);
        $hq = htmlspecialchars($_POST["hq"]);
        $persoon = htmlspecialchars($_POST["persoon"]);
        $telefoon = htmlspecialchars($_POST["telefoon"]);
        $email = htmlspecialchars($_POST["email"]);
        $sEmail = $_SESSION["E-MAIL"];

        $sql = "SELECT COUNT(*) AS aantal FROM bedrijven WHERE email = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($email));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($r["aantal"] != 0 && $sEmail != $email){
            echo "<script>alert('$email staat al geregistreerd in onze database. Probeer het opnieuw met een ander e-mailadres.');</script>";
        } else {
            $sql = "UPDATE bedrijven SET naam = ?, straat = ?, postcode = ?, hq = ?, persoon = ?, telefoon = ?, email = ? WHERE email = ?";
            $stmt = $verbinding->prepare($sql);
            try {
                $stmt = $stmt->execute(array($naam, $straat, $postcode, $hq, $persoon, $telefoon, $email, $sEmail));
                if ($stmt){
                    $_SESSION["E-MAIL"] = $email;
                    echo "<script>alert('Uw profiel is geüpdatet'); location.href='profiel-bewerken.php';</script>";
                } else {
                    echo "<script>alert('We konden uw profiel niet updaten, neem contact op met een admin als dit vaker gebeurt');</script>";
                }
                $_SESSION["E-MAIL"] = $email;
                $_SESSION["BDRF_NAAM"] = $naam;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>