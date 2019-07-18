<?php
$page = "mV";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Mijn vacatures</h1>
    </div>
        <?php
        $bID = $_SESSION["BDRF_ID"];
        $sql2 = "SELECT COUNT(*) AS aantal FROM vacatures WHERE bedrijfID = ?";
        $stmt2 = $verbinding->prepare($sql2);
        $stmt2->execute(array($bID));
        $r = $stmt2->fetch();
        if ($r["aantal"] >= 1) {
            ?>
            <div class="text-center">
                <p class="lead">Vacatures aanmaken, bekijken, bewerken en verwijderen</p>
                <a class="btn btn-primary text-center mb-3" href="vacAanmaken.php" role="button"><i class="fas fa-plus"></i></a>
            </div>
        <table class="table table-striped table-hover table-sm w-100">
            <thead>
                <tr>
                    <th scope="col">Vacaturenr</th>
                    <th scope="col">Functie</th>
                    <th scope="col">Locatie</th>
                    <th scope="col">Datum</th>
                    <th scope="col"><i class="fas fa-eye"></i></th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT b.naam AS bedrijf, b.ID AS bID, v.ID as vID, v.functie AS functie, 
                        DATE_FORMAT(v.datum, '%e-%m-%Y') AS datum, v.werkstad AS werkstad
                        FROM vacatures v
                        JOIN bedrijven b ON v.bedrijfID = b.ID
                        WHERE v.bedrijfID = ?
                        ORDER BY v.datum DESC";
                    $stmt = $verbinding->prepare($sql);
                    $stmt->execute(array($bID));
                    $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultaten as $r) {
                        echo "
                        <tr>
                            <th scope='row'>" . $r["vID"] . "</th>
                            <td>" . $r["functie"] . "</td>
                            <td>" . $r["werkstad"] . "</td>
                            <td>" . $r["datum"] . "</td>
                            <td><a href= 'vacature.php?id=".$r["vID"]."'><i class='far fa-eye'></i></a></td>
                            <td><a href='vacBewerk.php?id=" . $r["vID"] . "'><i class='far fa-edit'></i></a></td>
                            <td><a onclick='return confirm(\"Weet je zeker dat je deze vacature wil verwijderen?\")' class='text-danger' href='vacDelete.php?vID=" . $r["vID"]."&bID=".$bID . "'><i class='far fa-trash-alt'></i></a></td>
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
        <p class="text-center">Je hebt nog geen vacatures aangemaakt, <a href="vacAanmaken.php"
                style="text-decoration: none">maak hier je eerste vacature aan.</a></p>
        <?php
    }
    ?>

</div>