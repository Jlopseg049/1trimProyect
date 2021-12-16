//Al cargar la pagina quiero intentar leer la peticion GET con Javascript para saber
//si el formulario sera para editar un campo o en su defecto insertar uno nuevo,
//
//Sabré si es una inserccion o no porque pasaré el id del campo que quiero editar,
//y si no existe es porque quiero insertar un nuevo campo

window.addEventListener("load", function(){
    var formu = document.getElementsByTagName("form");
    formu[0].setAttribute("enctype", "multipart/form-data");
    var div = document.createElement("div");
    var submit = document.createElement("input");
    var respuesta;
    var submitValue ;
    estado = getParameterByName("e");
    
    if (estado == "edit") {
      var datosTabla = sacaDatos();

    }
    var numeroPreguntas = sacaMaxID();
//Para agilizar algunos datos, usaremos una funcion para leer desde la url, antes de hacer nada,
//usare una funcion para leer en contenido de la url a traves del window.location.search
function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
    sacaFormu();
    
    function sacaDatos(){
      const ajax = new XMLHttpRequest;  
      ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
          return datosTabla = JSON.parse(ajax.responseText);
        }
      }
        ajax.open("POST", "formulario/methods/sacaDatos.php");
        ajax.send();
    };
    


    function sacaFormu(){
            
         
      const ajax = new XMLHttpRequest;  
      ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
           respuesta = JSON.parse(ajax.responseText);
          if (respuesta.esquema.length > 0) {
            for ( i = 0; i <respuesta.esquema.length; i++) {
              tamanoCampo = respuesta.esquema[i].length;
              respuesta.estado == "edit"? 
              creaFormu(respuesta.esquema[i] , respuesta.tabla, respuesta.estado,datosTabla[0])
              :
              creaFormu(respuesta.esquema[i] , respuesta.tabla, respuesta.estado);
            }
            
            var div2 = document.createElement("div");
            formu[0].appendChild(div2);

            //Para este proyecto, a excepcion de la creacion del examen la cual hice a parte
            //la unica tabla que usare 2 consultas para sacar sus datos serán las respuestas
            //asi que doy por entendido que si existe una segunda consulta, serán las respuestas
            //También por esta razon, necesitare menos cosas para validar que tipo de campo usare 
            //ya que siempre serán iguales y con el mismo esqueleto
            if(respuesta.tabla == "preguntas"){
              p = document.createElement("h2");
              p.innerText="Selecione cual será la respuesta correcta:";
              p.style.paddingBottom = "20px";
              div2.appendChild(p);
                            //Solo habra 4 posibles respuestas
              for (let x = 0; x < 4; x++) {
                div2.appendChild(creaRespuestas(datosTabla[1][x], 
                                                respuesta.estado, 
                                                x, 
                                                datosTabla[0])
                                                );

              }
  
            }
            submit.setAttribute("type","submit");
            div2.appendChild(submit);
            submit.value = submitValue;   
                   
          }
        }}
        ajax.open("POST", "formulario/methods/sacaEsquema.php");
        ajax.send();
      }
        
      function creaFormu(input, tabla, estado, datos = null) {
        if (estado == "edit") {
          let excepciones = [];
          if(tabla == "persona")  {excepciones = ['contrasena','activo']}
          if(tabla == "preguntas"){excepciones = ['PreguntaRespuesta','respuesta','respuestaCorrecta']}
          if(excepciones.includes(input[0])==false){
          if (/^PRI/.test(input[3]) == false){

             submitValue="Editar " +tabla;
            label = document.createElement("label");
            label.setAttribute("id", "input-" + input[0]);
            span = document.createElement("span");
            span.innerText = input[0];
            formu[0].appendChild(div);
            div.appendChild(label)

        
            inputFormu = document.createElement("input");
            inputFormu.setAttribute("name", input[0]);
            inputFormu.setAttribute("placeholder", input[0]);

            inputFormu.setAttribute("value", datos[0][input[0]]);

            if(/^tematica/.test(input[0])){
              
              creaSelect(input[0],label);


            }else

            if(/^rol/.test(input[0])){
              
              creaSelect(input[0],label);


            }else

            if (/^int/.test(input[1]) && /^UNI/.test(input[3]) == false) {
              inputFormu.setAttribute("type", "text");
              inputFormu.setAttribute("tipo", "numero");
              inputFormu.setAttribute("onkeypress", "return validaNumericos(event)");
              label.appendChild(inputFormu);
        
            }
        
            if (/^varchar/.test(input[1]) && /^UNI/.test(input[3]) == false) {
              inputFormu.setAttribute("type", "text");
              inputFormu.setAttribute("tipo", "cadena");
              label.appendChild(inputFormu);
            }

            
            if(/^tinyint/.test(input[1])){
              inputFormu.setAttribute("type", "checkbox");
              label.appendChild(inputFormu);

            }

            if(/^foto/.test(input[0]) || /^recurso/.test(input[0])){
              inputFormu.setAttribute("type", "file");
              inputFormu.setAttribute("tipo", "fichero");
              label.appendChild(inputFormu);

            }
                label.appendChild(span);
          }
        }
        if(tabla == "preguntas" &&
           excepciones.includes(input[0])){
           }
        }else if(estado == "anadir"){
          //Añadimos que campos no queremos cuando creamos un campo de una tabla concreta
          let excepciones = [];
          if(tabla == "persona"){ excepciones = ['recurso','nombre', 'ap1', 'ap2','contrasena', 'fechaNac', 'foto','activo']}
          if(tabla == "preguntas"){excepciones = ['PreguntaRespuesta','respuesta','respuestaCorrecta' ]}
          if(excepciones.includes(input[0])==false){
          
   if (/^PRI/.test(input[3]) == false){
              submitValue="Añadir " +tabla;

              label = document.createElement("label");
    
              span = document.createElement("span");
              span.innerText = input[0];
              formu[0].appendChild(div);
              div.appendChild(label)

          
              inputFormu = document.createElement("input");
              inputFormu.setAttribute("name", input[0]);
              inputFormu.setAttribute("placeholder", input[0]);
              inputFormu.setAttribute("require", "");
              
              if(/^foto/.test(input[0]) || /^recurso/.test(input[0])){
                inputFormu.setAttribute("type", "file");
                inputFormu.setAttribute("tipo", "fichero");
                label.appendChild(inputFormu);
  
              }else
              if(/^tematica/.test(input[0])){

                creaSelect(input[0],label);
    
  
              }else 
              if(/^rol/.test(input[0])){

              creaSelect(input[0],label);
  

              }else

              if (/^int/.test(input[1])) {
                inputFormu.setAttribute("type", "text");
                inputFormu.setAttribute("onkeypress",  "return validaNumericos(event)");
                inputFormu.setAttribute("tipo", "numero");

                label.appendChild(inputFormu);

              }else
          
              if (/^varchar/.test(input[1])) {
                inputFormu.setAttribute("type", "text");
                inputFormu.setAttribute("tipo", "cadena");
                label.appendChild(inputFormu);
              }else


              if(/^tinyint/.test(input[1])){
                inputFormu.setAttribute("type", "checkbox");
                label.appendChild(inputFormu);
              }
              label.setAttribute("for",inputFormu.getAttribute("name"));

                          label.appendChild(span);
            }
          }
        } 
      }
      function creaRespuestas(Datos = null, estado, numPreg, idPregunta) { 
        label = document.createElement("label");
        label.style.display ="grid";
        label.style.setProperty('grid-template-columns','repeat(2, 1fr)');

        span = document.createElement("span");

        if (estado == "anadir") {
            span.innerText = "Respuesta " + (numPreg +1)    ;
            inputFormu = document.createElement("input");
            inputFormu.setAttribute("type", "text");
            inputFormu.setAttribute("tipo", "cadena");
            inputFormu.setAttribute("name", span.innerText);
            inputFormu.setAttribute("require", "");

            inputFormu.setAttribute("placeholder",span.innerText );
            inputFormu.setAttribute("require", "");

            inputFormu2 = document.createElement("input");
            inputFormu2.setAttribute("type", "radio");
            inputFormu2.setAttribute("id", "Respuesta " + (numeroPreguntas + numPreg) );
            inputFormu2.setAttribute("name", "respuestaCorrecta");
            inputFormu2.setAttribute("require", "");

            label.appendChild(inputFormu);
                            label.appendChild(span);
            label.setAttribute("for",inputFormu.getAttribute("name"));

            label.appendChild(inputFormu2);
            return label;
            
        }else
        if(Datos['idrespuestas']){   
        }  
        if (estado == "edit") {
          if (Datos["respuesta"]) {
            ultimaRespuesta = sacaMaxID("respuestas");          


            span.innerText = "Respuesta " + (numPreg +1)    ;
            inputFormu = document.createElement("input");
            inputFormu.setAttribute("type", "text");
            inputFormu.setAttribute("tipo", "cadena");
            inputFormu.setAttribute("name", Datos['respuesta']);
            inputFormu.setAttribute("require", "");

            inputFormu.setAttribute("placeholder",span.innerText );
            inputFormu.setAttribute("require", "");
            inputFormu.setAttribute("value", Datos["respuesta"]);
            inputFormu2 = document.createElement("input");
            inputFormu2.setAttribute("type", "radio");
            inputFormu2.setAttribute("id_", Datos['idrespuestas']);
            inputFormu2.setAttribute("name", "respuestaCorrecta");
            inputFormu2.setAttribute("require", "");

            if (Datos['idrespuestas'] == idPregunta[0]['respuestaCorrecta']) {
              inputFormu2.setAttribute("checked", "");

            }
            label.appendChild(inputFormu);
                            label.appendChild(span);

            label.appendChild(inputFormu2);
            return label;
          }
      }
    }

      function sacaMaxID(tabla = ""){
        const ajax = new XMLHttpRequest;  
        ajax.onreadystatechange = function () {
          if (ajax.readyState == 4 && ajax.status == 200) {
            numeroPreguntas = parseInt(JSON.parse(ajax.responseText));
             return numeroPreguntas;
             
          }
        }
          ajax.open("GET", "formulario/methods/sacaMaxID.php?tabla="+ tabla);
          ajax.send();
      }
      
      function creaSelect(tabla, objeto){
        
        const ajax = new XMLHttpRequest;  
        ajax.onreadystatechange = function () {
          if (ajax.readyState == 4 && ajax.status == 200) {
            inputSelect = document.createElement("select");
            inputSelect.setAttribute("name", tabla)

             datosSelect = JSON.parse(ajax.responseText);
             
             options = [];
  

             inputSelect.setAttribute("tipo", "select");
      
      
            for (let i = 0; i < datosSelect.length; i++) {
              options[tabla + "_" + i+1]= document.createElement("option");
              options[tabla + "_" + i+1].setAttribute("value", datosSelect[i][0]);
    
              options[tabla + "_" + i+1].innerText = datosSelect[i][1] + "";
              inputSelect.appendChild(options[tabla + "_" + i+1]);


            }
            objeto.appendChild(inputSelect);
            objeto.removeChild(objeto.children[0]);

          }
        }

          ajax.open("GET", "formulario/methods/creaSelect.php?select=" + tabla);
          ajax.send();
          
      }
      //Control del boton

    submit.addEventListener("click",async function(ev) {
      ev.preventDefault();
      formulario = new FormData();
      formulario.append("tabla", respuesta.tabla);
       camposFormData = formu[0].children[0].children.length;
       for (let i = 0; i < camposFormData; i++) {
         dato1=formu[0].children[0].children[i].children[0].name;

            dato2 = formu[0].children[0].children[i].children[0].value;
         
            if(formu[0].children[0].children[i].children[0].getAttribute("tipo") == "cadena"){
            dato2= "'" + dato2 + "'";
            }

         if(formu[0].children[0].children[i].children[0].getAttribute("tipo") == "select"){
            dato2 = parseInt(formu[0].children[0].children[i].children[0].value);
          }
          if(formu[0].children[0].children[i].children[0].getAttribute("tipo") == "fichero"){

              dato2 = formu[0].children[0].children[i].children[0].files[0];


    


          }

        formulario.append(dato1, dato2);
       }

       if (respuesta.tabla == "preguntas") {
         //añadiremos la respuesta correcta
                 //Empezamos por 1 ya que el children 0 es el titulo

         camposFormData2 = formu[0].children[1].children.length -1;
          for (let i = 1; i < camposFormData2; i++) {
            dato1=formu[0].children[1].children[i].children[2].getAttribute("name");

            if(formu[0].children[1].children[i].children[2].checked == true){
              dato2 = formu[0].children[1].children[i].children[2].getAttribute("id");
              formulario.append(dato1, dato2);

              break;
            }
          }
       }

       if(respuesta.estado == "edit"){
         ajaxModifica(formulario);
       }
       if(respuesta.estado == "anadir"){
         
         ajaxInsert(formulario);
         if(respuesta.tabla == "persona"){
          const ajax = new XMLHttpRequest;  

          ajax.open("POST", "formulario/methods/correoRegistro.php");
          ajax.send(formulario);
         }
          //Siempre que insertemos una pregunta, deberemos insertar sus 4 respuestas
           if (respuesta.tabla == "preguntas") {
             formulario = new FormData();
             formulario.append("tabla", "respuestas");
           }
          for (let i = 0; i < camposFormData; i++) {
            
        
            formu[0].children[0].children[i].children[0].value = "";
         }
        }


    });

    function ajaxModifica(formulario){ 
      const ajax = new XMLHttpRequest;  

        ajax.open("POST", "formulario/methods/cambiaDatos.php");
        ajax.send(formulario);
    }
    function ajaxInsert(formulario){ 
      const ajax = new XMLHttpRequest;  

        ajax.open("POST", "formulario/methods/meteDatos.php");
        ajax.send(formulario);
    }
});





//Validaciones

function validaNumericos(event) {
  if(event.charCode >= 48 && event.charCode <= 57){
    return true;
   }
   return false;        
}
