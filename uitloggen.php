<?php
session_start();
unset($_SESSION["ID"]);
unset($_SESSION["USER_ID"]);
unset($_SESSION["USER_NAAM"]);
unset($_SESSION["STATUS"]);
unset($_SESSION["BDRF_ID"]);
unset($_SESSION["BDRF_NAAM"]);
unset($_SESSION["ADMIN_STATUS"]);
unset($_SESSION["ADMIN_NAAM"]);
unset($_SESSION["ADMIN_ID"]);
unset($_SESSION["E-MAIL"]);
unset($_SESSION["ROL"]);
//session beeindigen
session_destroy();
//databaseverbinding eindigen
$verbinding = null;
echo "<script>location.href='index.php'</script>";
