
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require "helpers/vendor/autoload.php";
    $mail = new PHPMailer();
    $mail->IsSMTP();

    // cambiar a 0 para no ver mensajes de error
    $mail->SMTPDebug  = 2;                          
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "tls";                 
    $mail->Host       = "smtp.gmail.com";    
    $mail->Port       = 587;                 
    // introducir usuario de google
    $mail->Username   = "jelose84@gmail.com"; 
    // introducir clave
    $mail->Password   = "!";       
    $mail->SetFrom("jelose84@gmail.com", 'Correo de prueba');
    // asunto
    $mail->Subject    = "Jesus López";
    // cuerpo
    $mail->MsgHTML('Prueba');
    // adjuntos
    $mail->AddEmbeddedImage('../IMG/moon.png', 'luna');
    $mail->Body = 'Buenas, soy jesús López y esta es una luna que utilizo en mi proyecto de la autoescuela:<br>
                    <img alt="PHPMailer" src="cid:luna">';
    $mail->AltBody = 'Usted no admite html en un correo pero le informo que Jesús López Segura le ha hablado.';
    // destinatario
    $address = "jve@iesfuentezuelas.com";
    $mail->AddAddress($address, "Test");
    // enviar
    $resul = $mail->Send();
    if(!$resul) {
    echo "Error" . $mail->ErrorInfo;
    } else {
    echo "Enviado";
    }