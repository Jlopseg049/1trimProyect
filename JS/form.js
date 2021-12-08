//Al cargar la pagina quiero intentar leer la peticion GET con Javascript para saber
//si el formulario sera para editar un campo o en su defecto insertar uno nuevo,
//
//Sabré si es una inserccion o no porque pasaré el id del campo que quiero editar,
//y si no existe es porque quiero insertar un nuevo campo

window.addEventListener("load", function(){
    var formu = document.getElementsByTagName("form");
    var div = document.createElement("div");
    var submit = document.createElement("input");
    var respuesta;
    var submitValue ;
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
           respuesta = JSON.parse(ajax.responseText);
          if (respuesta.esquema.length > 0) {
    
            for (let i = 0; i <respuesta.esquema.length; i++) {
              creaFormu(respuesta.esquema[i],respuesta.tabla, respuesta.estado,datosTabla);
            }
            div2 = document.createElement("div");
            submit.setAttribute("type","submit");
            formu[0].appendChild(div2);
            div2.appendChild(submit);
            submit.value = submitValue;   
                   
          }
        }}
        ajax.open("POST", "formulario/methods/sacaEsquema.php");
        ajax.send();
      }
        
      function creaFormu(input, tabla, estado, datosTabla) {
        

        if (estado == "edit") {
          let excepciones = [];
          if(tabla == "persona"){ excepciones = ['contrasena','activo']}

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

            inputFormu.setAttribute("value", datosTabla[input[0]]);

            if(/^rol/.test(input[0])){
              inputFormu = document.createElement("select");
              optPlaceholder = document.createElement("option");
              optPlaceholder.setAttribute("hidden" , "true");
              optPlaceholder.innerText ="Rol";

              opt1 = document.createElement("option");
              opt1.innerText ="Estudiante";
              inputFormu.appendChild(optPlaceholder);
              inputFormu.appendChild(opt1);

              label.appendChild(inputFormu);


            }else

            if (/^int/.test(input[1]) && /^UNI/.test(input[3]) == false) {
              inputFormu.setAttribute("type", "text");
              inputFormu.setAttribute("onkeypress", "return validaNumericos(event)");
              label.appendChild(inputFormu);
        
            }else
        
            if (/^varchar/.test(input[1]) && /^UNI/.test(input[3]) == false) {
              inputFormu.setAttribute("type", "text");
              label.appendChild(inputFormu);
            }else

            
            if(/^tinyint/.test(input[1])){
              inputFormu.setAttribute("type", "checkbox");
              label.appendChild(inputFormu);

            }else

            if(/^foto/.test(input[0]) || /^recurso/.test(input[0])){
              inputFormu.setAttribute("type", "file");
              inputFormu.className ="label-input-file";
              label.appendChild(inputFormu);

            }
                label.appendChild(span);
          }
        }
        }else if(estado == "anadir"){
          //Añadimos que campos no queremos cuando creamos un campo de una tabla concreta
          let excepciones = [];
          if(tabla == "persona"){ excepciones = ['nombre', 'ap1', 'ap2','contrasena', 'fechaNac', 'foto','activo']}

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
      }
submit.addEventListener("click",function(ev) {
  ev.preventDefault();
console.log(respuesta.tabla)});
});



//Control del boton


//Validaciones

function validaNumericos(event) {
  if(event.charCode >= 48 && event.charCode <= 57){
    return true;
   }
   return false;        
}
