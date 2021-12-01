<?php
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";

    class preguntasExamem{

            /*Datos*/

        protected  $idExamen;
        protected  $idPregunta;

            /*Metodos mágicos*/

        public function __get($atributo) { 
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function __construct($row) {
            $this->idExamen = $row['idExamen'] = new Examen;
            $this->idPregunta = $row['idPregunta'] = new Pregunta;        
        }
    }