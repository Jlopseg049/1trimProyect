<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tienda</title>
        <?php
           require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
           require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
        ?>
        <link rel="stylesheet" href="CSS/css.css.css">
    </head>
    <body>
        <?php 
        if (isset($_POST["enviar"])) {
        }
        ?>
        <form action="" method="post">
            <div>
                <label for="Nombre">
                    <input type="text" name="Nombre" required>
                    <span>Nombre: *</span>
                </label>
                
                <label for="Apellido_1">
                    <input type="text" name="Apellido_1" required>
                    <span>Apellido_1: *</span>
                </label>
                
                <label for="Apellido_2">
                    <input type="text" name="Apellido_2" >
                    <span>Apellido_2:(Opcional)</span>
                </label>
                    
                
                <label for="Pass">
                    <input type="password" name="Pass" >
                    <span>Contraseña: *</span>
                </label>
                
                <label for="Date">
                    <input type="date" name="Date" >
                    <span>Fecha Nacimiento: *</span>
                </label>
                
                <label for="Correo">
                    <input type="email" name="Correo" required>
                    <span>Correo electrónico: *</span>
                </label>
                
                <label for="img">
                    <input type="file" name="img" >
                    <span>Foto de perfil:(Opcional):</span>
                </label>
            </div>
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
                }
            }
            ?>
            <div>
                <input type="submit" name="enviar" value="Confirmar Registro">
            </div>
        </form>
    </body>
</html> 