window.addEventListener("load", function(){

    const tablas = this.document.getElementsByTagName("table");
    const listaPreguntas = tablas[0].tBodies[0];
    const selectedPreguntas = tablas[1].tBodies[0];

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
          fila.setAttribute("draggable", true);
          const enunciado = document.createElement("td");
          enunciado.style.width ="400px"
          enunciado.innerHTML = mensaje.enunciado;
          const tematica = document.createElement("td");
          tematica.innerHTML = mensaje.tematica;
          fila.appendChild(enunciado);
          fila.appendChild(tematica);
  
          if (mensaje.foto !=null) {
              const div5 = document.createElement("div"); 
              const foto = document.createElement("img");
              imagen=new Image();
              imagen.src='data:image/png;base64,'+mensaje.foto;
              imagen.style.width="300px";
              imagen.style.heigth="300px";
              div5.className = "foto";
              div5.appendChild(imagen);
              div1.appendChild(div5);
          }
          return fila;
      }
});
