<?php

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


        //Sacar una lista para cualquier tabla

        public static function sacaLista(String $nombreTabla){
            if($nombreTabla == "persona"){
                $sql = "Select concat(nombre,' ',ap1,' ',ap2) as 'Nombre' ,
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

            return json_encode($object);
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

        //Con la intencion de sacar con mayor facilidad el id de un nuevo usuario, hare una consulta.
        //Este me sacara el id del proximo usuario
        public static function idNuevoUsuario(){
            $sql = "SELECT email, contrasena from proyecto.persona 
            where email like '${usuario}'";
            $resultado = self::$con->query($sql);
                while($fila = $resultado->fetch() ){
                }
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
                    $objPregunta->enunciado = $fila['enunciado'];
                    $objPregunta->recurso = $fila['recurso'];
                    $objPregunta->respuesta = $fila['respuestaCorrecta'];
                    $objPregunta->idTematica = $fila['tematica'];
                    $objPregunta->tematica = $fila['nombre'];
                    $object->preguntas[] = $objPregunta;
                }
            return json_encode($object);
        }

        //Temática
        public static function insertaTematica(){}

        //Rol
        public static function insertaRol(){}

}