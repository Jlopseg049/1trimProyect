<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <?php
<<<<<<< HEAD
            require_once "./../PHP/helpers/db.php";
            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/persona.php"
        ?>
        <link rel="stylesheet" href="CSS/css.css.css">
    </head>
    <body>

        <form action="" method="post">
        <!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <?php

            require_once "{$_SERVER["DOCUMENT_ROOT"]}/Proyecto 1trimestre/PHP/helpers/db.php" ;


        ?>
        <link rel="stylesheet" href="CSS/css.css">
    </head>
    <body>
        <?php 
        if (isset($_POST["enviar"])) {
        }
        ?>
        <form action="" method="post">
            <label for="Nombre">Nombre: *</label><input type="text" name="Nombre" required>
            <label for="Apellido_1">Apellido_1: *</label><input type="text" name="Apellido_1" required>
            <label for="Apellido_2">Apellido_2:(Opcional)</label><input type="text" name="Apellido_2" >
            <label for="Pass">Contraseña: *</label><input type="password" name="Pass" >
            <label for="Date">Fecha Nacimiento: *</label><input type="date" name="Date" >
            <label for="Correo">Correo electrónico: *</label><input type="email" name="Correo" required>
            <label for="img">Foto de perfil:(Opcional):</label><input type="file" name="img" >

            <!--         <label for="Rol">Rol</label><input type="text" name="Rol" required>
    -->
            <?php
            if (isset($_POST["enviar"])) {
                if (empty($_POST["Nombre"]) || empty($_POST["Pass"]) || empty($_POST["Apellido_1"]) || empty($_POST["Correo"]) ) {
                    echo "No dejes campos en blanco";
                }else{
                    $fechaNac= date('m-m-Y', strtotime($_POST['Date']));
                    $Usuario = new Usuario(array("id"       => "",
                                                 "nombre"   =>  $_POST["Nombre"], 
                                                 "ap1"      =>  $_POST["Apellido_1"],
                                                 "ap2"      =>  $_POST["Apellido_2"],
                                                 "email"    =>  $_POST["Correo"],
                                                 "password" =>  $_POST["Pass"],
                                                 "fechaNac" =>  $fechaNac,
                                                 "foto"     =>  "",
                                                 "rol"      =>  1,
                                                 "activo"   =>  1));
                                              
                    login::registro($Usuario);
                    //Login para pruebas, mas adelante haremos un header con un aviso de que enviamos un correo
                    login::identifica($Usuario);
=======

            require_once "../PHP/helpers/db.php";
            include_once "../PHP/helpers/session.php";
            include_once "../PHP/helpers/login.php";
    
        ?>
        <link rel="stylesheet" href="../CSS/registerCSS.css ">
    </head>
    <body>

        <form action="" method="post" autocomplete="off">
            <label for="email">Correo electrónico:</label><input type="email" name="Apellido2">
            <label for="Nombre">Nombre:</label><input type="text" name="Nombre" required>
            <label for="Apellido1">Apellido 1:</label><input type="text" name="Apellido1" required>
            <label for="Apellido2">Apellido 2:</label><input type="text" name="Apellido2">

            <label for="Pass">Contraseña:</label><input type="password" name="Pass" required>
            <?php
            if (isset($_POST["enviar"])) {
                if (empty($_POST["Nombre"]) || empty($_POST["Pass"])) {
                    echo "No dejes campos en blanco";
                }else{
                    Login::identifica($_POST["Nombre"],$_POST["Pass"]);
                    header("Location: views/Pruebas.php");

>>>>>>> db1869e6cdc39237d857d5959ce5fdb9aefb5f00
                }
            }
            ?>
            <button type="submit" name="enviar">Iniciar sesion</button>
        </form>
    </body>
</html> 