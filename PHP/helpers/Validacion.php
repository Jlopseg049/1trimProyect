<?php
class Validacion
{
    //Array de errores
    private static $errores;

    //Constructor
    public function __construct()
    {
        $this->errores=array();
    }

    /**
     * Comprueba si esta vacio
     *
     * @param [type] $campo
     * @return boolean
     */ 
    public static function Requerido($campo)
    {
        
        if(!isset($_POST[$campo]) || empty($_POST[$campo]))
        {
            self::$errores[$campo]="El campo $campo no puede estar vacio";
            return false;
        }
        return true;
    }

    /**
     * Método que comprueba que el campo es un valor entero
     * y de manera opcional un rango de valores
     *
     * @param [String] $campo
     * @param [int] $min
     * @param [int] $max
     * @return boolean
     */
    public static function EnteroRango($campo,$min=PHP_INT_MIN,$max=PHP_INT_MAX)
    {
        if(!filter_var($_POST[$campo],FILTER_VALIDATE_INT,
            ["options"=>["min_range"=>$min,"max_range"=>$max]]))
        {
            self::$errores[$campo]="Debe ser entero entre $min y $max";
            return false;
        }
        return true;
    }

    /**
     * Método que comprueba el número de caracteres de la cadena
     * entre un mínimo y un máximo
     *
     * @param [String] $campo
     * @param [integer] $max
     * @param integer $min
     * @return boolean
     */
    public static function CadenaRango($campo,$max,$min=0)
    {
        if(!(strlen($_POST[$campo])>$min && strlen($_POST[$campo])<$max))
        {
            self::$errores[$campo]="Debe tener entre $min y $max caracteres";
            return false;
        }
        return true;

    }

    /**
     * Comprueba si el campo es un email válido
     *
     * @param [String] $campo
     * @return boolean
     */
    public static function Email($campo)
    {
        if(filter_var($campo,FILTER_VALIDATE_EMAIL))
        {
            return true;
        }else{
            self::$errores[$campo]="Debe ser un email válido";
            return false; 
        }
    }

    public static function EmailExiste($campo){
        
        if(Validacion::Email($campo)  &&  DB::existeEmail($campo)){
            return true;
        }else{
            self::$errores[$campo]="Su correo es inválido o no se encuentra en nuestras base de datos. <br>
                                    Si no está registrado, <br>
                                    contacte con alguno de nuestros profesores para darle de alta.<br>
                                    En caso contrario, vuelva a intentarlo.";
            return false; 
        }
    }
    public static function Contrasena($password){
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        if(!$uppercase || !$lowercase || !$number || strlen($password) < 5) {
            return false;
        }else{
            return true;
        }
    }
    public static function Dni($campo)
    {
        $letras="TRWAGMYFPDXBNJZSQVHLCKE";
        $mensaje="";
        if(preg_match("/^[0-9]{8}[a-zA-z]{1}$/",$_POST[$campo])==1)
        {
            $numero=substr($_POST[$campo],0,8);
            $letra=substr($_POST[$campo],8,1);
            if($letras[$numero%23]==strtoupper($letra))
            {
                return TRUE;
            }
            else
            {
                $mensaje="El campo $campo es un Dni con letra no válida";
            }
        }
        else
        {
            $mensaje="El campo $campo no es un Dni válido";
        }
        self::$errores[$campo]=$mensaje;
        return FALSE;
    }

    /**
     * Comprueba si el campo cumple una expresión regular (patrón)
     *
     * @param [string] $campo
     * @param [string] $patron
     * @return boolean
     */
    public static function Patron($campo,$patron)
    {
        if(!preg_match($patron,$_POST[$campo]))
        {
            self::$errores[$campo]="No cumple el patrón $patron";
            return false;
        }
        return true;
    }

    /**
     * Ejecuta una función que será la encargada de validar el campo
     *
     * @param [type] $campo
     * @param [type] $funcion
     * @param [type] $mensaje
     * @return boolean
     */
    public static function ValidaConFuncion($campo,$funcion,$mensaje)
    {
        if(!call_user_func($funcion))
        {
            self::$errores[$campo]=$mensaje;
            return false;
        }
        return true;
    }

    /**
     * Comprueba si hay errores
     *
     * @return void
     */
    public static function ValidacionPasada()
    {
        if(count(self::$errores)!=0)
        {
            return false;
        }
        return true;
    }

    public static function ImprimirError($campo)
    {
        return
        isset(self::$errores[$campo])?'<span class="error_mensaje">'.self::$errores[$campo].'</span>':'';
    }

    public static function getValor($campo)
    {
        return
        isset($_POST[$campo])?$_POST[$campo]:'';
    }

    public static function getSelected($campo,$valor)
    {
        return
        isset($_POST[$campo]) && $_POST[$campo]==$valor?'selected':'';
    }

    public static function getChecked($campo,$valor)
    {
        return
        isset($_POST[$campo]) && $_POST[$campo]==$valor?'checked':'';
    }

}