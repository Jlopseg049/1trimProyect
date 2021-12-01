window.addEventListener("load", function(){

    const tablas = this.document.getElementsByTagName("table");
    const cabecera = tablas[0].tHead;
    const lista = tablas[0].tBodies[0];


    sacaLista();

    function sacaLista(){
            
    const ajax = new XMLHttpRequest;

        ajax.onreadystatechange = function () {
          if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(ajax.responseText);
            if (respuesta.resultado.length > 0) {
                var filaCabecera = creaLista(respuesta.cabecera, "cabecera");
              cabecera.appendChild(filaCabecera);
              for (let i = 0; i <respuesta.resultado.length; i++) {
                var fila = creaLista(respuesta.resultado[i], "lista", respuesta.tabla);
                lista.appendChild(fila);
              }
            }
          }}
          ajax.open("POST", "listados/methods/sacaLista.php");
          ajax.send();
        }
    });

    //Metodos para pintar
    
    function creaLista(datos, tipo = "lista", tabla = "") {
      const fila = document.createElement("tr");
      const celdas = [];
      for (let i = 0; i <datos.length; i++) {
        if (tipo == "cabecera") {
          celdas[ "celda" + i ] = document.createElement("th");

        }else if(tipo == "lista"){
          celdas[ "celda" + i ] = document.createElement("td");

        } 
           celdas[ "celda" + i ].innerText = datos[i];
          fila.appendChild(celdas[ "celda" + i ]);
      }
      if (tipo == "cabecera") {
        celdas[" celda" + datos.length + 1] = document.createElement("th")
        celdas[" celda" + datos.length + 1].innerText = "Opciones"
      }else if(tipo == "lista"){
        celdas[" celda" + datos.length + 1] = document.createElement("td")
        enlaces = [];
        enlaces["enlace 1"] = document.createElement("a");
        enlaces["enlace 1"].innerText="Editar";

        enlaces["enlace 2"] = document.createElement("a");
        enlaces["enlace 2"].innerText="Desactivar";

        enlaces["enlace 3"] = document.createElement("a");
        enlaces["enlace 3"].innerText="Borrar";
        celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 1"]);
        celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 2"]);
        celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 3"]);

      }
      fila.appendChild(celdas[" celda" + datos.length + 1]);
      return fila;
    }
