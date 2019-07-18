<?php
    $page = "sollicitanten";
    include('header.html');

    if (isset($_GET["id"])) {
        $bID = $_SESSION["BDRF_ID"];
        $sID = $_GET["id"];
        $sql = "SELECT COUNT(*) AS aantal FROM sollicitaties s 
            JOIN vacatures v ON s.vacatureID = v.ID
            JOIN bedrijven b ON v.bedrijfID = b.ID 
            WHERE v.bedrijfID = ? AND s.ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($bID, $sID));
        $r = $stmt->fetch();
        if ($r["aantal"] != 0) {
            $sql = "SELECT g.naam, g.telefoon, s.motivatie, g.email, v.functie, v.werkstad FROM vacatures v 
            JOIN sollicitaties s ON s.vacatureID = v.ID
            JOIN gebruikers g ON s.sollicitantID = g.ID
            WHERE s.ID = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($sID));
            $r = $stmt->fetch();
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
                                        class="fas fa-hashtag"></i><span class="ml-2">Sollicitatienummer:
                                        <b><?php echo $_GET['id']?></b></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container text-center">
                    <h2>Sollicitatie voor <?php echo $r["functie"]." in ".$r["werkstad"] ?></h2>
                    <hr>
                    <h3>Contactgegevens</h3>
                    <hr>
                    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-user-tie"></i>
                        <b><?php echo $r["naam"] ?></b></span>
                    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-phone-alt"></i> <b><a style="color: black"
                                href="tel: <?php echo $r["telefoon"]?>"><?php echo $r["telefoon"]?></a></b></span>
                    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-envelope"></i> <b><a style="color: black"
                                href="mailto: <?php echo $r["email"]?>"><?php echo $r["email"]?></a></b></span>
                    <hr>
                    <h4>Motivatie</h4>
                    <p><?php echo $r["motivatie"] ?></p>
                </div>
            <?php
        } else {
            echo "<script>alert('Je kan geen sollicitaties van andere bedrijven bekijken.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Je hebt geen sollicitatie geselecteerd'); window.history.back();</script>";
    }
?>