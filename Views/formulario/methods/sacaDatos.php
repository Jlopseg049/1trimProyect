<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

    Sesion::iniciar();
    echo json_encode(DB::sacaFila($_SESSION["tabla"], $_SESSION["id"]));