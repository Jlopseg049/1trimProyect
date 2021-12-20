var Examen =  sacaExamen(getParameterByName("id"));
sacaExamen(getParameterByName("id")).then((datosTabla)=>  Examen = datosTabla);

     async function sacaExamen(id){
        return new Promise((resolve, reject) => {
            const ajax = new XMLHttpRequest;  
            ajax.onreadystatechange = function () {
              if (ajax.readyState == 4 && ajax.status == 200) {
            datosTabla = JSON.parse(ajax.responseText);
            resolve(datosTabla);
              }
            }
              ajax.open("POST", "listados/methods/sacaExamen.php?id=" + id);
              ajax.send();
        });

      };

      function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
      }

      async function corrigeExamenf(id){
        return new Promise((resolve, reject) => {
            const ajax = new XMLHttpRequest;  
            ajax.onreadystatechange = function () {
              if (ajax.readyState == 4 && ajax.status == 200) {
            datosTabla = JSON.parse(ajax.responseText);
            resolve(datosTabla);
              }
            }
              ajax.open("POST", "examen/methods/corrigeExamen.php?id=" + id);
              ajax.send();
        });
    }

//Construimos un ejemplo de la estructura de un examen
const Examen2 ={
    //Duración de examen en minutos
    id : 1,
    duracion : 30,
    descripcion: "Examen de Seguridad Vial Tema 1",
    preguntas : [
        { 
            enunciado : "Cuanto vale 1 Kg de sandías.",
            recurso : "../Recursos/Preguntas/Un1.svg.png",
            respuestas : {
                a : 1 + "€",
                b : "Para que quieres saber eso",
                c : "Gratis si corres mucho",
                d : "Es un secreto"
            }
        },
        { 
            enunciado : "¿Sabías que para hacer esta pregunta ningún animal salió herido?",
            recurso : "../recursos/preguntas/no-image.png", 
            respuestas : {
                a : "Sí",
                b : "No",
                c : "Te denunciaré por maltrato animal para quitarme de dudas",
                d : "ª"
            }
        },
         { 
            enunciado : "¿Cuál es el límite de velocidad permitido al viajar a traves de una " +
                         "carretera rural?",
            recurso : "../recursos/preguntas/no-image.png", 
            respuestas : {
                a : "Si se oyen disparos, tanta como mi motor me permita.",
                b : "20 km/h.",
                c : "No sé, anoche en vez de estudiar estaba de botellón.",
                d : "¿Cuenta si voy en bici?",
            }
        },
         { 
            enunciado : "La correcta es la c.",
            recurso : "../recursos/preguntas/no-image.png", 
            respuestas : {
                a : "Más abajo.",
                b : "Casi llegas, un poco mas abajo.",
                c : "Esta es.",
                d : "¿De verdad hace falta que te diga que la respuesta esta más arriba?"
            }
        }
    ]
};
const RespuestasCorrectas = ["a", "a", "b", "c"];   
//Variables



//carga
window.addEventListener("load", function () {
    minutos = parseInt(Examen.duracion);
segundos = 0;
    

    const main = document.getElementsByTagName("main")[0];
    const resultadoExamen = document.createElement("div");

    const boton = document.createElement("button");
    boton.setAttribute("id", "finalizar");
    boton.innerHTML="Finalizar";
    boton.addEventListener("click", corrigeExamen);

    muestraExamen();
    cargaSegundo();

    function muestraExamen(){

        cabeceraExamen = [];
        cabeceraExamen.push(
            `<header>
                <div id ="Descripcion">
                    ${Examen.descripcion}
                <div>
                <div class = "Temporizador"> 
                    <span id ="minutos">${Examen.duracion}:</span>
                    :
                    <span id ="segundos">${segundos}</span>
                </div>
            <header>`);

        cuerpoExamen = [];
        //Insertamos las preguntas
            Examen.preguntas.forEach((PreguntaActual, nPregunta) => {
            const respuestas = [];
            //Por cada pregunta, recorremos sus respuestas
            for(letraRespuestas in PreguntaActual.respuestas){
                respuestas.push(
                    `<label>
                        <span>${PreguntaActual.respuestas[letraRespuestas]} </span> 
                        <input type = "radio" value="${PreguntaActual.idrespuestas[letraRespuestas]}" name = "Pregunta ${nPregunta}" /> 
                    </label>` 
                );
            }
            cuerpoExamen.push(
                `<article class = "pregunta">
                    <article class = "enunciado">
                        ${PreguntaActual.enunciado}
                    </article>
                    <article class="respuestasImagen">
                        <img src="${PreguntaActual.recurso}" width="250" height ="200"/>

                            <article class = "respuestas">

                             ${respuestas.join('')}
                        </article>
                    </article>
                 </article>`
            );
        });
        main.innerHTML += cabeceraExamen.join("");
        main.innerHTML += cuerpoExamen.join("");
  

        main.appendChild(boton);
        
    }
    //Temporizador
    //Segundos
    function cargaSegundo(){
        let txtSegundos;

        if (segundos < 0) {
            segundos = 59;
        }

        //Mostrar segundos en pantalla
        if (segundos < 10) {
            txtSegundos = 0 + segundos + "";
        }else{
            txtSegundos = segundos;
        }
        document.getElementById("segundos").innerHTML = txtSegundos;
        segundos --;
        cargaMinuto(segundos)
    }

    //Minutos
    function cargaMinuto(){
        let txtMinutos;

        //Para este temporizador al no usarse las horas, 
        //no debemos reiniciar los minutos a 59 cuando llega al final
        if (segundos == -1 ) {
            setTimeout(() =>{
                minutos--
            },500)
        }
        //Si se acaba el tiempo, corregimos el examen
        if(minutos == 0 && segundos == -1){
            clearInterval(interSegundos);
            corrigeExamen();
            minutos = 0 ;
            segundos =0;

        }
        if (minutos < 10) {
            txtMinutos = 0 + minutos + "";
        }else{
            txtMinutos = minutos;
        }
        document.getElementById("minutos").innerHTML = txtMinutos;
        
    }
    const interSegundos = setInterval(cargaSegundo, 1000);

    //Corrección
function corrigeExamen(){

        clearInterval(interSegundos);

        //Tomaremos las respuestas para recorrerlas una por una y comparar si es correcto o no,
        //si la respuesta está sin responder, contara como incorrecta.
        const respuestas = main.getElementsByClassName("respuestas");
        let aciertos = 0;
        respuestasElegidas = []
        Examen.preguntas.forEach((PreguntaActual, nPregunta)=>{
            //Tomamos los inputs
            const todasLasRespuestas = respuestas[nPregunta];

            //Quiero comprobar todas aquellas respuestas que tienen el atributo checked pero no 
            //encuentro otra manera de hacerlo que no sea a través del QuerySelector ya que 
            //getElementsByTagName.getAttribute no funciona cuando seleccionas un grupo
            var respuestaElegida = (todasLasRespuestas.querySelector(`input[name = "Pregunta ${nPregunta}"]:checked`) || {}).value;
                    //Ponemos {} para elegir tambien las preguntas vacias
                respuestasElegidas.push(respuestaElegida);
            });
            enviaExamen(respuestasElegidas);
            document.location.href = '/Proyecto%201trimestre/views/logued.php?p=Listados/lista&t=examenHecho';

    }


function enviaExamen(mensajes){
    formulario = new FormData();
    formulario.append("idExamen", Examen.id);
    formulario.append("calificacion", mensajes);
    formulario.append("ejecucion", document.getElementsByTagName("html")[0].outerHTML);
    const ajax = new XMLHttpRequest;  

      ajax.open("POST", "examen/methods/enviaExamen.php");
      ajax.send(formulario);
  };
  
});