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

          const fila = document.createElement("tr");
          fila.style.cursor="pointer";
          fila.setAttribute("draggable", true);

          const id = document.createElement("td");
          id.innerHTML =mensaje.id;
          id.style.display="none";

          const enunciado = document.createElement("td");
          enunciado.style.cursor="pointer";
          enunciado.style.paddingLeft="3vh";
          enunciado.style.textAlign="justify";
          enunciado.style.width ="20vw";
          enunciado.style.textAlign="center";  
          enunciado.innerHTML = mensaje.enunciado;

          const tematica = document.createElement("td");
          tematica.innerHTML = mensaje.tematica;
          tematica.style.textAlign="center"; 
           
          fila.appendChild(id);
          fila.appendChild(enunciado);
          fila.appendChild(tematica);

          fila.id=mensaje.id;
          fila.addEventListener("dragstart", function(){
            event.dataTransfer.setData('id', event.target.id);
            console.log(event.dataTransfer.getData('id'));
          });
          return fila;
      }

      //Estilo tabla cargada
      for (let i = 0; i < tablas.length; i++) {
        tablas[i].addEventListener("dragover", function(){
          event.preventDefault();
        });
    }
    tablas[0].addEventListener("drop", function(){
      const id = event.dataTransfer.getData('id');
      document.getElementById(id).children[0].style.display="none";
      tablas[0].appendChild(document.getElementById(id));
  });
    tablas[1].addEventListener("drop", function(){
      const id = event.dataTransfer.getData('id');
      document.getElementById(id).children[0].style.removeProperty('display');
      tablas[1].appendChild(document.getElementById(id));
  });
});
