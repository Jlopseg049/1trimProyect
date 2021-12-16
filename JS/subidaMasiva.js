window.addEventListener("load",()=>{
    const main = document.getElementsByTagName("main")[0];
    main.style.setProperty("display","grid");
    main.style.setProperty("justify-content","center");
    main.style.setProperty("justify-items","center");
    main.style.setProperty("align-content","center");


    const txtArea = document.createElement("textarea");

    txtArea.style.setProperty("resize", "vertical");
    txtArea.style.setProperty("width", "300px");
    txtArea.style.setProperty("min-height", "200px");
    txtArea.style.setProperty("height", "200px");
    txtArea.style.setProperty("max-height", "350px");
    txtArea.style.setProperty("overflow-x", "hidden");


    
    const formu = document.createElement("form");
    formu.style.setProperty("grid-template-columns", "repeat(1, 1fr)");
    formu.style.setProperty("grid-gap", "0");
    formu.style.setProperty("margin-left", "0");


    const label = document.createElement("label");
    const input = document.createElement("input");
    const span  = document.createElement("span");

    const boton = document.createElement("button");
    boton.innerHTML="Enviar datos";
main.appendChild(txtArea);
main.appendChild(formu);
main.appendChild(boton);
    formu.appendChild(label);

        label.appendChild(input);
        label.appendChild(span);

    input.setAttribute("type", "file");
    span.innerHTML = "Archivo CSV";
    span.style.color = "white";

    //Necesitaremos la tabla para hacer el insert más adelante
    const tabla = getParameterByName("t");

    //Cuando insertemos algun archivo csv en el input lo leera automaticamente
    input.addEventListener("change", (ev)=>{
        let file = ev.target.files[0];
        let reader = new FileReader();
        reader.onload = function(ev2){
        
            try {
                contenido = leerCSV(ev2.target.result,true);
                txtArea.innerHTML=contenido;

            } catch (e) {
                console.log(`Error: ${e.message}`)
            }
        }
    
        reader.readAsText(file);
    });
    function leerCSV(texto,omitirEncabezado = false,separador=","){
        if(typeof texto !== "string"){
            throw TypeError("El argumento debe ser una cadena.")
        }
       return texto.slice(omitirEncabezado ? texto.indexOf('\n') + 1 : 0)
        .split('\n')
        .map(linea => linea.split(separador));
    }
    boton.addEventListener("click",()=>{
        formulario = new FormData();
        formulario.append("tabla", tabla);
        tamano = document.getElementsByTagName("textarea")[0].value.split(",").length;
        datos = document.getElementsByTagName("textarea")[0].value.split(",");
        
        for (let i = 0; i < tamano; i++) {
            
            formulario.append(`dato_${i}`,datos[i]);            
        }
        const ajax = new XMLHttpRequest;  
        ajax.onreadystatechange = function () {
          if (ajax.readyState == 4 && ajax.status == 200) {
            return datosTabla = JSON.parse(ajax.responseText);
          }
        }
          ajax.open("POST", "formulario/methods/meteDatosMasivos.php");
          ajax.send(formulario);
        })
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }
