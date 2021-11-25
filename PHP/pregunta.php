<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/Proyecto 1trimestre/PHP/respuesta.php";

    class Pregunta{

        /*Datos*/

        protected $id;
        protected $enunciado;
        protected $recurso;
        protected $respuestaCorrecta;
        protected $tematica;


        /*Metodos mágicos*/

        public function __get($atributo) { 
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function __construct($row) {
            $this->id = $row['id'];
            $this->enunciado = $row['enunciado'];
            $this->recurso = $row['recurso'];
            $this->tematica = $row['tematica'] = new Tematica;
            $this->respuestaCorrecta = $row['respuestaCorrecta'] = new Respuesta;
        }
    }