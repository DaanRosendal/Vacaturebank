<?php $page="vacatures"; include('header.html'); 
    // check of GET['id'] gespecifieerd is
    if (isset($_GET["id"])){
        $sql = "SELECT COUNT(*) AS aantal FROM bedrijven WHERE ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($_GET["id"]));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        // check of GET['id'] overeenkomt met een bedrijf
        if ($r["aantal"]){
            $sql = "SELECT * FROM bedrijven WHERE ID = ?";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($_GET["id"]));
            $r = $stmt->fetch(PDO::FETCH_ASSOC);

            ?>
            <p class="lead alert alert-info text-center"><b>Dit is hoe werknemers bedrijfspagina's zien</b></p>
            <div class="container mt-1 unselectable">
                <div class="row">
                    <div class="col-3 text-left">
                        <div class="mt-3 mb-2">
                            <a onclick="window.history.back();" style="text-decoration: none; cursor: pointer"
                                class="text-primary"><i class="fas fa-chevron-left"></i> <b><span class="ml-2">Terug</span></b></a>
                        </div>
                    </div>
                    <div class="col-9 text-right">
                        <div class="mt-3">
                            <a style="text-decoration: none; cursor: context-menu" class="text-secondary"><i
                                    class="fas fa-hashtag"></i><span class="ml-2">Bedrijfnummer:
                                    <b><?php echo $_GET['id']?></b></span></a>
                        </div>
                    </div>
                </div>
            </div>
<div class="container text-center">
    <h1 class="display-4"><?php echo $r["naam"] ?></h1>
    <hr>
    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-user-tie"></i>
        <b><?php echo $r["persoon"] ?></b></span>
    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-phone-alt"></i> <b><a style="color: black"
                href="tel: <?php echo $r["telefoon"]?>"><?php echo $r["telefoon"]?></a></b></span>
    <span class='d-md-inline-block d-block mr-md-3'><i class="fas fa-envelope"></i> <b><a style="color: black"
                href="mailto: <?php echo $r["email"]?>"><?php echo $r["email"]?></a></b></span>
    <hr>
    <h4>Hoofdlocatie</h4>
    <div style="width: 100%">
        <iframe width="100%" height="400" src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=<?php 
                        // adres van bedrijf uit de database halen en aan google maps geven
                        echo $r['straat']." ".$r["postcode"] ?>
                        &ie=UTF8&t=&z=14&iwloc=B&output=embed" scrolling="no" frameborder="0" marginheight="0"
            marginwidth="0">
        </iframe>
    </div>
</div>



<div class="container mt-2">
    <div class="border-top text-center">
        <h4 class="mt-1">Vacatures</h4></span>
    </div>
    <?php
                // alle vacatures laten zien
                $sql2 = "SELECT COUNT(*) AS aantal FROM vacatures WHERE bedrijfID = ?";
                $stmt2 = $verbinding->prepare($sql2);
                $stmt2->execute(array($_GET["id"]));
                $r = $stmt2->fetch();
                if ($r["aantal"] > 0){
                    ?>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Functie</th>
                <th scope="col">Vacaturenr.</th>
                <th scope="col">Datum</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $sql = "SELECT b.naam AS bedrijf, b.ID AS bID, v.ID as vID, v.functie AS functie, DATE_FORMAT(v.datum, '%e-%m-%Y') AS datum FROM vacatures v 
                        JOIN bedrijven b ON v.bedrijfID = b.ID
                        WHERE v.bedrijfID = ?
                        ORDER BY v.datum DESC";
                    $stmt = $verbinding->prepare($sql);
                    $stmt->execute(array($_GET["id"]));
                    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $lus = 1;
                    if (isset($_GET["id"])) {
                        foreach ($resultaten as $r) {
                            echo "
                            <tr style='cursor: pointer' onclick='window.location=\"vacature.php?id=".$r["vID"]."\";'>
                                <td scope='row'>$lus</td>
                                <td>".$r["functie"]."</td>
                                <td>".$r["vID"]."</td>
                                <td>".$r["datum"]."</td>
                            </tr>
                            ";
                            $lus++;
                        }
                    }
                    ?>
        </tbody>
    </table>
    <?php
                } else {
                    ?>
    <hr>
    <p class="text-center">Dit bedrijf heeft geen openstaande vacatures.</p>
    <?php
                }
            } else{
                echo "<script>alert('Dit bedrijf bestaat niet.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('U moet een bedrijf selecteren om deze pagina te bekijken.'); window.history.back();</script>";
        }
    ?>
</div>