<?php

class Persona {

    /*Datos*/

    protected $id ="";
    protected $nombre;
    protected $ap1;
    protected $ap2;
    protected $email;
    protected $password;
    protected $fechaNac;
    protected $foto;
    protected $activo;
    protected $rol;

    /*Metodos mágicos*/

    public function __get($atributo) { 
        return $this->$atributo;
    }
    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function __construct($row) {
        $this->id = $row['id'];
        $this->nombre = $row['nombre'];
        $this->ap1 = $row['ap1'];
        $this->ap2 = $row['ap2'];
        $this->email = $row['email'];
        $this->password= $row['password'];
        $this->fechaNac = $row['fechaNac'];
        $this->foto = $row['foto'];
        $this->rol = $row['rol'];
        $this->activo = $row['activo'];
        
    }
}