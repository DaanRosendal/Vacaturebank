<?php
    $page = "mV"; include('header.html');
?>

<script>
    function checkFormulier(form) {
        if (form.werkpostcode.value.length > 7 || form.werkpostcode.value.length < 6) {
            alert('Uw postcode moet 6 of 7 tekens bevatten.');
            return false;
        }
        if (typeof form.salaris.value !== 'number' && (form.salaris.value % 1) !== 0) {
            alert('Het maandelijkse salaris mag alleen nummers bevatten.');
            return false;
        }
        return true;
    }
</script>

<body>
    <div class="container">
        <div class="page-header text-center unselectable">
            <h1 class="unselectable mt-2 display-4">Vacature aanmaken</h1>
            <hr>
        </div>
    </div>
    <div class="container mb-3 text-center unselectable">
        <form name="vacAanmaken" class="form mt" method="POST" enctype="multipart/form-data" onsubmit="return checkFormulier(vacAanmaken)">
            <div class="form-group">
                <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="functie" placeholder="Functie" />
            </div>
            <div class="form-group">
                <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="werkstraat" placeholder="Straat en huisnummer werklocatie" />
            </div>
            <div class="form-group">
                <input required maxlength="7" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="werkpostcode" placeholder="Postcode werklocatie" />
            </div>
            <div class="form-group">
                <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="werkstad" placeholder="Werklocatie (naam stad/dorp)" />
            </div>
            <div class="form-group">
                <textarea required style="height: 300px;" maxlength="5000" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="beschrijving" placeholder="Beschrijf wat voor persoon u zoekt"></textarea>
            </div>
            <p id="maxChars" class="text-center">5000 tekens over</p>
            <script>
                var textarea = document.querySelector("textarea");

                textarea.addEventListener("input", function(){
                    var maxlength = this.getAttribute("maxlength");
                    var currentLength = this.value.length;

                    if( currentLength >= maxlength ){
                        document.getElementById("maxChars").innerHTML = "U heeft het maximale aantal tekens bereikt.";
                    }else{
                        document.getElementById("maxChars").innerHTML = maxlength - currentLength + " tekens over";
                    }
                });
            </script>
            <div class="form-group">
                <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="opleiding" placeholder="Opleidingsniveau" />
            </div>
            <div class="form-group">
                <input required maxlength="45" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="uren" placeholder="Werktijd in uren per week" />
            </div>
            <div class="form-group">
                <select required name="dagen" class="custom-select form-control col-lg-4 col-md-6 col-sm-8 col-8">
                    <option selected>Werkdagen per week</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </div>
            <div class="form-group">
                <input required maxlength="11" type="text" class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" name="salaris" placeholder="Salaris per maand" />
            </div>
            <input type="submit" name="submit" value="Vacature aanmaken" class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" />
    </div>
    </form>
    </div>


    <?php
    if (isset($_POST["submit"])) {
        $bID = $_SESSION["BDRF_ID"];
        $functie = htmlspecialchars($_POST["functie"]);
        $straat = htmlspecialchars($_POST["werkstraat"]);
        $postcode = htmlspecialchars($_POST["werkpostcode"]);
        $woonplaats = htmlspecialchars($_POST["werkstad"]);
        $beschrijving = nl2br(htmlspecialchars($_POST["beschrijving"]));
        $opleiding = htmlspecialchars($_POST["opleiding"]);
        $uren = htmlspecialchars($_POST["uren"]);
        $dagen = htmlspecialchars($_POST["dagen"]);
        $salaris = htmlspecialchars($_POST["salaris"]);
        $datum = date('Y-m-d');
        
        $sql = "INSERT INTO vacatures (bedrijfID, functie, werkstad, werkstraat, werkpostcode, beschrijving, opleiding, uren, dagen, salaris, datum) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $verbinding->prepare($sql);
        try {
            $stmt->execute(array($bID, $functie, $woonplaats, $straat, $postcode, $beschrijving, $opleiding, $uren, $dagen, $salaris, $datum));
            echo "<script>alert('Vacature aangemaakt!'); location.href='vacMijn.php'</script>";
        } catch (PDOException $e) {
            //echo "<script> alert('Er ging iets fout bij het aanmaken van uw vacature, probeer het opnieuw of neem contact op met een admin.');</script>";
            $e->getMessage();
        }
    }
    ?>
</body>

</html>
