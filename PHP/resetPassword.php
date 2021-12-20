<?php
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>AutoEscuela JLS</title>
        <link rel="stylesheet" href="../CSS/index.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jim+Nightshade&display=swap" rel="stylesheet">
        <script src="../JS/index.js"></script>
    </head>
    <body>
       <main >
            <img src="../IMG/bg.jpg" id="noche" alt="Noche">
            <img src="../IMG/moon.png" id="luna" alt="Luna">
            <img src="../IMG/mountain.png" id="montanas" alt="Montanas">
            <img src="../IMG/road.png" id="carretera" alt="Carreteras">
                <section id="login" class="login-div flex-column-centered">
                      <h1 id="header" class="text-center">AutoEscuela JLS</h1>
                      <form method="post" class="flex-column-centered">
                       <?php
                      //Una vez todo en orden, le daremos la opción al cliente de volver a la pagina de inicio
                      if (isset($_POST["backToLogin"])) {
                          header("location: ../");
                      }


                      //Comprobamos el correo y haremos el envío
                       if (isset($_POST["resetPass"])) {
                        if (Validacion::Requerido("user") == false) {
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" required>";
                          echo "<span class=\"text-center\">" . 
                                  Validacion::imprimirError($_POST["user"]) .
                                "</span>
                                <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Enviar correo\">
                                "; 
                        }elseif(Validacion::EmailExiste($_POST["user"]) == false){
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" required>";
                          echo "<span class=\"text-center\">" . 
                                  Validacion::imprimirError($_POST["user"]) .
                                "</span>
                                <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Enviar correo\">
                                ";                        
                        }elseif(Validacion::EmailExiste($_POST["user"]) == true){
                          if(DB::resetPassMail($_POST["user"])==true){
                          echo "<span class = \"text-center\">Le hemos enviado un correo a la dirección propocionada, <br>
                          esperamos haberle sido de ayuda</span>";
                          }else{
                            echo "<span class = \"text-center\">Estamos sufriendo problemas con nuestro servidor,<br> Vuelva a intentarlo más tarde.</span>"; 
                          }

                          echo "<input type=\"submit\" id=\"inputLogin\" name=\"backToLogin\" value=\"Volver a inicio\">";
                        }



                    }else{  
                        echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" required>";

                        echo '<p class = "text-center" id="resetPassOrder">Indique su correo electrónico para poder recuperar su contraseña</p>';
                        echo "<label class=\"disappear\" for=\"recuerdame\" class=\"text-center\">Recuerdame</label>
                              <input class=\"disappear\" type=\"checkbox\" name=\"recuerdame\" id\"recuerdame\" value=\"recuerdame\">
                              <input type=\"submit\" id=\"inputLogin\" name=\"resetPass\" value=\"Enviar correo\">

                              </form>
                              <a id=\"restPasswd\"  class=\"disappear\" href=\"php/resetPassword.php#\">
                                <p class=\"text-center\">Forgot Password?</p>
                              </a>";
                      }
                       ?> 

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