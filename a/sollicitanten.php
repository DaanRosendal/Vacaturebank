<?php
$page = "sollicitanten";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Sollicitanten</h1>
        <p class="lead">Overzicht sollicitanten per vacature</p>
    </div>
    <?php
    $sql2 = "SELECT COUNT(*) AS aantal FROM sollicitaties s 
            JOIN vacatures v ON s.vacatureID = v.ID
            JOIN bedrijven b ON v.bedrijfID = b.ID";
    $stmt2 = $verbinding->prepare($sql2);
    $stmt2->execute(array());
    $r = $stmt2->fetch();
    if ($r["aantal"] >= 1) {
        ?>
        <table class="table table-striped table-hover table-sm w-100">
            <thead>
                <tr>
                    <th scope="col">VacatureID</th>
                    <th scope="col">Bedrijf</th>
                    <th scope="col">Functie</th>
                    <th scope="col">Locatie</th>
                    <th scope="col">Sollicitant</th>
                    <th scope="col">Datum</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT v.ID AS vacatureID, b.naam AS bedrijfsnaam, g.naam AS sollicitant, v.functie AS functie, v.werkstad AS locatie, s.ID as sID,
                        DATE_FORMAT(s.datum, '%e-%m-%Y') AS datum
                        FROM bedrijven b
                        JOIN vacatures v ON b.ID = v.bedrijfID
                        JOIN sollicitaties s ON v.ID = s.vacatureID
                        JOIN gebruikers g ON g.ID = s.sollicitantID
                        ORDER BY v.ID DESC";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array());
                $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $laatsteVacature = "";
                foreach ($resultaten as $r) {
                    if ($laatsteVacature != $r["vacatureID"]) {
                        echo "
                        <tr>
                            <th scope='row'>" . $r["vacatureID"] . "</th>
                            <td>" . $r["bedrijfsnaam"] . "</td>
                            <td>" . $r["functie"] . "</td>
                            <td>" . $r["locatie"] . "</td>
                            <td>" . $r["sollicitant"] . "</td>
                            <td>" . $r["datum"] . "</td>
                        </tr>
                        ";
                        $laatsteVacature = $r["vacatureID"];
                    } else {
                        echo "
                        <tr>
                            <th scope='row'></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>" . $r["sollicitant"] . "</td>
                            <td>" . $r["datum"] . "</td>
                        </tr>
                        ";
                    }
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        ?>
        <hr>
        <p class="text-center">Nog niemand heeft gesolliciteerd.</a></p>
    <?php
    }
    ?>

</div>