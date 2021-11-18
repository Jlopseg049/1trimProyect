<?php
    require_once "../persona.php";
    require_once "Sesion.php";
    require_once "../../DB/db.php";
    class Login
    {
        public static function Identifica(string $usuario,string $contrasena,bool $recuerdame)
        {
            if(self::Existeusuario($usuario,$contrasena))
            {
                Sesion::iniciar();
                Sesion::escribir('login',$usuario); 
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
            DB::conecta();
           return DB::existeusuario($usuario,$password);
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
    }