window.addEventListener("load", function(){
   const main = document.getElementsByTagName("main")[0];

    //Primero pasaremos el id del examen para sacar sus preguntas para a su vez sacar sus respuestas
   //  idExamenTemporal = 1;
   //  sacaPreguntas(idExamenTemporal);
    
   //  var respuestas= [];
   //  function sacaPreguntas(idExamen){
        
   //      const ajax = new XMLHttpRequest;  
   //      ajax.onreadystatechange = function () {
   //        if (ajax.readyState == 4 && ajax.status == 200) {
   //           preguntas = JSON.parse(ajax.responseText);
   //           for (let i = 0; i < preguntas.length; i++) {
                
   //              const ajax = new XMLHttpRequest;  
   //              ajax.onreadystatechange = function () {
   //                if (ajax.readyState == 4 && ajax.status == 200) {
   //                   respuestas[0][i].push(JSON.parse(ajax.responseText));
        
   //                }
   //              }
   //              ajax.open("GET", "MaquetaExamen/methods/sacaRespuestas.php?id="+preguntas[i][0]);
   //              ajax.send();
   //            };
   //            console.log(respuestas[0]);

   //            if (respuestas.length>0) {
   //             pintaExamen();

   //           }
   //           }


   //        }
   //      ajax.open("GET", "MaquetaExamen/methods/sacaPreguntas.php?id="+idExamen);
   //      ajax.send();
   //    };

pintaExamen();


function pintaExamen(){
   section = document.createElement("article");
   section.setAttribute("class", "popup-wrapper");
   section.setAttribute("z-index", 1000);
   
   capa = document.createElement("div");
   capa.setAttribute("class", "popup");
   capa.style.background ="rgba(121,97,212,0.64)";
   capa.setAttribute("z-index", 1001);
   
   div = document.createElement("div");
   div2 = document.createElement("div");
   
   img = document.createElement("img");
   img.src="../../IMG/bg.jpg";
   img.width="250"; 
   img.height="20";
   
   //Pregunta
   p1 = document.createElement("p");
   p1.innerText ="Enunciado de la primera pregunta";
   
   
   div.appendChild(img);
   div.appendChild(p1);
   
   //Respuestas
   p2 = document.createElement("label");
   span1 = document.createElement("p");
   span1.innerText ="Respuesta 1";
   p2.appendChild(span1);
   
   p3 = document.createElement("label");
   span2 = document.createElement("p");
   span2.innerText ="Respuesta 2";
   p3.appendChild(span2);

   p4 = document.createElement("label");
   span3 = document.createElement("p");
   span3.innerText ="Respuesta 3";
   p4.appendChild(span3);

   p5 = document.createElement("label");
   span4 = document.createElement("p");
   span4.innerText ="Respuesta 4";
   p5.appendChild(span4);

   
   form = document.createElement("form");
   form.setAttribute("class","popup-content");
   radio1 = document.createElement("input");
   radio1.setAttribute("type", "radio");
   radio1.setAttribute("name","respuesta");

   radio2 = document.createElement("input");
   radio2.setAttribute("type", "radio");
   radio2.setAttribute("name","respuesta");

   radio3 = document.createElement("input");
   radio3.setAttribute("type", "radio");
   radio3.setAttribute("name","respuesta");

   radio4 = document.createElement("input");
   radio4.setAttribute("type", "radio");
   radio4.setAttribute("name","respuesta");

   div2.appendChild(p2);
   
   p2.appendChild(radio1);
   
   div2.appendChild(p3);
   p3.appendChild(radio2);
   
   div2.appendChild(p4);
   p4.appendChild(radio3);
   
   div2.appendChild(p5);
   p5.appendChild(radio4);
   
   form.appendChild(div);
   form.appendChild(div2);
   
   capa.appendChild(form);
   
   section.appendChild(capa);
   
   main.appendChild(section);


footer = document.createElement("footer");
Fdiv1 = document.createElement("div");
Fdiv2 = document.createElement("div");
Fdiv3 = document.createElement("div");
Fdiv4 = document.createElement("div");


   
   };
});



