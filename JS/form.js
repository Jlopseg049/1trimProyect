//Al cargar la pagina quiero intentar leer la peticion GET con Javascript para saber
//si el formulario sera para editar un campo o en su defecto insertar uno nuevo,
//
//Sabré si es una inserccion o no porque pasaré el id del campo que quiero editar,
//y si no existe es porque quiero insertar un nuevo campo

window.addEventListener("load", function(){
    var formu = document.getElementsByTagName("form");
    sacaDatos();
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
          var respuesta = JSON.parse(ajax.responseText);
          if (respuesta.esquema.length > 0) {
    
            for (let i = 0; i <respuesta.esquema.length; i++) {
             var fila = creaFormu(respuesta.esquema[i],respuesta.tabla, respuesta.estado,datosTabla);
            //  form.appendChild(fila);
            }
          }
        }}
        ajax.open("POST", "formulario/methods/sacaEsquema.php");
        ajax.send();
      }
        
      function creaFormu(input, tabla, estado, datosTabla) {
        
        label = document.createElement("label");
  
        span = document.createElement("span");
        span.innerText = input[0];
        formu[0].appendChild(label);
    
        inputFormu = document.createElement("input");
        inputFormu.setAttribute("name", input[0]);
        inputFormu.setAttribute("placeholder", input[0]);

      
        if (estado == "edit") {
          if (/^PRI/.test(input[3]) == false){
            inputFormu.setAttribute("value", datosTabla[input[0]]);

            if (/^int/.test(input[1]) && /^UNI/.test(input[3]) == false) {
              inputFormu.setAttribute("type", "text");
              inputFormu.setAttribute("onkeypress", "return validaNumericos(event)");
              label.appendChild(inputFormu);
        
            }
        
            if (/^varchar/.test(input[1]) && /^UNI/.test(input[3]) == false) {
              inputFormu.setAttribute("type", "text");
              label.appendChild(inputFormu);
            }

            
            if(/^tinyint/.test(input[1])){
              inputFormu.setAttribute("type", "checkbox");
              label.appendChild(inputFormu);

            }

            if(/^foto/.test(input[0]) || /^recurso/.test(input[0])){
              inputFormu.setAttribute("type", "file");
              inputFormu.className ="label-input-file";
              label.appendChild(inputFormu);

            }
                label.appendChild(span);
          }
        }else if(estado == "anadir"){
          if (tabla == "persona" ) {
            
          }
          
          if (/^PRI/.test(input[3]) == false){

            if (/^int/.test(input[1])) {
              inputFormu.setAttribute("type", "text");
              inputFormu.setAttribute("onkeypress",  "return validaNumericos(event)");
              label.appendChild(inputFormu);

            }
        
            if (/^varchar/.test(input[1])) {
              inputFormu.setAttribute("type", "text");
              label.appendChild(inputFormu);
            }


            if(/^tinyint/.test(input[1])){
              inputFormu.setAttribute("type", "checkbox");
              label.appendChild(inputFormu);

            }
            
                        label.appendChild(span);
  
        }
    }
        
  }      
});



        

//Validaciones

function validaNumericos(event) {
  if(event.charCode >= 48 && event.charCode <= 57){
    return true;
   }
   return false;        
}
