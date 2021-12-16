//Se debe instanciar el objeto Validación, y pasar los respectivos test
//con todos los campos que querramos, una vez acabemos podemos devolver los resultados de la 
//validacion con validacion.CheckErrores();

const validacion = {
    errores : [],
    checkErrores : function(){
        if (errores.length == 0) {
            //Pasas el test
            return true;
        }else{
            //No pasas el test así que devolvemos el mensaje de error
            return this.errores[0]["Error"];
        }
    }
}

String.prototype.campoVacioCheck = function(){
    //Toma nulos y cadenas de espacios en blanco
    /^(?!\s*$).+/.test(this)? "" :
    validacion.errores.push({Error : "Este campo no puede estar en blanco."});

    /^null$/.test(this)?
    validacion.errores.push({Error : "Este campo no puede estar en blanco."}) : "";

    //Hacemos la revisión una vez hecho el test.
    return validacion.checkErrores();
}

String.prototype.campoEmailCheck = function(){
    /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(this)? "" :
    validacion.errores.push({Error : "Este email no es válido."});

    //Hacemos la revisión una vez hecho el test.
    return validacion.checkErrores();
}

String.prototype.campoNumberCheck = function(){
    /^[0-9]*$/.test(this)? "" :
    validacion.errores.push({Error : "Este campo debe ser numérico."});

    //Hacemos la revisión una vez hecho el test.
    return validacion.checkErrores();
}

