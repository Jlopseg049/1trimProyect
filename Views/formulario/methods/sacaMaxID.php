<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

    Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location: {$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/");
    }

    if($_GET["tabla"] == null){
        $tabla = Sesion::leer("tabla");
    }else{
        $tabla = $_GET["tabla"];
    }
    echo json_encode(DB::sacaMaxId($tabla));