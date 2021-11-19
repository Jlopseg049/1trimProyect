<?php

class User {

    /*Datos*/

    protected $id;
    protected $nombre;
    protected $ap1;
    protected $ap2;
    protected $email;
    protected $password;
    protected $fechaNac;
    protected $rol;
    protected $activo;

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
        $this->name = $row['name'];
        $this->rol = $row['rol'];
        $this->activo = $row['activo'];
        
    }
}