window.addEventListener("load", function(){

    const tablas = this.document.getElementsByTagName("table");
    const listaPreguntas = tablas[0].tBodies[0];
    const selectedPreguntas = tablas[1].tBodies[0];
    const preguntas = listaPreguntas.children;

    rellenaPreguntas();

    function rellenaPreguntas(){
    const ajax = new XMLHttpRequest;

        ajax.onreadystatechange = function () {
          if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(ajax.responseText);
            if (respuesta.preguntas.length > 0) {
              for (let i = 0; i < respuesta.preguntas.length; i++) {
                var fila = crearContenido(respuesta.preguntas[i]);
                listaPreguntas.appendChild(fila);
              }
            }
          }}
          ajax.open("POST", "admin/examen/methods/sacapreguntas.php");
          ajax.send();
        }



        function crearContenido(mensaje){
          //const filaMovil = document.createElement("div");

          const fila = document.createElement("tr");
          fila.style.cursor="pointer";
          fila.setAttribute("draggable", true);
          //fila.setAttribute("ondragstart",dragStart());
          //fila.setAttribute("ondrag",dragging());
          //filaMovil.setAttribute("ondrop", drop());
          //filaMovil.setAttribute("ondragover", "true");
          const enunciado = document.createElement("td");
          enunciado.style.cursor="pointer";
          enunciado.style.paddingLeft="3vh"
          enunciado.style.textAlign="justify";
          enunciado.style.width ="30vw";
          enunciado.innerHTML = mensaje.enunciado;
          const tematica = document.createElement("td");
          tematica.innerHTML = mensaje.tematica;
          tematica.style.textAlign="center";  
          //filaMovil.appendChild(fila);
          fila.appendChild(enunciado);
          fila.appendChild(tematica);
  
          return fila;
      }

      //Estilo tabla cargada
      for( i = 0; i < preguntas.length; i++){
        preguntas[i].addEventListener("dragstart", function(){
          console.log("comienza drag");
        });
      }
      selectedPreguntas.addEventListener("dragenter", function(){
        console.log("drag entra");
      });
   /*   for( i = 0; i < preguntas.length; i++){
        preguntas[i].ondragstart=function(ev){
          ev.preventDefault();
          ev.dataTransfer.setData("text", ev.target.id);
        }

        preguntas[i].ondragover=function(ev){
          ev.preventDefault();
        }

        preguntas[i].ondrop=function(ev){
          ev.preventDefault();
          const id=ev.dataTransfer.getData("text");
          ev.target.parentNode.appendChild(document.getElementById(id));
        }
      }

      listaPreguntas.ondragover=function(ev){
        debugger;
        ev.preventDefault();
      }

      listaPreguntas.ondrop = function(ev){
        ev.preventDefault();
        const id = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(id));
      }

      selectedPreguntas.ondragover=function(ev){
        ev.preventDefault();
      }

      selectedPreguntas.ondrop = function(ev){
        debugger
        ev.preventDefault();
        const id = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(id));
      }
*/

   /*   //Metodos tabla cargada
      function dragStart(event) {
        event.dataTransfer.setData("Text", event.target.id);
      }
      
      function dragging(event) {
        document.getElementById("demo").innerHTML = "The p element is being dragged";
      }
      
      function allowDrop(event) {
        event.preventDefault();
      }
      
      function drop(event) {
        event.preventDefault();
        var data = event.dataTransfer.getData("Text");
        event.target.appendChild(document.getElementById(data));
        document.getElementById("demo").innerHTML = "The p element was dropped";
      }*/
});
