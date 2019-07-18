<?php
    ob_clean();
    ob_start(); // Begin buffer
    include_once('../DBconfig.php');
    $rapportnaam = "../pages/".$_GET["rapportNaam"];
    include $rapportnaam . '.php';
    $rapport = ob_get_clean(); //Buffer opslaan in $rapport
    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($rapport);
    $mpdf->Output();
?>