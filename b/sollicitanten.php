<?php
$page = "sollicitanten";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Sollicitanten</h1>
    </div>
        <?php
        $bID = $_SESSION["BDRF_ID"];
        $sql2 = "SELECT COUNT(*) AS aantal FROM sollicitaties s 
            JOIN vacatures v ON s.vacatureID = v.ID
            JOIN bedrijven b ON v.bedrijfID = b.ID 
            WHERE bedrijfID = ?";
        $stmt2 = $verbinding->prepare($sql2);
        $stmt2->execute(array($bID));
        $r = $stmt2->fetch();
        if ($r["aantal"] >= 1) {
            ?>
        <table class="table table-striped table-hover table-sm w-100">
            <thead>
                <tr>
                    <th scope="col">Sollicitant</th>
                    <th scope="col">Functie</th>
                    <th scope="col">Locatie</th>
                    <th scope="col">Datum</th>
                    <th scope="col"><i class="fas fa-eye"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT g.naam AS sollicitant, v.functie AS functie, v.werkstad AS locatie, s.ID as sID,
                        DATE_FORMAT(s.datum, '%e-%m-%Y') AS datum
                        FROM vacatures v 
                        JOIN sollicitaties s ON v.ID = s.vacatureID
                        JOIN gebruikers g ON g.ID = s.sollicitantID
                        WHERE v.bedrijfID = ?
                        ORDER BY s.datum DESC";
                    $stmt = $verbinding->prepare($sql);
                    $stmt->execute(array($bID));
                    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultaten as $r) {
                        echo "
                        <tr style='cursor: pointer' onclick='window.location=\"sollicitatie.php?id=".$r["sID"]."\";'>
                            <th scope='row'>" . $r["sollicitant"] . "</th>
                            <td>" . $r["functie"] . "</td>
                            <td>" . $r["locatie"] . "</td>
                            <td>" . $r["datum"] . "</td>
                            <td><a href= 'sollicitatie.php?id=".$r["sID"]."'><i class='far fa-eye'></i></a></td>
                        </tr>
                        ";
                    }
                    ?>
            </tbody>
        </table>
        <?php
    } else {
        ?>
        <hr>
        <p class="text-center">Nog niemand heeft op je vacature(s) gesolliciteerd.</a></p>
        <?php
    }
    ?>

</div>