<?php
$page = "mS";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Mijn sollicitaties</h1>
    </div>
        <?php
        $sql2 = "SELECT COUNT(*) AS aantal FROM sollicitaties WHERE sollicitantID = ?";
        $stmt2 = $verbinding->prepare($sql2);
        $stmt2->execute(array($_SESSION["USER_ID"]));
        $r = $stmt2->fetch();
        if ($r["aantal"] >= 1) {
            $sID = $_SESSION["USER_ID"];
            ?>
            <p class="lead text-center">Klik op een sollicitatie in de tabel hieronder om meer informatie te zien!</p>
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">Sollicitatienr</th>
                    <th scope="col">Bedrijf</th>
                    <th scope="col">Vacaturenr.</th>
                    <th scope="col">Functie</th>
                    <th scope="col">Datum</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT b.naam AS bedrijf, b.ID AS bID, v.ID as vID, s.ID AS seID, v.functie AS functie, DATE_FORMAT(s.datum, '%e-%m-%Y') AS datum FROM sollicitaties s
                        JOIN vacatures v ON s.vacatureID = v.ID
                        JOIN bedrijven b ON v.bedrijfID = b.ID
                        WHERE s.sollicitantID = ?
                        ORDER BY s.datum DESC";
                    $stmt = $verbinding->prepare($sql);
                    $stmt->execute(array($_SESSION["USER_ID"]));
                    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $lus = 1;
                    if (isset($_GET["id"])) {
                        foreach ($resultaten as $r) {
                            if ($_GET["id"] == $r["vID"]) {
                                echo "
                                <tr class='table-success' style='cursor: pointer' onclick='window.location=\"sollicitatie.php?vID=" . $r["vID"] . "&sID=" . $sID . "\";'>
                                    <th scope='row'>" . $r["seID"] . "</th>
                                    <td> <a href='bedrijf.php?id=" . $r["bID"] . "'>" . $r["bedrijf"] . "</a></td>
                                    <td> <a href='vacature.php?id=" . $r["vID"] . "'>" . $r["vID"] . "</a></td>
                                    <td>" . $r["functie"] . "</td>
                                    <td>" . $r["datum"] . "</td>
                                </tr>";
                                $lus++;
                            } else {
                                echo "
                                <tr style='cursor: pointer' onclick='window.location=\"sollicitatie.php?vID=" . $r["vID"] . "&sID=" . $sID . "\";'>
                                    <th scope='row'>" . $r["seID"] . "</th>
                                    <td> <a href='bedrijf.php?id=" . $r["bID"] . "'>" . $r["bedrijf"] . "</a></td>
                                    <td> <a href='vacature.php?id=" . $r["vID"] . "'>" . $r["vID"] . "</a></td>
                                    <td>" . $r["functie"] . "</td>
                                    <td>" . $r["datum"] . "</td>
                                </tr>";
                                $lus++;
                            }
                        }
                    } else {
                        foreach ($resultaten as $r) {
                            echo "
                            <tr style='cursor: pointer' onclick='window.location=\"sollicitatie.php?vID=" . $r["vID"] . "&sID=" . $sID . "\";'>
                                <th scope='row'>" . $r["seID"] . "</th>
                                <td><a href='bedrijf.php?id=" . $r["bID"] . "'>" . $r["bedrijf"] . "</a></td>
                                <td><a href='vacature.php?id=" . $r["vID"] . "'>" . $r["vID"] . "</a'></td>
                                <td>" . $r["functie"] . "</td>
                                <td>" . $r["datum"] . "</td>
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
        <p class="text-center">Je hebt nog nergens gesolliciteerd, <a href="vacatures.php"
                style="text-decoration: none">bekijk onze vacatures</a>
            en solliciteer op een functie die jou aanspreekt!</p>
        <?php
    }
    ?>
</div>