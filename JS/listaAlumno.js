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
                var filaCabecera = creaLista(respuesta.cabecera, "cabecera", respuesta.tabla);
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
      debugger
      const fila = document.createElement("tr");
      if(tipo == "lista"){fila.setAttribute("id", tabla + "_" + datos[0]);}
      const celdas = [];
      if (tabla == "examenHecho"){ i = 0 }
          else{ i = 1 } 
        for (i ; i <datos.length; i++) {
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
        celdas[" celda" + datos.length + 1] = document.createElement("td");
        celdas[" celda" + datos.length + 1].style.display ="grid";

          celdas[" celda" + datos.length + 1].style.setProperty('grid-template-columns','repeat(1, 1fr)');

    

        enlaces = [];
        enlaces["enlace 1"] = document.createElement("a");
        enlaces["enlace 1"].innerText="Editar";
        enlaces["enlace 1"].setAttribute('href','?p=formulario/form&e=edit&id='+datos[0]);
/*
        activar = false;
        for (let i = 0; i <datos.length; i++) {
          if (datos[i].innerText == "Activo") {
            activar = true; 
                      enlaces["enlace 2"].innerText="activar";

          }
        }

        */
       if (tabla == "examenHecho") {
        enlaces["enlace 2"] = document.createElement("a");
        enlaces["enlace 2"].innerText="Revisar";
       }
       if (tabla == "examen") {
        enlaces["enlace 2"] = document.createElement("a");
        enlaces["enlace 2"].innerText="Hacer";
        enlaces["enlace 2"].addEventListener("click", function(){
          
        });
       }



if (tabla == "examenHecho") {celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 1"]);}
if (tabla == "examen") {     celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 2"]);}

      }
      fila.appendChild(celdas[" celda" + datos.length + 1]);
      return fila;
    }

