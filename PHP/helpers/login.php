<?php
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
          class Login
    {
        public static function Identifica(string $usuario,string $contrasena,bool $recuerdame = false)
        { 
            if(self::Existeusuario($usuario,$contrasena))
            {
                Sesion::iniciar();
                if(Sesion::existe('login')){
                    Sesion::eliminar('login');
                    Sesion::escribir('login',$usuario); 
                }else{
                    Sesion::escribir('login',$usuario); 
                }
                if($recuerdame)
                {
                    setcookie('recuerdame',$usuario,time()+30*24*60*60);
                }
                return true;
            }
            return false;
        }
    
        private static function ExisteUsuario(string $usuario,string $password=null)
        {
            DB::conexion("proyecto");
           return DB::Existeusuario($usuario,$password);
        }
    
        public static function UsuarioEstaLogueado()
        {
            if(Sesion::leer('login'))
            {
                return true;
            }
            elseif(isset($_COOKIE['recuerdame']) && self::ExisteUsuario($_COOKIE['recuerdame']))
            {
                Sesion::iniciar();
                Sesion::escribir('login',$_COOKIE['recuerdame']);
                return true;
            }
            return false;
        }
        public static function Registro (Usuario $usuario)
        {
            if(self::Existeusuario($usuario->__get("email"),$usuario->__get("password"))==true)
            {

                return "Usuario ya registrado";
            }
            return DB::nuevoUsuario($usuario);
        }
    }