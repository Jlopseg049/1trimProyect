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

                          echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contrase??a\" required>";
                          
                          echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contrase??a\" required>
                          <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";

                          echo "No dejes campos en blanco";
                        }elseif($_POST["password"] != $_POST["password2"] ){
                            echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contrase??a\" value=\"{$_POST["password2"]}\"required>";
                          
                            echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contrase??a\" value=\"{$_POST["password2"]}\" required>
                            <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";
                            echo "La contrase??a debe ser identica.";

                    }elseif(Validacion::Contrasena($_POST["password"]) == false || Validacion::Contrasena($_POST["password2"]) == false){
                        echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contrase??a\" value=\"{$_POST["password2"]}\"required>";
                          
                        echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contrase??a\" value=\"{$_POST["password2"]}\" required>
                        <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";
                        echo "La contrase??a debe tener al menos<br>.
                        <ul>
                            <li>Una letra may??scula</li>
                            <li>Una letra min??scula</li>
                            <li>Un n??mero</li>
                            <li>Al menos 5 caracteres</li>
                        </ul>";
                    }else{
                        if(DB::ResetPassword($_POST["password"],$_GET["hash"])){
                            echo "Su contrase??a ha sido actualizada con exito.";
                            echo "<input type=\"submit\" id=\"inputLogin\" name=\"logued\" value=\"Continuar\">";
                        }else{
                            echo "<span class=\"text-center\">Estamos experimentando problemas con nuestro servidor, vuelva a intentarlo m??s tarde.</span>";
                            echo "<input type=\"submit\" id=\"inputLogin\" name=\"backToLogin\" value=\"Volver a inicio\">";
                        }

                    }                  
                    }else{
                        echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contrase??a\" required>";
                        echo "<input type=\"password\" name=\"password2\" id=\"password2\" placeholder=\"Repite su contrase??a\" required>
                        <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Login\">";
                        
                    }
                       ?> 

                      </form>

              </section>
            </main>
    <footer class="fixed_footer">
        <div class="content">
          <p>Bienvenido, mi nombre es Jes??s L??pez Segura, soy un estudiante de 2?? de Desarrollo de aplicaciones web.
            Esta viendo, el proyecto dedicado a la evaluaci??n del primer trimestre.

            Este consistira en el manejo de un software web dedicado al manejo y experimentaci??n con examenes de autoescuela.
            En el podr??s iniciar sesion con los datos que tus profesores te proporcionen y podras pr??cticar todo lo que necesites.
            Buena suerte y un saludo.
          </p>
        </div>
      </footer>

    </body>

</html>