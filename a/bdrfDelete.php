<?php
    include('header.html');
?>
<?php
    $id = $_GET["id"];
    $sql = "SELECT COUNT(*) AS aantal FROM bedrijven WHERE ID = ?";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute(array($id));
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r["aantal"] != 1){
        echo "<script>alert('Dit bedrijf bestaat niet.'); window.history.back();</script>";
    } else {
        $sql = "DELETE FROM bedrijven WHERE ID = ?; ALTER TABLE bedrijven AUTO_INCREMENT = 1";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($id));
        echo "<script>alert('Het bedrijf is verwijderd!'); location.href='bedrijven.php';</script>";
    }
?>