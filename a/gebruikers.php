<?php
$page = "gebruikers";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Gebruikers</h1>
    </div>
    <?php
    $sql2 = "SELECT COUNT(*) AS aantal FROM gebruikers";
    $stmt2 = $verbinding->prepare($sql2);
    $stmt2->execute();
    $r = $stmt2->fetch();
    if ($r["aantal"] >= 1) {
        ?>
        <div class="text-center">
            <p class="lead">Gebruikers aanmaken, bekijken, bewerken en verwijderen</p>
            <a class="btn btn-primary text-center mb-3" href="gbrkrAanmaken.php" role="button"><i class="fas fa-plus"></i></a>
        </div>
        <table class="table table-striped table-hover table-sm w-100">
            <thead>
                <tr>
                    <th scope="col">GebruikerID</th>
                    <th scope="col">Naam</th>
                    <th scope="col">E-mail</th>
                    <th scope="col"><i class="fas fa-eye"></i></th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT ID, naam, email
                        FROM gebruikers
                        ORDER BY naam ASC";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute();
                $resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultaten as $r) {
                    echo "
                        <tr>
                            <th scope='row'>" . $r["ID"] . "</th>
                            <td>" . $r["naam"] . "</td>
                            <td>" . $r["email"] . "</td>
                            <td><a href= 'gebruiker.php?id=" . $r["ID"] . "'><i class='far fa-eye'></i></a></td>
                            <td><a href='gbrkrBewerk.php?id=" . $r["ID"] . "'><i class='far fa-edit'></i></a></td>
                            <td><a onclick='return confirm(\"Weet je zeker dat je deze gebruiker wil verwijderen?\")' class='text-danger' href='gbrkrDelete.php?ID=" . $r["ID"] . "'><i class='far fa-trash-alt'></i></a></td>
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
        <p class="text-center">Er zijn (nog) geen gebruikers.</a></p>
    <?php
    }
    ?>

</div>