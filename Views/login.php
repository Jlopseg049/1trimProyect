<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <?php

            require_once "PHP/DB.php";
            require_once "`PHP`/User.php";
            include_once "PHP/Sesion.php";
            include_once "PHP/Login.php";


        ?>
        <link rel="stylesheet" href="CSS/css.css.css">
    </head>
    <body>

        <form action="" method="post">
            <label for="Nombre">Nombre</label><input type="text" name="Nombre" required>
            <label for="Pass">Contraseña</label><input type="password" name="Pass" required>
            <?php
            if (isset($_POST["enviar"])) {
                if (empty($_POST["Nombre"]) || empty($_POST["Pass"])) {
                    echo "No dejes campos en blanco";
                }else{
                    Login::identifica($_POST["Nombre"],$_POST["Pass"]);
                    header("Location: views/Pruebas.php");

                }
            }
            ?>
            <button type="submit" name="enviar">Iniciar sesion</button>
        </form>
    </body>
</html> 