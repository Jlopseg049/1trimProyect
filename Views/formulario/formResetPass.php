<?php 
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
DB::conexion("proyecto");
if(DB::miraHash($_GET["hash"])==false){
    header("Location: ../../");
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>AutoEscuela JLS</title>
        <link rel="stylesheet" href="../../CSS/index.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jim+Nightshade&display=swap" rel="stylesheet">
        <script src="../../JS/index.js"></script>

    </head>
    <body>
       <main>
            <img src="../../IMG/bg.jpg" id="noche" alt="Noche">
            <img src="../../IMG/moon.png" id="luna" alt="Luna">
            <img src="../../IMG/mountain.png" id="montanas" alt="Montanas">
            <img src="../../IMG/road.png" id="carretera" alt="Carreteras">
                <section id="login" class="login-div flex-column-centered">
                      <h1 id="header" class="text-center">AutoEscuela JLS</h1>
                      <form method="post" class="flex-column-centered">
                       <?php
                        if (isset($_POST["backToLogin"])) {
                        header("Location: ../../");
                    }
                       if (isset($_POST["logued"])) {
                           header("Location: ../logued.php");
                       }
                       if(isset($_POST["resetPass"])){

                        if (Validacion::Requerido("password") == false || Validacion::Requerido("password2")== false ) {

                          echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" required>";
                          
                          echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contraseña\" required>
                          <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";

                          echo "No dejes campos en blanco";
                        }elseif($_POST["password"] != $_POST["password2"] ){
                            echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" value=\"{$_POST["password2"]}\"required>";
                          
                            echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contraseña\" value=\"{$_POST["password2"]}\" required>
                            <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";
                            echo "La contraseña debe ser identica.";

                    }elseif(Validacion::Contrasena($_POST["password"]) == false || Validacion::Contrasena($_POST["password2"]) == false){
                        echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" value=\"{$_POST["password2"]}\"required>";
                          
                        echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contraseña\" value=\"{$_POST["password2"]}\" required>
                        <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";
                        echo "La contraseña debe tener al menos<br>.
                        <ul>
                            <li>Una letra mayúscula</li>
                            <li>Una letra minúscula</li>
                            <li>Un número</li>
                            <li>Al menos 5 caracteres</li>
                        </ul>";
                    }else{
                        if(DB::ResetPassword($_POST["password"],$_GET["hash"])){
                            echo "Su contraseña ha sido actualizada con exito.";
                            echo "<input type=\"submit\" id=\"inputLogin\" name=\"logued\" value=\"Continuar\">";
                        }else{
                            echo "<span class=\"text-center\">Estamos experimentando problemas con nuestro servidor, vuelva a intentarlo más tarde.</span>";
                            echo "<input type=\"submit\" id=\"inputLogin\" name=\"backToLogin\" value=\"Volver a inicio\">";
                        }

                    }                  
                    }else{
                        echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" required>";
                        echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contraseña\" required>
                        <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";
                        
                    }
                       ?> 

                      </form>

              </section>
            </main>
    <footer class="fixed_footer">
        <div class="content">
          <p>Bienvenido, mi nombre es Jesús López Segura, soy un estudiante de 2º de Desarrollo de aplicaciones web.
            Esta viendo, el proyecto dedicado a la evaluación del primer trimestre.

            Este consistira en el manejo de un software web dedicado al manejo y experimentación con examenes de autoescuela.
            En el podrás iniciar sesion con los datos que tus profesores te proporcionen y podras prácticar todo lo que necesites.
            Buena suerte y un saludo.
          </p>
        </div>
      </footer>

    </body>

</html>