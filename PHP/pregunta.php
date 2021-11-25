<?php
    require_once "{$_SERVER["DOCUMENT_ROOT"]}/Proyecto 1trimestre/PHP/respuesta.php";

    class Pregunta{

        /*Datos*/

        protected $id;
        protected $enunciado;
        protected $recurso;
<<<<<<< HEAD
        protected $respuestaCorrecta;
        protected $tematica;
=======
        protected Respuesta $respuestaCorrecta;
        protected Tematica $tematica;
>>>>>>> db1869e6cdc39237d857d5959ce5fdb9aefb5f00


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
<<<<<<< HEAD
            $this->tematica = $row['tematica'] = new Tematica;
            $this->respuestaCorrecta = $row['respuestaCorrecta'] = new Respuesta;
=======
            $this->tematica = $row['tematica'];
            $this->respuestaCorrecta = $row['respuestaCorrecta'];
>>>>>>> db1869e6cdc39237d857d5959ce5fdb9aefb5f00
        }
    }