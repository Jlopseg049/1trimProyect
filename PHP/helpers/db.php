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

        public static function sacaLista(String $nombreTabla){
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
                $sql="select idExamen, descripcion, nPreguntas, duracion from proyecto.${nombreTabla}";
            }else
            if(DB::miraRol($_SESSION["login"]) == 1 && $nombreTabla == "examenHecho"){
                $sql="SELECT e.fecha, e.calificacion FROM proyecto.examenHecho e inner join proyecto.persona p on
                e.idPersona = p.idPersona;";
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
        $peticion = self::$con->prepare($sql);
        if($peticion -> execute() == true)
        {   

            if ($valor[0] == "persona") {
                $value  = rand(0,50000000000000);
                $value .= "----";
                $fecha  = date(DATE_RFC2822);
                $fecha .= "----";
                $hash = md5($value.$fecha);
            $sql ="insert into proyecto.resgistropendiente(correoPendiente, hash)
                values(" . 
                    $valor[1] . "," . $hash.")";
                    $peticion = self::$con->prepare($sql);
                    $peticion -> execute(); 





            //Correo registro
            require "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/vendor/autoload.php";

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
            $mail->AltBody = "Usted no admite html en un correo pero le informo que Jesús López Segura le ha hablado.";
            // destinatario
            $address = $valor[1] ;
            var_dump(PHPMailer::validateAddress('javi.cazalla@gmail.com'));
            $mail->AddAddress($_POST);
            // enviar
            $resul = $mail->Send();
            if(!$resul) {
            echo "Error" . $mail->ErrorInfo;
            } else {
            echo "Enviado";
            }
        }
        print_r($valor);}
        else{
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

        // Comprobamos que el usuario y contraseña se encuentran en nuestra BD
        public static function Existeusuario(String $usuario, String $contrasena){
            $sql = "SELECT email, contrasena FROM proyecto.persona
                            where email like '${usuario}'";
            $resultado = self::$con->query($sql);
            if($resultado){ 
                while($fila = $resultado->fetch()){
                    if($fila["email"] == $usuario && $fila["contrasena"] == $contrasena){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
                return false;
        }


        //Examen
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
            $sql ="select rol from proyecto.persona where email = '${correo}'";
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