<?php
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
        Sesion::iniciar(); 
        if (!isset($_SESSION["login"])) {
            header("location:..");
        }
        if (isset($_GET["correo"])) {
          echo DB::sacaLista(Sesion::leer("tabla"),$_GET["correo"]);        
        }else{
          echo DB::sacaLista(Sesion::leer("tabla"));
        }
