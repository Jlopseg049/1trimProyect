<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <?php

            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/persona.php";
            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/session.php";
            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/login.php";
            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/validator.php";
            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/db.php";



        ?>
        <link rel="stylesheet" href="CSS/css.css.css">
    </head>
    <body>

        <form action="" method="post">
            <label for="Email">Email</label><input type="email" name="Email" required>
            <label for="Pass">Contraseña</label><input type="password" name="Pass" required>
            <?php
            if (isset($_POST["enviar"])) {
                if (empty($_POST["Email"]) || empty($_POST["Pass"])) {
                    echo "No dejes campos en blanco";
                }elseif($a){

                }else{
                    Login::identifica($_POST["Email"],$_POST["Pass"]);
                    header("Location: views/Pruebas.php");

                }
            }
            ?>
            <button type="submit" name="enviar">Iniciar sesion</button>
        </form>
    </body>
</html> 