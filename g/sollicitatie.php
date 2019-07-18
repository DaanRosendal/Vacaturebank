<?php
    $page="mS"; include('header.html');

    $vID = $_GET["vID"];
    $sID = $_GET["sID"];
    $uID = $_SESSION["USER_ID"];

    if ($uID != $sID){
        echo "<script>alert('Dit is niet jouw sollicitatie'); window.history.back();</script>";
    } else{
        $sql = "SELECT COUNT(*) AS aantal FROM sollicitaties WHERE sollicitantID = ? AND vacatureID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($sID, $vID));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r["aantal"] != 1){
            echo "<script>alert('Dit is niet jouw sollicitatie'); window.history.back();</script>";
        } else {
            $sql1 = "SELECT * FROM sollicitaties WHERE sollicitantID = ? AND vacatureID = ?";
            $stmt1 = $verbinding->prepare($sql1);
            $stmt1->execute(array($sID, $vID));
            $r1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT *, b.ID as bID
                FROM bedrijven b JOIN vacatures v ON v.bedrijfID = b.ID 
                WHERE v.ID = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($_GET["vID"]));
            $r = $stmt->fetch(PDO::FETCH_ASSOC);

            ?>
<script>
    function verwijderSol() {
        var c = confirm(
            "Weet je zeker dat je deze sollicitatie wil verwijderen? Je kan dit NIET ongedaan maken"
        );

        if (c) {
            location.href = 'verwijder-sol.php?vID=<?php echo $vID."&sID=".$uID?>';
        }
    }
</script>
<div class="container mt-3 unselectable">
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
                        <b><?php echo $r1["ID"]?></b></span></a>
            </div>
        </div>
    </div>
</div>
<div class="container text-center mt-2">
    <h4><?php echo "Sollicitatie bij <a href='bedrijf.php?id=".$r['bID']."'>".$r["naam"]."</a> als ".$r["functie"] ?></h4>
    <hr>
    <h4>Jouw motivatie</h4>
    <?php echo $r1["motivatie"]; ?>
    <hr>
    <h4>Contactgegevens</h4>
    <span class='d-md-inline-block d-block mr-md-3'><a style="text-decoration: none; color: black;"
            href="vacature.php?id=<?php echo $vID ?>"><i class="fas fa-hashtag"></i><span class="ml-2">Vacaturenummer:
                <b><?php echo $vID ?></b></span></a></span>
    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-user-tie"></i>
        <b><?php echo $r["persoon"] ?></b></span>
    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-phone-alt"></i> <b><a style="color: black"
                href="tel: <?php echo $r["telefoon"]?>"><?php echo $r["telefoon"]?></a></b></span>
    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-envelope"></i> <b><a style="color: black"
                href="mailto: <?php echo $r["email"]?>"><?php echo $r["email"]?></a></b></span>
    <hr>
    <h4>Werklocatie</h4>
    <div style="width: 100%">
        <iframe width="100%" height="400" src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=<?php 
                        // adres van bedrijf uit de database halen en aan google maps geven
                        echo $r['werkstraat']." ".$r["werkpostcode"] ?>
                        &ie=UTF8&t=&z=14&iwloc=B&output=embed" scrolling="no" frameborder="0" marginheight="0"
            marginwidth="0">
        </iframe>
    </div>
    <button type="button" class="btn btn-danger mt-3 mb-3" onclick="verwijderSol()">Sollicitatie verwijderen</button>
</div>
<?php
        }
    }
?>