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
                var buscador = creaBuscador(respuesta.tabla);
                tablas[0].parentElement.insertBefore(buscador ,tablas[0].parentElement.firstChild);


                var filaCabecera = creaLista(respuesta.cabecera, "cabecera");
              cabecera.appendChild(filaCabecera);
              for (let i = 0; i <respuesta.resultado.length; i++) {
                var fila = creaLista(respuesta.resultado[i], "lista", respuesta.tabla);
                lista.appendChild(fila);
              }
              lista.parentNode.appendChild(creatFoot(respuesta.tabla, respuesta.cabecera.length));
            }
          }}
          ajax.open("POST", "listados/methods/sacaLista.php");
          ajax.send();
        }
    });

    //Metodos para pintar
    function creaBuscador(tabla = null) {
      //La funcion de crear el formulario es simplemente para cumplir con el esquema de diseño
      form = document.createElement("form")
      label = document.createElement("label");
      label.setAttribute("name", "LbBuscador");
      label.setAttribute("for", "Buscador");

      span = document.createElement("span");
      span.innerText = "Buscador";

      const buscador = document.createElement("input");
      buscador.setAttribute("id", "Buscador");
      buscador.setAttribute("name", "Buscador");
      buscador.setAttribute("placeholder", "Buscar " + tabla + "...");
      label.appendChild(buscador);
      label.appendChild(span);
      form.appendChild(label);
      buscador.addEventListener("keyup",function (ev) {

        //Este bloque de codigo, lo conseguí buscando sobre la manera de llamar a un bucle
        //for each llamando a una coleccion como recoge getElementsByTagName() aunque entiendo su funcionamiento
        Array.prototype.forEach.call( document.getElementsByTagName("tr"), (filaActual, nFila) => {
          //Para saber si mostrar o no una fila, se me ocurre imitar lo que en lenguajes como C se conocen como Flag
          //y usar una variable que solo podrá entrar una vez por fila y si no entra se ocultará,
          //si encuentra es porque hay coincidencia de busqueda
          oculto = "espera"
          //Por cada fila llamamos a sus celdas y comprobamos los resultados
          Array.prototype.forEach.call( document.getElementsByTagName("tr")[nFila].children, 
              (celdaActual) => {
                if(nFila > 0){
;
                  //Ahora mi filtro no tiene en cuenta los acentos
                  if (quitarAcentos(celdaActual.innerText.toLowerCase()).
                  includes(ev.target.value.toLowerCase()) &&
                      oculto === "espera") {
                      oculto = "no";
                      
                      }
                  }
                });
                
            if (oculto === "espera" && nFila > 0 && document.getElementsByTagName("tr")[nFila].parentElement.tagName!=="TFOOT") {
              filaActual.style.setProperty("display","none");
            }else{
              filaActual.style.setProperty("display","table-row");
            }
          })
        });
      return form;
    }


    function quitarAcentos(cadena){
      
      const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
     
      return cadena.split('').map( letra => acentos[letra] || letra).join('').toString();	
    }

    function creaLista(datos, tipo = "lista", tabla = "") {
      const fila = document.createElement("tr");
      if(tipo == "lista"){fila.setAttribute("id", tabla + "_" + datos[0]);}
      const celdas = [];
        for (let i = 1; i <datos.length; i++) {
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
        if (tabla != "tematica") {
          celdas[" celda" + datos.length + 1].style.setProperty('grid-template-columns','repeat(3, 1fr)');
        }else{
          celdas[" celda" + datos.length + 1].style.setProperty('grid-template-columns','repeat(2, 1fr)');

        }

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
       if (tabla != "tematica") {
        enlaces["enlace 2"] = document.createElement("a");
        enlaces["enlace 2"].innerText="Desactivar";

        enlaces["enlace 2"].addEventListener("click", function(){
          idfila = fila.getAttribute("id").split("_");
            const ajax = new XMLHttpRequest;  
              window.location.reload();
        
              ajax.open("GET", "listados/methods/desactivaDatos.php?id="+idfila[1]);
              ajax.send();
          }
        );
       }
     
        enlaces["enlace 3"] = document.createElement("a");
        enlaces["enlace 3"].innerText="Borrar";

        if(tabla == "examen"){
          enlaces["enlace 3"].addEventListener("click",  function(){
            idfila = fila.getAttribute("id").split("_");
            const ajax = new XMLHttpRequest;  
              window.location.reload();

                ajax.open("GET", "listados/methods/quitaExamen.php?id="+idfila[1]);
                ajax.send();
            }
          );
        }else{
        enlaces["enlace 3"].addEventListener("click",  function(){
          idfila = fila.getAttribute("id").split("_");
          const ajax = new XMLHttpRequest;  
            window.location.reload();

              ajax.open("GET", "listados/methods/quitaDatos.php?id="+idfila[1]);
              ajax.send();
          }
        );
        }
                          celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 1"]);
if (tabla != "tematica") {celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 2"]);}
                          celdas[" celda" + datos.length + 1].appendChild(enlaces["enlace 3"]);

      }
      fila.appendChild(celdas[" celda" + datos.length + 1]);
      return fila;
    }

    function creatFoot(tabla, tamaño){
      helloPie = document.createElement("tfoot");
        helloFilaPie = document.createElement("tr");
          helloCeldaPie = document.createElement("td");

          helloPie.appendChild(helloFilaPie);
        helloFilaPie.appendChild(helloCeldaPie);
          helloCeldaPie.innerText = "Inserta " + tabla;
          helloCeldaPie.colSpan= tamaño +1;
          
          helloCeldaPie.onclick = function(){
            if (tabla == "examen") {
              window.location="?p=Admin/Examen/nuevoExamen";
            }else{
            window.location="?p=formulario/form&e=anadir";
            }
          }

      return helloPie;
    }
