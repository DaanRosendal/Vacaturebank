<?php $page = "vacatures";
include('header.html');
if (!isset($_GET["id"])) {
    echo "<script>alert('Je hebt geen vacature geselecteerd'); window.history.back();</script>";
    die();
} else {
    // pak de informatie van de vacature met de ID uit de link
    $sql = "SELECT *, DATE_FORMAT(datum, '%e-%m-%Y') AS gDatum FROM vacatures WHERE ID = ?";
    // check de wat de vacature is met het hoogste ID
    $sql2 = "SELECT MAX(ID) AS aantal FROM vacatures";
    // link vacature met het bedrijf
    $sql3 = "SELECT *, b.ID AS bID, b.naam AS bNaam FROM bedrijven b
        JOIN vacatures v ON v.bedrijfID = b.ID
        WHERE v.ID = ?";
    $stmt = $verbinding->prepare($sql);
    $stmt2 = $verbinding->prepare($sql2);
    $stmt3 = $verbinding->prepare($sql3);
    $id = $_GET["id"];
    $plus1 = $id + 1;
    $min1 = $id - 1;
    $stmt->execute(array($id));
    $stmt2->execute();
    $stmt3->execute(array($id));
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $r2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $aantal = $r2["aantal"];
    $_SESSION["AANTAL_VACATURES"] = $aantal;
    $r3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    // check of de query een resultaat oplevert
    if ($r) {
        ?>
        <script>
            function confirmSol() {
                location.href = 'solliciteer.php?id=<?php echo $r['ID'] ?>';
            }
        </script>
        <div class="container mt-3 unselectable">
            <div class="row bg-white rounded">
                <div class="col-6">
                    <div class="mt-3">
                        <a onclick="window.history.back();" style="text-decoration: none; cursor: pointer" class="text-primary"><i class="fas fa-chevron-left"></i> <b><span class="ml-2">Terug</span></b></a>
                    </div>
                </div>
                <div class="col-6 text-right">
                    <div class="mt-2 mb-2">
                        <button type="button" class="btn btn-success" onclick="confirmSol()">Solliciteren</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="container mt-3 unselectable mb-2">
            <div class="row bg-white rounded">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <h1 class="display-4 mt-4 text-center"><?php echo $r['functie']; ?></h1>
                    <div class="text-secondary border-bottom mt-4">
                        <?php
                        echo "<span class='d-md-inline-block d-block mr-md-3'><i class='fas fa-map-marker-alt'></i> <b>" . $r["werkstad"] . "</b></span> 
                                <span class='d-md-inline-block d-block mr-md-3'><i class='fas fa-clock'></i> <b>" . $r["uren"] . " uur, " . $r["dagen"] . " dagen per week</b></span> 
                                <span class='d-md-inline-block d-block mr-md-3'><i class='fas fa-graduation-cap'></i> <b>" . $r["opleiding"] . "</b></span>
                                <span class='d-md-inline-block d-block'><i class='fas fa-euro-sign'></i> <b>" . number_format($r["salaris"], 0, ".",".") . " per maand</b></span>";
                        echo "<p class='mt-4 text-dark'><span>" . $r["beschrijving"] . "</span></p>"
                        ?>
                    </div>
                    <h3 class="text-center mt-2">Werklocatie</h3>
                    <div style="width: 100%">
                        <iframe width="100%" height="400" src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=<?php 
                                        // adres van bedrijf uit de database halen en aan google maps geven
                                        echo $r['werkstraat']." ".$r["werkpostcode"] ?>
                                        &ie=UTF8&t=&z=14&iwloc=B&output=embed" scrolling="no" frameborder="0" marginheight="0"
                            marginwidth="0">
                        </iframe>
                    </div>
                    <div class="mb-3 mt-2 text-center">
                        <h3 class="lead">Geïnteresseerd in deze functie?</h3>

                        <button type="button" class="btn btn-success" onclick="confirmSol()">Solliciteren</button>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-2 col-12 text-secondary text-center mb-2">
                    <div class="border-top">
                        <div class="mt-2">
                            <?php
                            echo "Geplaatst op " . $r["gDatum"] . " door <a style='text-decoration:none;' href='bedrijf.php?id=" . $r3['bID'] . "'><b>" . $r3["bNaam"] . "</b></a>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
} else {
    echo "<script>alert('Deze vacature bestaat niet'); window.history.back();</script>";
}
}
?>