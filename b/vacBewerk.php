<?php
    $page='mV';include('header.html');
    if (isset($_GET["id"])) {
        $vID = $_GET["id"];
        $bID = $_SESSION["BDRF_ID"];
        $sql = "SELECT COUNT(*) AS aantal FROM vacatures WHERE ID = ? && bedrijfID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($vID, $bID));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r["aantal"] != 1) {
            echo "<script>alert('Dit is niet uw vacature'); window.history.back();</script>";
        } else {
            $sql = "SELECT * FROM vacatures WHERE ID = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($vID));
            $resultaat = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <div class="container mt-1 unselectable">
                <div class="row">
                    <div class="col-3 text-left">
                        <div class="mt-3 mb-2">
                            <a onclick="window.history.back();" style="text-decoration: none; cursor: pointer"
                                class="text-primary"><i class="fas fa-chevron-left"></i> <b><span class="ml-2">Terug</span></b></a>
                        </div>
                    </div>
                    <div class="col-9 text-right">
                        <div class="mt-3 mb-2">
                            <a style="text-decoration: none; cursor: context-menu" class="text-secondary"><i
                                    class="fas fa-hashtag"></i><span class="ml-2">Vacaturenummer:
                                    <b><?php echo $vID?></b></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="page-header text-center unselectable">
                    <h1 class="unselectable display-4">Vacature bewerken</h1>
                    <hr>
                </div>
            </div>
            <form name="vacBewerken" method="POST" class="unselectable text-center" enctype="multipart/form-data"
                        onsubmit="return checkFormulier(vacBewerken)">
                <div class="form-group">
                    <label for="naam">Functie</label>
                    <input required maxlength="45" type="text" name="functie" value="<?php echo $resultaat['functie']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group">
                    <label for="straat">Straat en huisnummer werklocatie</label>
                    <input required maxlength="45" type="text" name="straat" value="<?php echo $resultaat['werkstraat']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group">
                    <label for="postcode">Postcode werklocatie</label>
                    <input required maxlength="7" type="text" name="postcode" value="<?php echo $resultaat['werkpostcode']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group">
                    <label for="woonplaats">Werklocatie (naam stad/dorp)</label>
                    <input required maxlength="45" type="text" name="woonplaats" value="<?php echo $resultaat['werkstad']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group">
                    <label for="beschrijving">Beschrijving</label>
                    <textarea required style="height: 300px;" maxlength="5000" type="text" name="beschrijving"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center"><?php echo $resultaat['beschrijving']; ?></textarea>
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
                    <label for="opleiding">Opleidingsniveau</label>
                    <input required maxlength="45" type="text" name="opleiding" value="<?php echo $resultaat['opleiding']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group">
                    <label for="uren">Werktijd in uren per week</label>
                    <input required maxlength="45" type="text" name="uren" value="<?php echo $resultaat['uren']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group">
                    <label for="dagen">Werkdagen per week</label><br>
                    <select required style="text-align-last: center" name="dagen" class="custom-select form-control col-lg-4 col-md-6 col-sm-8 col-8">
                        <option value="<?php echo $resultaat['dagen']; ?>"><?php echo $resultaat['dagen']; ?></option>
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
                    <label for="salaris">Salaris</label>
                    <input required maxlength="11" type="text" name="salaris" value="<?php echo $resultaat['salaris']; ?>"
                        class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 text-center" />
                </div>
                <div class="form-group mb-3">
                    <input type="submit" name="submit" value="Bewerk vacature"
                        class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" />
                </div>
            </form>

            <?php
                if (isset($_POST["submit"])){
                    $functie = htmlspecialchars($_POST["functie"]);
                    $straat = htmlspecialchars($_POST["straat"]);
                    $postcode = htmlspecialchars($_POST["postcode"]);
                    $woonplaats = htmlspecialchars($_POST["woonplaats"]);
                    $beschrijving = nl2br(htmlspecialchars($_POST["beschrijving"]));
                    $opleiding = htmlspecialchars($_POST["opleiding"]);
                    $uren = htmlspecialchars($_POST["uren"]);
                    $dagen = htmlspecialchars($_POST["dagen"]);
                    $salaris = htmlspecialchars($_POST["salaris"]);
                    
                    $sql = "UPDATE vacatures SET functie = ?, werkstraat = ?, werkpostcode = ?, werkstad = ?, beschrijving = ?, opleiding = ?, uren = ?, dagen = ?, salaris = ? WHERE ID = ?";
                    $stmt = $verbinding->prepare($sql);
                    try {
                        $stmt = $stmt->execute(array($functie, $straat, $postcode, $woonplaats, $beschrijving, $opleiding, $uren, $dagen, $salaris, $vID));
                        if ($stmt){
                            echo "<script>alert('Uw vacature is geüpdatet'); location.href='vacBewerk.php?id=".$vID."';</script>";
                        } else {
                            echo "<script>alert('We konden uw profiel niet updaten, neem contact op met een admin als dit vaker gebeurt');</script>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
            }
        } else {
            echo "<script>alert('Je hebt geen vacature geselecteerd om te bewerken'); window.history.back();</script>";
        }
    ?>
