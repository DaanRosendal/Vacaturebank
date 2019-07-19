<?php
    include('header.html');
?>
<?php
    $id = $_GET["id"];
    $sql = "SELECT COUNT(*) AS aantal FROM gebruikers WHERE ID = ?";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($id));
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r["aantal"] != 1){
        echo "<script>alert('Deze gebruiker bestaat niet.'); window.history.back();</script>";
    } else {
        $sql = "DELETE FROM gebruikers WHERE ID = ?; ALTER TABLE gebruikers AUTO_INCREMENT = 1";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($id));
        echo "<script>alert('De gebruiker is verwijderd!'); location.href='gebruikers.php';</script>";
    }
?>