<?php

    require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/helpers/db.php";
    class Examen{

            /*Datos*/

        protected $id;
        protected $descripcion;
        protected $duracion;
        protected $nPreguntas;
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
            $this->descripcion = $row['descripcion'];
            $this->duracion = $row['duracion'];
            $this->nPreguntas = $row['nPreguntas'];
            $this->activo = $row['activo'];           
        }   

        public static function sacaPreguntas(){
            DB::conexion("proyecto");
           return DB::sacaPreguntas();
        }
    }