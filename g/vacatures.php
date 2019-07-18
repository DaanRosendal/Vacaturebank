<?php
    $page="vacatures"; include('header.html');
?>
<!-- Dit is het zoekformulier -->

<div class="container">
    <div class="page-header text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Vacatures</h1>
    </div>
    <div class="container text-center">
        <form name="search" id="search" style="margin: auto;" action="" method="POST">
            <div class="input-group col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-10 offset-sm-1 col-10 offset-1">
                <input type="text" class="form-control" id="patroon" name="patroon" placeholder="Zoek vacatures" />
                <div class="rounded-0">
                    <button type="submit" class="btn btn-primary rounded-right" id="zoeken" name="zoeken">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <hr>
</div>

<?php
    //hier wordt de sql opdracht gegenereerd
    if(!empty($_POST["patroon"])){
        $patroon = htmlspecialchars($_POST["patroon"]);
        $sql = "SELECT *, DATE_FORMAT(v.datum, '%d-%m-%Y') AS gDatum,
        v.ID AS vID,
        b.ID AS bID
        FROM vacatures v
        JOIN bedrijven b ON b.ID = v.bedrijfID
        WHERE v.functie LIKE '%$patroon%' || (b.naam LIKE '%$patroon%')";
    } else {
        $sql = "SELECT *, 
        DATE_FORMAT(v.datum, '%d-%m-%Y') AS gDatum,
        v.ID AS vID,
        b.ID AS bID
        FROM vacatures v JOIN bedrijven b ON b.ID = v.bedrijfID
        LIMIT 12";
    }
?>

<div class="container">
    <form name="vacatures" id="vacatures" action="index.php?page=bestellen" method="POST">
        <?php
            //dit is het bestelformulier met mobielen uit de database
            $stmt = $verbinding->prepare($sql);
            $stmt->execute();
            $vacatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lus = 0;
            $nieuweRij = true;
            $kolom2 = false;
            echo '<div class="card-columns">';
            foreach($vacatures as $vac) {
                echo '
                    <div class="card text-center">
                        <div class="card-body ">
                            <h3 class="card-title">'.$vac['functie'].'</h3>
                            <span class="card-text"><i class="fas fa-map-marker-alt"></i> '.$vac['werkstad'].'</span><br>
                            <span class="card-text"><i class="fas fa-clock"></i> '.$vac['uren'].' uur</span><br>
                            <a href="vacature.php?id='.$vac['vID'].'" style="text-decoration:none;" class="stretched-link text-danger">Bekijk vacature <i class="fas fa-chevron-circle-right"></i></a>
                        </div>
                    </div>';
            }
            echo '</div';
        ?>
    </form>
</div>
</body>

</html>