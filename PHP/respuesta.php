<?php
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadClases.php";
 require_once "{$_SERVER["DOCUMENT_ROOT"]}/proyecto 1trimestre/PHP/autoloadHelpers.php";
    class Respuesta{

            /*Datos*/

        protected $idRespuesta;
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
            $this->idRespuesta = $row['idRespuesta'];
            $this->enunciadoRespuesta = $row['enunciadoRespuesta'];
            $this->idPregunta = $row['idPregunta'];           
        }


            /*Métodos*/

        // public static function MuestraExamenPreguntas(){
        //     $respuestas = array(DB::SacaPreungtas);
        //     $RespuestasPorPregunta = array();
        //     foreach ($respuestas as $respuesta => $preguntaResponder){
        //         $RespuestasPorPregunta  [$preguntaResponder[$this->$idPregunta->__get('idRespuesta')];
        //                                 [$respuesta] = $preguntaResponder[$this->$idRespuesta];
        //     }
            
        // }

        // foreach ($respuestas as $k => &$pregunta) {
        // $preguntaRespuestas[$pregunta['idpregunta']][$k] = $pregunta['idrespuesta'];
        // }
    }