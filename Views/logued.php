<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AutoEscuela JLS</title>
        <link rel="stylesheet" href="../CSS/cssNavPrueba2.css">
        <link rel="stylesheet" href="../CSS/tablaCss.css">
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <?php
        if(isset($_GET["p"]) && $_GET["p"] == "formulario/form"){
            echo "<link rel='stylesheet' href='../SCSS/form.css'>";
        }
        ?>
    <?php
        require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
        require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
    ?>
    </head>
    <body>
    <?php
    Sesion::iniciar();
    if (!isset($_SESSION["login"])) {
        header("location:..");
    }
    //de inicio sera perfil
    $pagina = isset($_GET["p"]) ? strtolower($_GET["p"]) : "Listados/lista";

    isset($_GET["t"])?Sesion::escribir("tabla", $_GET["t"]):"";

    isset($_GET["e"])?Sesion::escribir("estado",$_GET["e"]):"";

    isset($_GET["id"])?Sesion::escribir("id",$_GET["id"]):"";

//cabecera
    require_once "header.php";
    ?>
    <main class="content">
    <?php
//cuerpo
    require_once $pagina . ".php";
    ?>
    </main>
    <?php
//pie
    require_once "footer.php";
    ?>
    </body>
</html>
