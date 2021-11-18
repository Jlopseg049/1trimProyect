<?php
    class Respuesta{

            /*Datos*/

        protected $id;
        protected $enunciadoRespuesta;
        protected $idPregunta;

            /*Metodos mágicos*/

        public function __get($atributo) { 
            return $this->$atributo;
        }
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function __construct($row) {
            $this->id = $row['id'];
            $this->enunciadoRespuesta = $row['enunciadoRespuesta'];
            $this->idPregunta = $row['idPregunta'];           
        }
        $respuestas = select ...;
        $preguntaRespuestas=array();
        foreach ($respuestas as $k => &$pregunta) {
        $preguntaRespuestas[$pregunta['idpregunta']][$k] = $pregunta['idrespuesta'];
    }
    }