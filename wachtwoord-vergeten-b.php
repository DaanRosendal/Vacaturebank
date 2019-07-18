<?php $page="inloggen"; include('header.html'); ?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <title>Wachtwoord Vergeten</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
</head>

<body>
    <div class="container col-centered">
        <div class="page-header text-center unselectable">
            <h1 class="unselectable mt-2 display-4">Wachtwoord vergeten</h1>
            <p class="text-muted"> We sturen je een mail met een link waarmee je je wachtwoord kan resetten.</p>
            <hr>
        </div>
    </div>
    <div class="container text-center">
        <form class="mt" name="wwvergeten" method="POST" enctype="multipart/form-data" action="">
            <div class="form-group">
                <input required type="email"
                    class="form-control col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2"
                    name="email" placeholder="E-mail" />
            </div>
            <input type="submit"
                class="btn btn-primary col-lg-4 offset-lg-0 col-md-6 offset-md-0 col-sm-8 offset-sm-0 col-8 offset-0"
                name="submit" value="Verzend" /><br>
        </form>
        <a class="btn btn-secondary col-lg-2 offset-lg-0 col-md-3 offset-md-0 col-sm-4 offset-sm-0 col-4 offset-0 mt-3"
            href="inloggen-b.php">Terug</a>
    </div>
    <?php
    if (isset($_POST["submit"])){
        $melding = "";
        $email = htmlspecialchars($_POST["email"]);

        $sql = "SELECT * FROM bedrijven WHERE email = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($email));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r["email"] == $email){
            // hier genereren we een token en een timestamp
            $token = bin2hex(random_bytes(32));
            $timestamp = new Datetime("now");
            $timestamp = $timestamp->getTimestamp();
            // hier slaan we het token voor deze klant in de database op
            try {
                $sql = "UPDATE bedrijven SET token = ? WHERE email = ?";
                $stmt = $verbinding->prepare($sql);
                $stmt = $stmt->execute(array($token, $email));
                if (!$stmt) {
                    echo "<script>alert('Kon niet opslaan in de database.');
                    location.href='../index.php?page=inloggen';</script>";
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }

            // hier configureren we de URL van de wachtwoord_resetten-pagina
            $url = sprintf("%s://%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'?'https' : 'http',$_SERVER['HTTP_HOST'].dirname($_SERVER["PHP_SELF"])."/wachtwoord-resetten-b.php");
            $url = $url."?token=".$token."&timestamp=".$timestamp;

            // hier mailen we de URL naar de klant
            include("bibliotheek/mailen.php");
            $onderwerp = "Wachtwoord resetten";
            $bericht = "<p>Klik <a href=".$url.">hier</a> om je wachtwoord te resetten.</p>";
            try{
                mailen($email, "Werkgever", $onderwerp, $bericht);
                $melding = "Open uw mail om verder te gaan, kijk eventueel in uw spamfolder.";
                echo '<div class="container mt-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-10 offset-1" >
                        <div class="alert alert-success text-center">
                            '.$melding.'
                        </div>
                    </div>';
            } catch (PDOException $e) {
                $melding = "Kon geen mail versturen - " . $mail->ErrorInfo;
                echo '<div class="container mt-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-10 offset-1" >
                        <div class="alert alert-danger text-center">
                            '.$melding.'
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="container mt-3 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-10 offset-1" >
                        <div class="alert alert-danger text-center">
                            Het ingevulde e-mail adres komt ons niet bekend voor. Probeer het opnieuw.
                        </div>
                    </div>';
        }
    }
?>