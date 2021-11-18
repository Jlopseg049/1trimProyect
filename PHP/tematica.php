<?php   
    class Tematica{

            /*Datos*/
            
        protected $id;
        protected $nombre;

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
        }
    }