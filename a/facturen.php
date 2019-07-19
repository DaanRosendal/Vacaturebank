<?php
$page = "facturen";
include('header.html');
?>

<div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Facturen</h1>
        <p class="lead">Bekijk de factuur van elk bedrijf</p>
        <?php
        // alle bedrijven ophalen zodat de admin uit 1 bedrijf kan kiezen
        $sql = "SELECT ID, naam FROM bedrijven";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute();
        $bedrijven = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="form-group">
            <form name="kiesBedrijf" method="POST">
                <select name="bedrijf" class="form-control m-auto col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0">
                    <option><b>Kies een bedrijf</b></option>
                    <?php
                    foreach ($bedrijven as $bedrijf) {
                        echo "<option value='" . $bedrijf["ID"] . "'>" . $bedrijf["naam"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" class="btn btn-primary mt-3 col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0" name="submit" value="Bekijk factuur" />
            </form>
        </div>
    </div>
    <?php if (isset($_POST["bedrijf"])) {
        //raadpleeg alle tabellen
        $sql = "SELECT g.naam, v.ID as vID, v.functie, 
        DATE_FORMAT(s.datum, '%e-%m-%Y') AS datum,
        (0.05 * v.salaris) AS commissie
        FROM gebruikers g
        JOIN sollicitaties s ON s.sollicitantID = g.ID
        JOIN vacatures v ON s.vacatureID = v.ID
        JOIN bedrijven b ON v.bedrijfID = b.ID
        WHERE b.ID = $_POST[bedrijf]
        ORDER BY v.ID ASC";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute();
        $sollicitaties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // checken of het bedrijf vacature(s) heeft
        if (count($sollicitaties) < 1){
            echo "<p class='text-center'>Dit bedrijf heeft nog geen sollicitanten, er kan dus geen factuur worden gegenereerd</p>";
        } else {

        // bedrijfsnaam ophalen om te laten zien voor betere UX
        $sql = "SELECT naam FROM bedrijven WHERE ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($_POST["bedrijf"]));
        $bedrijfsnaam = $stmt->fetch();
        echo "<hr/><h4 class='text-center display-4 mt-0 mb-3'>Factuur van: <b>".$bedrijfsnaam["naam"]."</b></h4>"
        ?>
        <table class="table mx-auto table-responsive table-sm col-lg-6 offset-lg-1 col-md-10 offset-md-1 offset-0 col-12">
            <thead>
                <tr>
                    <th scope="col">Vacaturenr</th>
                    <th scope="col">Sollicitant</th>
                    <th scope="col">Functie</th>
                    <th scope="col">Datum</th>
                    <th scope="col">Commissie</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $vID = $sollicitaties[0]['vID'];
                $subtotaal = 0;
                $totaal = 0;
                $nieuweVacature = true;
                //voor elke sollicitatie
                foreach ($sollicitaties as $s) {
                    //als dit een nieuwe vacature is bereken eerst subtotaal
                    if ($s['vID'] != $vID) {
                        //geef subtotalen weer aan einde van elke vacature
                        echo "<tr class='table-secondary'><td></td><td></td><td></td><td> Subtotaal.....</td><td align='center'>&euro;" . number_format($subtotaal, 2, ",", ".") . "</td></tr>";
                        $totaal += $subtotaal;
                        $subtotaal = 0;
                        $nieuweVacature = true;
                        $vID = $s['vID'];
                    }
                    if ($nieuweVacature) {
                        echo "<tr><td>" . $s["vID"] . "</td><td>" . $s["naam"] . "</td><td>" . $s["functie"]
                            . "</td><td align:'center'>" . $s["datum"] . "</td><td align='center'>&euro;" . number_format($s["commissie"], 2, ",", ".") . "</tr>";
                        $subtotaal += $s["commissie"];
                        $nieuweVacature = false;
                    } else {
                        //als het dezelfde vacature is, herhaal vacaturenr niet
                        echo "<tr><td></td><td>" . $s["naam"] . "</td><td>" . $s["functie"]
                            . "</td><td align:'center'>" . $s["datum"] . "</td><td align='center'>&euro;" . number_format($s["commissie"], 2, ",", ".") . "</tr>";
                        $subtotaal += $s["commissie"];
                    }
                }
                //aan het einde de totalen tonen
                echo "<td></td><td></td><td></td><td> Subtotaal.....</td><td align='center'>&euro;" . number_format($subtotaal, 2, ",", ".") . "</td></tr>";
                $totaal += $subtotaal;
                echo "<tr class='table-success'><td><td></td></td><td></td><td> Totaal.....</td><td align='center'>&euro;" . number_format($totaal, 2, ",", ".") . "</td></tr>";
                ?>
            </tbody>
        </table>
    <?php }} ?>
</div>

</body>

</html>