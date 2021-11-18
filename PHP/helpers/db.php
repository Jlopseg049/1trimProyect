<?php

    class DB{

        // Creamos e iniciamos la conexion

        protected static $con;
        
        public static function conexion(){

            //Preparamos las opciones de nuestra conexión para una mejor legibilidad
            $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            self::$con = new PDO('mysql:host=localhost;dbname=tienda', 'root', '', $opciones);
        }

        
        // Para probar la conexion usar
        //  
        //   echo 'Conectado a '.self::$con->getAttribute(PDO::ATTR_CONNECTION_STATUS);


        //Registraremos el usuario con los datos proporcionados
        public static function nuevoUsuario(Usuario $user){
            $sentencia="INSERT INTO tienda.users (id,Nombre, 'Apellido 1', 'Apellido 2', 
                                                  Password, Correo, Roles)
                                        VALUES   (:id,Nombre, :ap1, :ap2, 
                                                  :Password, :Correo, :Rol)";
            //Montamos la sentencia y asignamos los datos clave->valor
            $resultado = self::$con->prepare($sentencia);
            $resultado->bindParam(":id", $user->__get("id"));
            $resultado->bindParam(":Nombre", $user->__get("Nombre"));
            $resultado->bindParam(":ap1", $user->__get("ap1"));
            $resultado->bindParam(":ap2", $user->__get("ap2"));
            $resultado->bindParam(":Password", $user->__get("Password"));
            $resultado->bindParam(":Correo", $user->__get("Correo"));
            $resultado->bindParam(":Rol", $user->__get("Rol"));

            //Ejecutamos la sentencia preparada
            $resultado->execute();


        }

        // Comprobamos que el usuario y contraseña se encuentran en nuestra BD
        public static function existeUsuario(String $usuario, String $contrasena){
            $sentencia = "SELECT Nombre, Password from tienda.users 
                            where nombre like '${usuario}'";
            $resultado = self::$con->query($sentencia);
            while($fila = $resultado->fetch()){
                if($fila["Nombre"] == $usuario && $fila["Password"] == $contrasena){
                    return true;
                }else{
                    return false;
                }
            }


        }
    }
    