<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

    Sesion::iniciar();
    $datos=["tabla" => $_SESSION["tabla"] , "estado" => $_SESSION["estado"], "esquema" => DB::esquemaTabla($_SESSION["tabla"])];
    echo json_encode($datos);