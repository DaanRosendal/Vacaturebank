<?php
$page = "bedrijven";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Bedrijven</h1>
    </div>
    <?php
    print_r($_SESSION);
    $sql2 = "SELECT COUNT(*) AS aantal FROM bedrijven";
    $stmt2 = $verbinding->prepare($sql2);
    $stmt2->execute();
    $r = $stmt2->fetch();
    if ($r["aantal"] >= 1) {
        ?>
        <div class="text-center">
            <p class="lead">Bedrijven aanmaken, bekijken, bewerken en verwijderen</p>
            <a class="btn btn-primary text-center mb-3" href="bdrfAanmaken.php" role="button"><i class="fas fa-plus"></i></a>
        </div>
        <table class="table table-striped table-hover table-sm w-100">
            <thead>
                <tr>
                    <th scope="col">BedrijfID</th>
                    <th scope="col">Naam</th>
                    <th scope="col">Locatie</th>
                    <th scope="col"><i class="fas fa-eye"></i></th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT ID, naam, hq
                        FROM bedrijven b
                        ORDER BY naam ASC";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute();
                $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultaten as $r) {
                    echo "
                        <tr>
                            <th scope='row'>" . $r["ID"] . "</th>
                            <td>" . $r["naam"] . "</td>
                            <td>" . $r["hq"] . "</td>
                            <td><a href= 'bedrijf.php?id=" . $r["ID"] . "'><i class='far fa-eye'></i></a></td>
                            <td><a href='bdrfBewerk.php?id=" . $r["ID"] . "'><i class='far fa-edit'></i></a></td>
                            <td><a onclick='return confirm(\"Weet je zeker dat je dit bedrijf wil verwijderen?\")' class='text-danger' href='bdrfDelete.php?ID=" . $r["ID"] . "'><i class='far fa-trash-alt'></i></a></td>
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
        <p class="text-center">Er zijn (nog) geen bedrijven.</p>
    <?php
    }
    ?>

</div>