<?php   
require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";

Sesion::iniciar();
if (!isset($_SESSION["login"])) {
    header("location: ../../");
}
$Errores = 0;
foreach ($_POST as $key => $value) {
    if (empty($value)) {
$Errores = $Errores+1;    }
}
if($Errores==0){
DB::insertExamen();
}else{
    echo "No dejes campos en blanco";
}