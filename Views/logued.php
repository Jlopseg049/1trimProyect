<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AutoEscuela JLS</title>
        <link rel="stylesheet" href="../CSS/cssNavPrueba2.css">
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    </head>
    <header class="header">
    <?php
//cabecera
    session_start();
    var_dump($_SESSION["login"]);
    require_once "header.php";
    ?>
    </header>
    <main class="main">
    <?php
//cuerpo
    require_once "Admin/Examen/nuevoExamen.PHP";
    ?>
    </main>
    <?php
//pie
    require_once "footer.php";
    ?>
</html>
