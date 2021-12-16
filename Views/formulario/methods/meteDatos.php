<?php    
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

    Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location: {$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/");
    }

if (isset($_FILES["recurso"])) {

    $errores = [];
    $permitidos = array("image/png", "image/jpeg", "image/jpg", "image/gif", "video/mp4", "video/mpg", "video/mpeg", "video/avi");
    $limitekb = 4096;
    if (in_array($_FILES["recurso"]["type"], $permitidos) && $_FILES["recurso"]["size"] <= $limitekb * 1024) {
        $ruta = "../../../Recursos/Preguntas/" . $_FILES["recurso"]["name"];
        move_uploaded_file($_FILES["recurso"]["tmp_name"], $ruta);
        $ruta ="'" ."../../Recursos/Preguntas/" . $_FILES["recurso"]["name"] . "'";
    } else if (!in_array($_FILES["recurso"]["type"], $permitidos)) {
        $errores["recurso"] = "El recurso debe de ser una foto o un vídeo";
    } else {
        $errores["recurso"] = "El peso del recurso supera el limite de 4MB";
    }
    if (count($errores)==0) {

        DB::insertGenerico("recurso", $ruta);
    }
}else{DB::insertGenerico();}

