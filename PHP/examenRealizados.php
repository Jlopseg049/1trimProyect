<?php
    class examenRealizados{

            /*Datos*/

        protected $idExamenHecho;
        protected $idExamen;
        protected $idPersona;
        protected $fecha;
        protected $calificacion;
        protected $ejecucion;

            /*Metodos mágicos*/

        public function __get($atributo) { 
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function __construct($row) {
            $this->idExamenHecho = $row['idExamenHecho'];
            $this->idExamen = $row['idExamen'];
            $this->idPersona = $row['idPersona'];
            $this->fecha = $row['fecha'];¡
            $this->calificacion = $row['calificacion'];
            $this->ejecucion= $row['ejecucion'];            
        }
    }