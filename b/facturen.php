<?php
    $page="facturen"; include('header.html');
?>

 <div class="container">
    <div class="text-center unselectable">
        <h1 class="unselectable mt-2 display-4">Factuur</h1>
        <p>Hier kunt u uw factuur bekijken</p>
    </div>
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
            //raadpleeg alle tabellen
            $sql = "SELECT g.naam, v.ID as vID, v.functie, 
            DATE_FORMAT(s.datum, '%e-%m-%Y') AS datum,
            (0.05 * v.salaris) AS commissie
            FROM gebruikers g
            JOIN sollicitaties s ON s.sollicitantID = g.ID
            JOIN vacatures v ON s.vacatureID = v.ID
            ORDER BY v.ID ASC";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute();
            $sollicitaties = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $vID = $sollicitaties[0]['vID'];
            $subtotaal = 0;
            $totaal = 0;
            $nieuweVacature = true;
            //voor elke sollicitatie
            foreach ($sollicitaties as $s){
                //als dit een nieuwe vacature is bereken eerst subtotaal
                if ($s['vID'] != $vID){
                    //geef subtotalen weer aan einde van elke vacature
                    echo "<tr class='table-secondary'><td></td><td></td><td></td><td> Subtotaal.....</td><td align='center'>&euro;".number_format($subtotaal, 2, ",",".")."</td></tr>";
                    $totaal += $subtotaal;
                    $subtotaal = 0;
                    $nieuweVacature = true;
                    $vID = $s['vID'];
                }
                if ($nieuweVacature){
                    echo "<tr><td>". $s["vID"] ."</td><td>". $s["naam"] ."</td><td>". $s["functie"]
                    ."</td><td align:'center'>". $s["datum"] ."</td><td align='center'>&euro;".number_format($s["commissie"], 2, ",",".")."</tr>";
                    $subtotaal += $s["commissie"];
                    $nieuweVacature = false;
                } else{
                    //als het dezelfde vacature is, herhaal vacaturenr niet
                    echo "<tr><td></td><td>". $s["naam"] ."</td><td>". $s["functie"]
                    ."</td><td align:'center'>". $s["datum"] ."</td><td align='center'>&euro;".number_format($s["commissie"], 2, ",",".")."</tr>";
                    $subtotaal += $s["commissie"];
                }
            }
            //aan het einde de totalen tonen
            echo "<td></td><td></td><td></td><td> Subtotaal.....</td><td align='center'>&euro;".number_format($subtotaal, 2, ",",".")."</td></tr>";
            $totaal += $subtotaal;
            echo "<tr class='table-success'><td><td></td></td><td></td><td> Totaal.....</td><td align='center'>&euro;".number_format($totaal, 2, ",",".")."</td></tr>";
        ?>
        </tbody>
        </table>
    </div>
    
</body>

</html>