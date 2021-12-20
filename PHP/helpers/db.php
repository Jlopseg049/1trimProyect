<?php
    use PHPMailer\PHPMailer\PHPMailer;

require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
    class DB{

        // Creamos e iniciamos la conexion

        protected static $con;
        
        public static function conexion(String $nombreDB){
            //Preparamos las opciones de nuestra conexión para una mejor legibilidad
            $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            self::$con = new PDO("mysql:host=localhost;dbname=${nombreDB}", 'root', '', $opciones);
            return self::$con;
        }

        //Eliminar una fila concreta de una tabla concreta

        public static function quitaDatos($nombreTabla = null, $idFila = null){
            if($nombreTabla != null || $idFila != null){
                $conexion = DB::conexion("proyecto");
                $conexion->beginTransaction();
    
                try {
                    $sql = "SELECT 
                    column_name as PRIMARYKEYCOLUMN
                    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
                    
                    INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
                        ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                        AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
                        AND KU.table_name=\"${nombreTabla}\"
                    where tc.table_schema = \"proyecto\" and tc.TABLE_NAME=\"${nombreTabla}\";";

                        $peticion = self::$con->prepare($sql);
                        $peticion -> execute();
                        $PK = $peticion->fetch(PDO::FETCH_ASSOC);

                    $sql = "delete from proyecto.${nombreTabla}
                    where `{$PK["PRIMARYKEYCOLUMN"]}` = ${idFila}";
                    $peticion = self::$con->prepare($sql);
                    $peticion -> execute();

                    $conexion->commit();
        
                }catch(PDOexception $e){
                    $conexion->rollBack();
                }
                
            }
        }
        //Sacar una fila concreta de una tabla concreta
    
        public static function sacaFila($nombreTabla = null, $idFila = null){
            if($nombreTabla != null || $idFila != null){
                DB::conexion("proyecto");
                //Antes de hacer la consulta, debemos sacar su clave principal ya que no todas son iguales
                $sql = "SELECT 
                            column_name as PRIMARYKEYCOLUMN
                            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
                            
                            INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
                                ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                                AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
                                AND KU.table_name=\"${nombreTabla}\"
                            where tc.table_schema = \"proyecto\" and tc.TABLE_NAME=\"${nombreTabla}\";";

                $peticion = self::$con->prepare($sql);
                $peticion -> execute();
                $PK = $peticion->fetch(PDO::FETCH_ASSOC);
                    //Una vez tenemos el id, vamos a hacer la consulta
                    if($nombreTabla == "persona"){
                        $sql = "select nombre , 
                                       ap1 , 
                                       ap2 , 
                                       fechaNac,
                                       rol
                                 from proyecto.${nombreTabla} where `{$PK["PRIMARYKEYCOLUMN"]}` = " .  $idFila;
                                 
                    }else if($nombreTabla == "preguntas"){
                        $sql = "select * from proyecto.${nombreTabla} where `{$PK["PRIMARYKEYCOLUMN"]}` = " .  $idFila;
                            $peticion = self::$con->prepare($sql);
                            $peticion->execute();
                            $resultado[] = $peticion->fetchAll(PDO::FETCH_ASSOC);
                        $sql = "select idrespuestas, respuesta from proyecto.respuestas where PreguntaRespuesta = " .  $idFila;
                            $peticion = self::$con->prepare($sql);
                            $peticion->execute();
                            $resultado[] = $peticion->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                    }else{
                        $sql = "select * from proyecto.${nombreTabla} where `{$PK["PRIMARYKEYCOLUMN"]}` = " .  $idFila;
                    }
                    $peticion = self::$con->prepare($sql);
                    $peticion->execute();
                    $resultado[] = $peticion->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }else{
                return "No dejes campos en blanco";
            }

        }

        //Sacar el esquema de cualquier tabla

        public static function esquemaTabla($nombreTabla = null){
            if($nombreTabla != null){
                DB::conexion("proyecto");

                if ($nombreTabla == 'preguntas') {
                    $sql ="SELECT COLUMN_NAME AS `Campo`, COLUMN_TYPE AS `Tipo`, IS_NULLABLE AS `NULL`, 
                                COLUMN_KEY AS `PK`, COLUMN_DEFAULT AS `Default`, EXTRA AS `Extra`
                                    FROM information_schema.COLUMNS  
                                     WHERE TABLE_SCHEMA = 'proyecto' AND TABLE_NAME = 'preguntas' || 
                                            TABLE_NAME = 'respuestas';";
                    $peticion = self::$con->prepare($sql);
                    $peticion -> execute();
                    $esquema = $peticion->fetchAll(PDO::FETCH_NUM);
                }else{
                    $sql ="Desc ${nombreTabla}";
                    $peticion = self::$con->prepare($sql);
                    $peticion -> execute();
                    $esquema = $peticion->fetchAll(PDO::FETCH_NUM);
                }

                return $esquema;
            }else{
                
                return "Indique el nombre de alguna tabla";
            }
        }

        //Sacar una lista para cualquier tabla

        public static function sacaLista(String $nombreTabla, $correo = null){
            DB::conexion("proyecto");
            if($nombreTabla == "persona"){
                $sql = "Select idPersona, concat(nombre,' ',ap1,' ',ap2) as 'Nombre' ,
                                email as 'Correo electrónico', 
                                (Select nombreRol from proyecto.rol 
                                        where proyecto.rol.idRol = 
                                        proyecto.persona.rol) as 'Rol', 

                                (select count(proyecto.examenhecho.idPersona) 
                                        from proyecto.examenHecho 
                                        where proyecto.examenhecho.idexamenHecho = 
                                        proyecto.persona.idPersona) 
                                        as 'Examenes realizados' ,

                                (select estado from proyecto.activo 
                                        where proyecto.activo.idActivo = 
                                        proyecto.persona.activo) as 'Activo', 
                                        
                                fechaNac as 'Fecha nacimiento' 
                            from proyecto.${nombreTabla}";
            }else 
            
            if(DB::miraRol($_SESSION["login"]) == 1 && $nombreTabla == "examen"){
                $sql="select idExamen, descripcion, nPreguntas, duracion from proyecto.${nombreTabla} where activo = 1";
            }else
            if(DB::miraRol($_SESSION["login"]) == 1 && $nombreTabla == "examenHecho"){
                $sql="SELECT e.fecha, e.calificacion FROM proyecto.examenHecho e inner join proyecto.persona p on
                e.idPersona = p.idPersona where p.email = '${correo}';";
            }else{
                $sql = "Select * from proyecto.${nombreTabla}";
            }
            $peticion = self::$con->prepare($sql);
            $peticion -> execute();
            $object = new stdClass();
            $object->resultado=$peticion->fetchAll(PDO::FETCH_NUM);
            $columnasCabecera = $peticion->columnCount();
            for($i=0; $i < $columnasCabecera; $i++){
                $celdaCabecera = $peticion->getColumnMeta($i);
                $object->cabecera[] = $celdaCabecera['name'];
            }
            $object->tabla=$nombreTabla;
            if ($nombreTabla == "persona") {
                $sql="select id from proyecto.${nombreTabla}";
            }
                $sql="desc proyecto.${nombreTabla}";
                $peticion = self::$con->prepare($sql);
                $peticion -> execute();
            $object->esquemaTabla=$peticion->fetchAll(PDO::FETCH_NUM);
            return json_encode($object);
        }
        
//Update generico
public static function updateGenerico(String $file=null, String $ruta = null){
    $conexion = DB::conexion("proyecto");
    //Separaremos los campos y sus valores y los usaremos como campos para los inserts
    $campo = [];
    $valor = [];
    foreach( $_POST as $name => $value){
        $campo[]= $name; $valor[]= $value;
    }


    $conexion->beginTransaction();
    try {
        $sql = "SELECT 
        column_name as PRIMARYKEYCOLUMN
        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
        
        INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
            ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
            AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
            AND KU.table_name=\"{$valor[0]}\"
        where tc.table_schema = \"proyecto\" and tc.TABLE_NAME=\"{$valor[0]}\";";

            $peticion = self::$con->prepare($sql);
            $peticion -> execute();
            $PK = $peticion->fetch(PDO::FETCH_ASSOC);

        $sql ="update ". $valor[0] . " set ";
        if ($file!=null && $ruta != null) {
            $sql .= $file . " = " .$ruta ." , ";
        }
        for ($i=1; $i <= count($campo) -1; $i++) { 
            if($i == count($campo) -1){
                $sql .="`" .$PK["PRIMARYKEYCOLUMN"]. "`" . "=" . $valor[$i] ." ";

            }elseif ($campo[$i] == "undefined") {
            continue;}else{

            $sql .= $campo[$i] . "=" . $valor[$i] . ",";
            }
        }

        $sql .= "where `{$PK["PRIMARYKEYCOLUMN"]}` = {$_POST["id"]}";
            
        $peticion = self::$con->prepare($sql);
        $peticion -> execute();

        $conexion->commit();
    } catch (\PDOexception $e) {
        $conxion->rollBack();
    }
}


//desactivar una fila de una tabla concreta 
public static function desactivaDatos(String $nombreTabla, String $id){
    $conexion = DB::conexion("proyecto");
    $conexion->beginTransaction();
    try {
        $sql = "SELECT 
        column_name as PRIMARYKEYCOLUMN
        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
        
        INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
            ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
            AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
            AND KU.table_name=\"${nombreTabla}\"
        where tc.table_schema = \"proyecto\" and tc.TABLE_NAME=\"${nombreTabla}\";";

            $peticion = self::$con->prepare($sql);
            $peticion -> execute();
            $PK = $peticion->fetch(PDO::FETCH_ASSOC);

        $sql = "update ${nombreTabla} 
                set activo = ((activo - 1) * -1) 
                where  `{$PK["PRIMARYKEYCOLUMN"]}` = " .  $id ;
                //Si activo = 0 entonces (0 - 1) * -1 = 1
                //Si activo = 1 entonces (1 - 1) * -1 = 0

                $peticion = self::$con->prepare($sql);
                $peticion -> execute();

        $conexion->commit();
    } catch (\PDOexception $e) {
        $conexion->rollBack();
    }
}



//insert generico
public static function insertGenerico(String $file=null, String $ruta = null){
    DB::conexion("proyecto");
    //Separaremos los campos y sus valores y los usaremos como campos para los inserts
    $campo = [];
    $valor = [];
    foreach( $_POST as $name => $value){
        $campo[]= $name; $valor[]= $value;
    }
    $sql = "insert into proyecto." . $valor[0] . " (";
    if ($file!=null && $ruta != null) {
        $sql .= $file . ",";
    }
        for ($i=1; $i < count($campo); $i++) { 
            if($i == count($campo) -1){
                $sql .= $campo[$i] . ")";
            }else{
                $sql .= $campo[$i] . ",";
            }
        }

    $sql .= " values (";
    if ($file!=null && $ruta != null) {
        $sql .= $ruta . ",";
    }
        for ($i=1; $i <  count($valor); $i++) { 
            if($i == count($valor) -1){
                $sql .= $valor[$i] . ")";
            }else{
                $sql .= $valor[$i] . ",";
            }  
        }
        var_dump($sql);
        $peticion = self::$con->prepare($sql);
        if($peticion -> execute() == true)
        {   

            if ($valor[0] == "persona") {
                $value  = rand(0,50000000000000);
                $value .= "----";
                $fecha  = date(DATE_RFC2822);
                $fecha .= "----";
                $hash = md5($value.$fecha);
            $sql ="insert into proyecto.resgistropendiente (correoPendiente, hash) 
                values (" . 
                    $valor[1] . ",'" . $hash."')";
                    $peticion = self::$con->prepare($sql);
                    $peticion -> execute(); 




            //Correo registro
                require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/vendor/autoload.php";

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
                $mail->Password   = "SanjeSus1890";       
                $mail->SetFrom("jelose84@gmail.com", 'Correo de prueba');
                // asunto
                $mail->Subject    = "Confirme su registro en AutoEscuela JLS";
                // cuerpo
                $mail->MsgHTML('Prueba');
                // adjuntos

                $mail->Body = "Bienvenido a AutoEscuela JLS, soy jesús López y usted ha sido registrado en nuestra aplicación,
                le escribo para informarle que usted debe completar el registro en el siguiente 
                <a href=\"http://projects/Proyecto%201trimestre/views/register?hash=${hash}\" target=\"_blank\">enlace</a><br> Un saludo.";
                $mail->AltBody = "Usted no admite html en un correo pero le informo que Jesús López Segura de AutoEscuelaJLS le ha hablado.";
                // destinatario
                $address = $valor[1] ;
                $address = substr($address,1);
                $address = substr($address,0,-1);

                $mail->AddAddress($address);
                // enviar
                $resul = $mail->Send();
                if(!$resul) {
                echo "Error" . $mail->ErrorInfo;
                } else {
                echo "Enviado";
                }
            }
        }
        else{
        }
}
        public static function resetPassMail($correo){
         DB::conexion("proyecto");
            //Si hay algun error al enviar el correo o al insertar, no haremos ninguna de las dos cosas
          try {
            self::$con->beginTransaction();
            $value  = rand(0,50000000000000);
            $value .= "----";
            $fecha  = date(DATE_RFC2822);
            $fecha .= "----";
            $hash = md5($value.$fecha);
            $sql ="insert into proyecto.resgistropendiente (correoPendiente, hash)
            values('${correo}','${hash}')";
            $peticion = self::$con->prepare($sql);
            $peticion->execute(); 
            //Correo registro
            require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/vendor/autoload.php";

            $mail = new PHPMailer();
            $mail->IsSMTP();

            // cambiar a 0 para no ver mensajes de error
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = "tls";                 
            $mail->Host       = "smtp.gmail.com";    
            $mail->Port       = 587;         
            $mail->CharSet    = 'UTF-8';
        
            // introducir usuario de google
            $mail->Username   = "jelose84@gmail.com"; 
            // introducir clave
            $mail->Password   = "SanjeSus1890";       
            $mail->SetFrom("jelose84@gmail.com", 'Correo de prueba');
            // asunto
            $mail->Subject    = "Confirme su cambio de contraseña en AutoEscuela JLS";
            // cuerpo
            $mail->MsgHTML('Prueba');
            // adjuntos

            $mail->Body = "Bienvenido a AutoEscuela JLS, soy jesús López y usted ha solicitado un reinicio de contraseña <br>
                        Puedes cambiarlo accediente al siguiente enlace <br> 
            <a href=\"http://projects/Proyecto%201trimestre/views/formulario/formResetPass.php?hash=${hash}\" target=\"_blank\">enlace</a><br> Un saludo.";
            $mail->AltBody = "Usted no admite html en un correo pero le informo que Jesús López Segura le ha hablado.";
            // destinatario
            $address = $correo ;
            $mail->AddAddress($address);
            // enviar
            $resul = $mail->Send();
            if(!$resul) {

            return false;
            } else {
                self::$con->commit();

            return true;

            }          
        } catch (PDOException  $e) {
            echo $e->getMessage();           

            self::$con->rollBack();
        }
    }

        //Preparar un campo <Select> con los datos de la tabla
        //normalmente se hara con la tabla rol o tematica
        public static function creaSelect(String $nombreTabla){
            DB::conexion("proyecto");
            $sql ="select * from proyecto.${nombreTabla}";
            $peticion = self::$con->prepare($sql);
            $peticion -> execute();
            $select = $peticion->fetchAll(PDO::FETCH_NUM);
            return $select;
            
        }

        public static function ResetPassword(String $password, String $hash){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();

            try {
                $sql = "update proyecto.persona 
                            set contrasena = '${password}'
                        where email = (select correopendiente from proyecto.resgistropendiente 
                                            where hash = '${hash}')";
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();


                $sql="select email, contrasena from  proyecto.persona
                where email  = (select correopendiente from proyecto.resgistropendiente 
                where hash = '${hash}')";
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();
                $select = $peticion->fetch();


                $sql = "delete from proyecto.resgistropendiente
                        where correopendiente = '{$select["email"]}'";
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();

                Login::Identifica($select["email"],$select["contrasena"]);
                $conexion->commit();
                return true;
            } catch (PDOexception $e) {
                echo $e->getMessage();           

                $conexion->rollBack();
                return false;

            }
        }

        public static function miraHash($hash){
            DB::conexion("proyecto");
            $sql ="select hash from proyecto.resgistropendiente where hash = '${hash}'";
            $peticion = self::$con->prepare($sql);
            $peticion -> execute();
            $select = $peticion->fetch();
            if($select["hash"] == $hash && $select["hash"] != ""){
                return true;
            }else{
                return false;
            }
        }

        // Para probar la conexion usar
        //  
        //   echo 'Conectado a '.self::$con->getAttribute(PDO::ATTR_CONNECTION_STATUS);

        //Usuarios
        //Registraremos el usuario con los datos proporcionados
        public static function nuevoUsuario(Usuario $user){
            $sql="INSERT INTO proyecto.persona (nombre, ap1, ap2, email,
                                                  contasena, fechaNac, foto, activo, rol)
                                        VALUES   (:Nombre, :ap1, :ap2, :Correo, 
                                                    :contasena, :fechaNac, :foto, :activo, :rol)";
            //Montamos la sentencia y asignamos los datos clave->valor
            $resultado = self::$con->prepare($sql);
            $nombre = $user->__get("nombre");
            $resultado->bindParam(":Nombre", $nombre);

            $ap1 = $user->__get("ap1");
            $resultado->bindParam(":ap1", $ap1);

            $ap2 = $user->__get("ap2");
            $resultado->bindParam(":ap2", $ap2);

            $email = $user->__get("email");
            $resultado->bindParam(":Correo", $email);

            $password = $user->__get("password");
            $resultado->bindParam(":contasena", $password);

            $fechaNac = $user->__get("fechaNac");
            $resultado->bindparam(":fechaNac", $fechaNac);

            $foto = $user->__get("foto");
            $resultado->bindParam(":foto", $foto);

            $activo = $user->__get("activo");
            $resultado->bindParam(":activo", $activo);

            $rol = $user->__get("rol");
            $resultado->bindParam(":rol", $rol);

            //Ejecutamos la sentencia preparada
            $resultado->execute();


        }
        //Resgistrar un usuario
        public static function Register($ruta, $hash){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();

            try {
                $sql = "update proyecto.persona 
                            set nombre = '{$_POST["Nombre"]}',
                                ap1    = '{$_POST["Ap1"]}',
                                ap2    = '{$_POST["Ap2"]}',
                                contrasena = '{$_POST["password"]}',
                                fechaNac = '{$_POST["fechaNac"]}',
                                recurso = '$ruta',
                                activo = 1

                        where email = (select correopendiente from proyecto.resgistropendiente 
                                            where hash = '${hash}')";
                        $peticion = $conexion->prepare($sql);
                        $peticion -> execute();
                $sql="select email, contrasena from  proyecto.persona
                    where email  = (select correopendiente from proyecto.resgistropendiente 
                    where hash = '${hash}')";
                    $peticion = $conexion->prepare($sql);
                    $peticion -> execute();
                    $select = $peticion->fetch();

                    var_dump($peticion -> execute());
                $sql = "delete from proyecto.resgistropendiente
                        where correopendiente = '{$select["email"]}'";
                    $peticion = $conexion->prepare($sql);
                    $peticion -> execute();
                    var_dump($peticion -> execute());

                Login::Identifica($select["email"],$select["contrasena"]);

                $conexion->commit();
                return true;
            }catch(PDOexception $e){
                return false;
                $conexion->rollBack();
            }
        }
        // Comprobamos que el usuario y contraseña se encuentran en nuestra BD
        public static function Existeusuario(String $usuario, String $contrasena){
            $sql = "SELECT email, contrasena, activo FROM proyecto.persona
                            where email like '${usuario}'";
            $resultado = self::$con->query($sql);
            if($resultado){ 
                while($fila = $resultado->fetch()){
                    if($fila["email"] == $usuario && $fila["contrasena"] == $contrasena &&
                        $fila["activo"]==1){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
                return false;
        }

        public static function existeEmail(String $correo){
            $conexion = DB::conexion("proyecto");
            $sql = "SELECT email from proyecto.persona
            where email like '${correo}'";
            $resultado = self::$con->query($sql);
            if($resultado){ 
                while($fila = $resultado->fetch()){
                    if($fila["email"] == $correo){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
            return false;
            }
        
        //Examen
        public static function enviaExamen($id){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();
            try {
                    //primero calculamos la nota
                    $sql ="select respuestaCorrecta from proyecto.preguntas
                    inner join proyecto.examenpreguntas on
                    proyecto.preguntas.`id Pregunta` = proyecto.examenpreguntas.idPreguntas 
                    where proyecto.examenpreguntas.idExamen =  {$_POST["idExamen"]}";
                    $peticion = $conexion->prepare($sql);
                    $peticion -> execute();
                    $respuestas = $peticion->fetchAll(PDO::FETCH_NUM);
                    $_POST["calificacion"] = explode(",",$_POST["calificacion"]);

                        $nota = 0;
                    for ($i=0; $i < count($_POST["calificacion"]); $i++) { 
                         $_POST["calificacion"][$i] .= "";
                        if (in_array($_POST["calificacion"][$i],$respuestas[$i])) {
                            $nota +=1;
                        }else{
                            $nota -=0.2;
                        }
                    }
                    if ($nota < 0) {
                        $nota = "0/100";
                    }else{
                        $nota = $nota * 100 / count($_POST["calificacion"]) . "/100";
                    }


                $sql ="insert into examenhecho set
                idExamen = {$_POST["idExamen"]},
                idPersona = ${id},
                fecha = NOW(),
                calificacion = '${nota}',
                ejecucion = '{$_POST["ejecucion"]}'";
                $peticion = $conexion->prepare($sql);
                var_dump($sql);
                $peticion -> execute();
                $conexion->commit();
            } catch (\PDOexception $e) {
                $conexion->rollBack();
            }   
        }
        public static function corrigeExamen($id){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();
            try {
                $sql ="select respuestaCorrecta from proyecto.preguntas.respuestaCorrecta
                inner join proyecto.examenpreguntas on
                proyecto.preguntas.`id Pregunta` = proyecto.examenpreguntas.idPreguntas 
                where proyecto.examenpreguntas.idExamen =  ${id}";
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();
                $select = $peticion->fetchAll(PDO::FETCH_NUM);

                $conexion->commit();
                return $select;
            } catch (\PDOexception $e) {
                $conexion->rollBack();
            }   
        }
        public static function insertExamen(){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();
            try {
                $preguntas = explode(",", $_POST["preguntas"]);
                $nPreguntas =  count($preguntas);
                $sql ="insert into proyecto.examen (descripcion,duracion,nPreguntas) 
                    values ('{$_POST["descripcion"]}',
                    '{$_POST["duracion"]}',
                    ${nPreguntas})";
                    $peticion = $conexion->prepare($sql);
                    $peticion -> execute();
                
                
                $sql="select max(idExamen) from  proyecto.examen";
                    $peticion = $conexion->prepare($sql);
                    $peticion -> execute();
                    $select = $peticion->fetch();

                $conexion->commit();
            } catch (\PDOexception $e) {
                $conexion->rollBack();
            }
        }
        public static function borraExamen($id){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();
            try {
                $sql="delete from proyecto.examenpreguntas
                where idExamen = ${id}";
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();

                $sql="delete from proyecto.examen
                where idExamen = ${id}";
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();
                $select = $peticion->fetch(PDO::FETCH_ASSOC);

                $conexion->commit();
            } catch (\PDOexception $e) {
                $conexion->rollBack();
            }
        }

        public static function miraIDPersona($id){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();
            try {
                $sql = "select idPersona from proyecto.persona where email = '${id}'";
                
                $peticion = $conexion->prepare($sql);
                $peticion -> execute();
                $select = $peticion->fetch();
                var_dump($select);
                return $select[0];

                $conexion->commit();
            } catch (\PDOexception $e) {
                $conexion->rollBack();
            }
        }

//         public static function sacaPDF($id){
//             require_once 'helpers/vendor/autoload.php';
// use Dompdf\Dompdf;
// $html='
// <html>
// <head>
// <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
// <title>Pedazo de PDF</title>
// </head>
// <body>

// <h2>Ingredientes para aprobar DWES</h2>
// <p>Ingredientes:</p>
// <dl>
// <dd>Perseverancia</dd>
// <dd>Constancia</dd>
// <dd>Optimismo</dd>
// <dd>Autoestima</dd>
// <dd>Trabajo en Equipo</dd>
// <dd>Jamón Pata Negra</dd>
// </dl>
// </body>
// </html>';
// $mipdf = new Dompdf();
// # Definimos el tamaño y orientación del papel que queremos.
// # O por defecto cogerá el que está en el fichero de configuración.
// $mipdf ->set_paper("A4", "portrait");
// # Cargamos el contenido HTML.
// $mipdf ->load_html($html);

// # Renderizamos el documento PDF.
// $mipdf ->render();

// # Creamos un fichero
// $pdf = $mipdf->output();
// $filename = "HeavenTicket.pdf";
// file_put_contents($filename, $pdf);

// # Enviamos el fichero PDF al navegador.
// $mipdf->stream($filename, array("Attachment" => false));

// exit(0);
//         }
        public static function sacaExamen(Int $id){
            $conexion = DB::conexion("proyecto");
            $conexion->beginTransaction();
            try {
                $sql = "select idExamen as id, descripcion, duracion from proyecto.examen
                            where activo = 1 and idExamen = ${id}";

                            $peticion = $conexion->prepare($sql);
                            $peticion -> execute();
                            $select = $peticion->fetch(PDO::FETCH_OBJ);

                $sql = "select `id Pregunta` as id, Pregunta as enunciado, recurso from proyecto.preguntas
                            inner join proyecto.examenpreguntas on 
                            proyecto.preguntas.`id Pregunta` 
                            = 
                            proyecto.examenpreguntas.idPreguntas
                            where proyecto.examenpreguntas.idExamen = ${id}";
                            $peticion = $conexion->prepare($sql);
                            $peticion -> execute();
                            $select->preguntas = $peticion->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < count($select->preguntas) ; $i++) { 
                                $select->preguntas[$i]["respuestas"]=[];
                                $select->preguntas[$i]["idrespuestas"] = [];
                                $sql = "select idrespuestas as id, respuesta as enunciado from proyecto.respuestas
                                inner join proyecto.preguntas on
                                proyecto.respuestas.PreguntaRespuesta = proyecto.preguntas.`id Pregunta`
                                where proyecto.respuestas.PreguntaRespuesta = {$select->preguntas[$i]["id"]}";
                                     
                                $peticion = $conexion->prepare($sql);
                                $peticion -> execute();
                                while($fila = $peticion->fetch()){
                                    array_push($select->preguntas[$i]["idrespuestas"], $fila[0]);
                                    array_push($select->preguntas[$i]["respuestas"], $fila[1]);

                                }
                            }
                $conexion->commit();
                return $select;
            } catch (\PDOexception $e) {
                $conexion->rollBack();
            }
        }

        public static function sacaPreguntas($idPregunta=null){
            if($idPregunta!=null){
                $sql ="Select * from proyecto.preguntas inner join proyecto.tematica on
                proyecto.preguntas.tematica = proyecto.tematica.`id Tematica`
                where proyecto.preguntas.idpregunta =${idPregunta};";
            }else{
                $sql ="Select * from proyecto.preguntas inner join proyecto.tematica on
                proyecto.preguntas.tematica = proyecto.tematica.`id Tematica`;";
            }

            $resultado = self::$con->query($sql);
            $object = new stdClass();
            $object->preguntas=[];
                while($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
                    $objPregunta = new stdClass;
                    $objPregunta->id = $fila['id Pregunta'];
                    $objPregunta->enunciado = $fila['Pregunta'];
                    $objPregunta->recurso = $fila['recurso'];
                    $objPregunta->respuesta = $fila['respuestaCorrecta'];
                    $objPregunta->idTematica = $fila['tematica'];
                    $objPregunta->tematica = $fila['nombre'];
                    $object->preguntas[] = $objPregunta;
                }
            return json_encode($object);
        }

        //Temática

        //Rol
        public static function miraRol(String $correo){
            DB::conexion("proyecto");

            $sql ="select rol from proyecto.persona where email = '${correo}' ";
            $peticion = self::$con->prepare($sql);
            $peticion->execute();
            $resultado = $peticion->fetch(PDO::FETCH_ASSOC);
        return implode(",",$resultado);
        }

        //Preguntas y Respuestas
        public static function sacaMaxId($nombreTabla){
            DB::conexion("proyecto");
            $sql = "SELECT 
                        column_name as PRIMARYKEYCOLUMN
                        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
                        
                        INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
                            ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                            AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
                            AND KU.table_name=\"${nombreTabla}\"
                        where tc.table_schema = \"proyecto\" 
                        and tc.TABLE_NAME=\"${nombreTabla}\";";

            $peticion = self::$con->prepare($sql);
            $peticion -> execute();
            $PK = $peticion->fetch(PDO::FETCH_ASSOC);
            $sql ="select max(`{$PK["PRIMARYKEYCOLUMN"]}`) as 'MaxID' from proyecto.${nombreTabla}";
            $peticion = self::$con->prepare($sql);
            $peticion->execute();
            $resultado = $peticion->fetch(PDO::FETCH_ASSOC);
            return $resultado['MaxID'];
        }

        //Examen
        public static function sacaPreguntasExamen($idExamen){
            DB::conexion("proyecto");
            $sql ="select `id Pregunta` as 'Pregunta', recurso as 'Recurso' from proyecto.Preguntas where `id Pregunta` in (select idPreguntas from examenpreguntas where idExamen = ${idExamen} )";
        
            $peticion = self::$con->prepare($sql);
            $peticion->execute();
            $resultado= $peticion->fetchAll(PDO::FETCH_NUM);

            return $resultado;
        }
        public static function sacaRespuestasPregunta($idPregunta){
            DB::conexion("proyecto");
            $sql ="select respuesta as 'Respuesta' from proyecto.respuestas where PreguntaRespuesta = ${idPregunta}";
            $peticion = self::$con->prepare($sql);
            $peticion->execute();
            $resultado = $peticion->fetchAll(PDO::FETCH_NUM);
            return $resultado;
        }

}