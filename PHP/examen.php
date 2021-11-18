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

        public function __construct($examen) {
            $this->idExamenHecho = $examen['id'];
            $this->idExamen = $examen['descripcion'];
            $this->duracion = $examen['duracion'];
            $this->nPreguntas = $examen['nPreguntas'];¡
            $this->activo = $examen['activo'];           
        }
    }