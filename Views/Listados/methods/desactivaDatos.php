<?php 
require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location: ../../");
    }
    if (DB::miraRol($_SESSION["login"]) == 2) {
        DB::desactivaDatos($_SESSION["tabla"],$_GET["id"]);

    }