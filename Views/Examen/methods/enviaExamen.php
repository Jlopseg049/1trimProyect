<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location: ../../");
    }
    $id = DB::miraIDPersona($_SESSION["login"]);
    DB::enviaExamen($id);