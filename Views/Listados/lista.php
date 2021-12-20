<?php
	if (DB::miraRol($_SESSION["login"]) === "2") {
        echo "<script src=\"../JS/lista.js\"></script>";
    }else{
        echo "<script src=\"../JS/listaAlumno.js\"></script>";

    }
    ?>
<table>
    <thead>

    </thead>
    <tbody>
        
    </tbody>

</table>
