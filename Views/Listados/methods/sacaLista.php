<?php
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
        Sesion::iniciar(); 
        DB::Conexion("proyecto");
        echo DB::sacaLista(Sesion::leer("tabla"));