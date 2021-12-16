<?php
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";

    class Pregunta{

        /*Datos*/

        protected $id;
        protected $enunciado;
        protected $recurso;
        protected $respuestaCorrecta;
        protected $tematica;
        protected $respuestas;

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
            $this->respuestas =$row['respuestas'];
            $this->recurso = $row['recurso'];
            $this->tematica = $row['tematica'];
            $this->respuestaCorrecta = $row['respuestaCorrecta'];

        }
    }