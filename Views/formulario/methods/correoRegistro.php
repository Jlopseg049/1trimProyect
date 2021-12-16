<?php   
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

Sesion::iniciar();
if (!isset($_SESSION["login"])) {
    header("location: {$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/");
}
print_r($_POST);
