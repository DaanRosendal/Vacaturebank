<?php
    $page="mS"; include('header.html');

    $vID = $_GET["vID"];
    $sID = $_GET["sID"];
    $uID = $_SESSION["USER_ID"];

    if ($uID != $sID){
        echo "<script>alert('Je kan geen sollicitaties verwijderen die niet van jou zijn.'); window.history.back();</script>";
    } else{
        $sql = "SELECT COUNT(*) AS aantal FROM sollicitaties WHERE sollicitantID = ? AND vacatureID = ?";
        $stmt = $verbinding->prepare($sql);
        $stmt->execute(array($uID, $vID));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r["aantal"] != 1){
            echo "<script>alert('Deze sollicitatie bestaat niet.'); window.history.back();</script>";
        } else {
            $sql = "DELETE FROM sollicitaties WHERE sollicitantID = ? AND vacatureID = ?; ALTER TABLE sollicitaties AUTO_INCREMENT = 1";
            $stmt = $verbinding->prepare($sql);
            $stmt->execute(array($uID, $vID));
            echo "<script>alert('Je sollicitatie is verwijderd!'); location.href='vacatures.php';</script>";
        }
    }
?>