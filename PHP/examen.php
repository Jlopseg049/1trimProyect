<?php
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

<<<<<<< HEAD
        public static function sacaPreguntas(){
           return DB::sacaPreguntas();
=======
        public static sacaPreguntas(){
           return DB::SacaRespuestasPorPregunta();
>>>>>>> db1869e6cdc39237d857d5959ce5fdb9aefb5f00
        }
    }