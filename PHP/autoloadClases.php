<?php
spl_autoload_register(function($clase)
{
    $fichero=$_SERVER['DOCUMENT_ROOT'].'/proyecto 1trimestre'.'/PHP/'.$clase.'.php';
    if(file_exists($fichero))
    {
        require_once $fichero;
    }
});
