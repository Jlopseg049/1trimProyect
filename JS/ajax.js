window.addEventListener("load", function(){

    const tablas = this.document.getElementsByTagName("table");
    const listaPreguntas = tablas.children[0];
    const selectedPreguntas = tablas.children[1];

    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
        var respuesta = JSON.parse(ajax.responseText);
        if (respuesta.mensajes.length > 0) {
            for (let i = 0; i < respuesta.mensajes.length; i++) {
            var div = crearContenido(respuesta.mensajes[i], usuario.value);
            if (
                contenedor.scrollHeight - contenedor.scrollTop <
                contenedor.clientHeight + 10
            ) {
                contenedor.appendChild(div);
                contenedor.scrollTop = contenedor.scrollHeight;
            } else {
                contenedor.appendChild(div);
            }
            }
        }
        ultimo = respuesta.ultimo;
        }
    }
        ajax.open("post", "include/pedir.php?ultimo=" + ultimo);
        ajax.send();
      });