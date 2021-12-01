<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>AutoEscuela JLS</title>
        <link rel="stylesheet" href="CSS/index.css">
        <link rel="stylesheet" href="CSS/cssNavPrueba.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jim+Nightshade&display=swap" rel="stylesheet">
        <script src="JS/index.js"></script>
        <?php
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
          require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
        ?>
    </head>
    <body>
       <main>
            <img src="IMG/bg.jpg" id="noche" alt="Noche">
            <img src="IMG/moon.png" id="luna" alt="Luna">
            <img src="IMG/mountain.png" id="montanas" alt="Montanas">
            <img src="IMG/road.png" id="carretera" alt="Carreteras">
            <section id="login">
                <section id="login" class="login-div flex-column-centered">
                      <h1 id="header" class="text-center">AutoEscuela JLS</h1>
                      <form method="post" class="flex-column-centered">
                       <?php
                       if (isset($_POST["login"])) {
                        if (Validacion::Requerido($_POST["user"]) == false) {
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" required>";
                          Validacion::imprimirError($_POST["user"]);

                        }elseif(Validacion::Email($_POST["user"]) == false){
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" required>";
                          echo Validacion::imprimirError($_POST["user"]);
                       
                        }else{
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" value=\"{$_POST["user"]}\" required>";
                        }

                        if (Validacion::Requerido($_POST["password"]) == false) {
                          echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" required>";
                          Validacion::imprimirError($_POST["password"]);
                        }else{
                          echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" value=\"{$_POST["password"]}\" required>";
                        }

                        if ((Validacion::Requerido($_POST["user"]) == false || Validacion::Email($_POST["user"]) == false) &&
                             Validacion::Requerido($_POST["password"]) == false) {
                               echo "entro";
                                if (isset($_POST["recuerdame"])) {
                                  Login::identifica($_POST["user"],$_POST["password"],true);
                                }else{
                                  Login::identifica($_POST["user"],$_POST["password"]);
                                }
                                if (Login::identifica($_POST["user"],$_POST["password"]) ==true) {
                                      header("Location: views/logued.php");                        
                                }
                        }
                      }else{
                        if (isset($_COOKIE["recuerdame"])) {
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" value=".$_COOKIE["recuerdame"]." required>";
                        }else{
                          echo "<input type=\"text\" name=\"user\" id=\"user\" placeholder=\"Correo electrónico\" required>";

                        }
                        echo "<input type=\"password\" name=\"password\" id=\"password\" placeholder=\"Contraseña\" required>";
                        echo "<label for=\"recuerdame\">Recuerdame</label>
                              <input type=\"checkbox\" name=\"recuerdame\" id\"recuerdame\" value=\"recuerdame\">";
                      }
                       ?> 
                        <input type="submit" name="login" value="Login">

                      </form>
                      <a href="#">
                        <p class="text-center">Forgot Password?</p>
                      </a>
                  </div>
            </section>
            input
            </main>
    <footer class="fixed_footer">
        <div class="content">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis ducimus nemo quo totam neque quis soluta nisi obcaecati aliquam saepe dicta adipisci blanditiis quaerat earum laboriosam accusamus nesciunt! Saepe ex maxime enim asperiores nisi. Obcaecati nostrum nobis laudantium aliquam commodi veniam magni similique ullam quis pariatur voluptatem harum id error.</p>
        </div>
      </footer>
    </body>

</html>