<?php
$page = "vacatures";
include('header.html');
if (!isset($_GET['id'])) {
    echo '<script>alert("Je hebt geen vacature geselecteerd om op te solliciteren"); window.history.back();</script>';
} else {
    // vacature id
    $vID = $_GET["id"];
    // sollicitant id
    $sID = $_SESSION["USER_ID"];

    // als vacature ID hoger is dan aantal vacatures, toegang weigeren
    if ($vID > $_SESSION["AANTAL_VACATURES"]) {
        echo "<script>alert('Deze vacature bestaat niet'); location.href='vacatures.php'</script>";
    } else {
        // check of de gebruiker al een keer op deze vacature heeft gesolliciteerd
        $sql2 = "SELECT COUNT(ID) as AANT FROM sollicitaties WHERE sollicitantID = ? && vacatureID = ?";
        $stmt = $verbinding->prepare($sql2);
        $stmt->execute(array($sID, $vID));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r["AANT"]) {
            echo '<script>alert("Je hebt al op deze vacature gesolliciteerd"); window.history.back();</script>';
        } else {
            // pak de informatie van de vacature met de ID uit de link
            $sql = "SELECT * FROM vacatures WHERE ID = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($_GET["id"]));
            $r = $stmt->fetch(PDO::FETCH_ASSOC);

            // pak alle info van het bedrijf dat deze vacature geplaatst heeft
            $sql1 = "SELECT b.naam AS bNaam, b.persoon AS contactpersoon
                    FROM vacatures v JOIN bedrijven b ON b.ID = v.bedrijfID 
                    WHERE v.ID = ?";
            $stmt1 = $verbinding->prepare($sql1);
            $stmt1->execute(array($_GET["id"]));
            $r1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            ?>
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
            <div class="container unselectable mb-2">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">Solliciteren bij <?php echo $r1["bNaam"] . " als " . $r['functie']; ?></h1>
                        <div class="text-secondary mt-2 text-center">
                            <?php
                            echo "
                    <span class='d-md-inline-block d-block mr-md-3'><i class='fas fa-map-marker-alt'></i> <b>" . $r["werkstad"] . "</b></span> 
                    <span class='d-md-inline-block d-block mr-md-3'><i class='fas fa-clock'></i> <b>" . $r["uren"] . " uur, " . $r["dagen"] . " dagen per week</b></span> 
                    <span class='d-md-inline-block d-block mr-md-3'><i class='fas fa-graduation-cap'></i> <b>" . $r["opleiding"] . "</b></span>
                    <span class='d-md-inline-block d-block'><i class='fas fa-euro-sign'></i> <b>" . $r["salaris"] . " per maand</b></span>";
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <script>
                    function check() {
                        var bevestig = confirm("Weet je zeker dat je de sollicitatie wil versturen?");

                        if (bevestig){
                            return true;
                        } else {
                            return false;
                        }
                    }
                </script>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
                        <form class="mt-2" name="motivatie" method="POST" enctype="multipart/form-data" onsubmit="return check()">
                            <div class="form-group">
                                <textarea required maxlength="5000" style="height: 300px;" class="form-control" name="motivatie" placeholder="Motivatie" /></textarea>
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
                            <div class="form group">
                                <input type="submit" class="btn btn-primary col-6 offset-3" name="submit" value="Solliciteer" /><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_POST["submit"])) {
                // huidige datum
                $datum = date('Y-m-d');
                $motivatie = nl2br(htmlspecialchars($_POST["motivatie"]));

                $sql = "INSERT INTO sollicitaties VALUES (null, ?, ?, ?, ?);";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array($sID, $vID, $motivatie, $datum));

                echo "<script>alert('Je sollicitatie is toegevoegd!'); location.href='sollicitaties.php?id=" . $vID . "'</script>";
            }
        }
    }
}
?>