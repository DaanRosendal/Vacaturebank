<?php $page="wwv"; include('header.html'); ?>

<body>
    <script>
        function wachtwoordCheck(form) {
            if (form.w1.value !== form.w2.value) {
                alert('De wachtwoorden zijn ongelijk.');
                return false;
            }
            if (form.w1.value.length < 6) {
                alert('Uw wachtwoord moet minimaal 6 tekens lang zijn.');
                return false;
            }
            return true;
        }
    </script>
    <div class="container">
        <div class="page-header text-center unselectable">
            <h1 class="unselectable mt-2 display-4">Wachtwoord veranderen</h1>
            <hr>
        </div>
    </div>
    <div class="container text-center unselectable">
        <form name="wwv" method="POST" enctype="multipart/form-data" action="" onsubmit="return wachtwoordCheck(wwv)">
            <div class="form-group">
                <input required type="password"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="ow" placeholder="Oud wachtwoord" />
            </div>
            <div class="form-group">
                <input required type="password"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="w1" placeholder="Nieuw wachtwoord" />
            </div>
            <div class="form-group">
                <input required type="password"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="w2" placeholder="Bevestig nieuw wachtwoord" />
            </div>
            <input type="submit" name="submit" value="Verander wachtwoord"
                class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0 mb-3" />
    </div>
    </form>
    </div>
</body>

</html>
<?php
    if(isset($_POST["submit"])){
            $melding = "";
            $email = $_SESSION["E-MAIL"];
            $oudWw = htmlspecialchars($_POST["ow"]);
            $wachtwoord = htmlspecialchars($_POST["w1"]);
            $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            //hier checken we of het token en de email geldig zijn
            try {
                $sql = "SELECT * FROM gebruikers WHERE email = ?";
                $stmt = $verbinding->prepare($sql);
                $stmt->execute(array($email));
                $r = $stmt->fetch(PDO::FETCH_ASSOC);
                $dbWw = $r["wachtwoord"];
                if ($stmt){
                    if(password_verify($oudWw, $dbWw)){
                        $query = "UPDATE gebruikers SET wachtwoord = ? WHERE email = ?";
                        $stmt = $verbinding->prepare($query);
                        $stmt = $stmt->execute(array($wachtwoordHash, $email));
                        if($stmt){
                            echo '<div class="container mt-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-10 offset-1" >
                                    <div class="alert alert-success text-center">
                                        Uw wachtwoord is veranderd.
                                    </div>
                                </div>';
                       }
                    } else {
                        echo '<div class="container mt-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-10 offset-1" >
                                    <div class="alert alert-danger text-center">
                                        Uw oude wachtwoord komt niet overeen met het wachtwoord in onze database.
                                    </div>
                                </div>';
                    }
                }
               } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
?>