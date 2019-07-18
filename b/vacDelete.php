<?php
    include('header.html');
?>
<?php
    $vID = $_GET["vID"];
    $bID = $_GET["bID"];
    $uID = $_SESSION["BDRF_ID"];
    if ($uID != $bID){
        echo "<script>alert('Je kan geen vacatures verwijderen die niet van jou zijn.'); window.history.back();</script>";
    } else{
        $sql = "SELECT COUNT(*) AS aantal FROM vacatures WHERE bedrijfID = ? AND ID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($uID, $vID));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r["aantal"] != 1){
            echo "<script>alert('Deze vacature bestaat niet.'); window.history.back();</script>";
        } else {
            $sql = "DELETE FROM vacatures WHERE bedrijfID = ? AND ID = ?; ALTER TABLE vacatures AUTO_INCREMENT = 1";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($uID, $vID));
            echo "<script>alert('Je vacature is verwijderd!'); location.href='vacMijn.php';</script>";
        }
    }
?>