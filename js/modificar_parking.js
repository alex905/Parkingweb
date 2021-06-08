//Botón Modificar Parking y Eliminar parking
var botonModificarParking = document.getElementById("modificar_parking");
var botonEliminarParking = document.getElementById("eliminar_parking");

//Array que contiene todos los campos a modificar. Formato: nombre, tarifa, dirección, mapa, número de plazas
var camposParkingModificado = [document.getElementById("nombre_parking_mod"),
document.getElementById("tarifa_parking_mod"),
document.getElementById("direccion_parking_mod"),
document.getElementById("mapa_parking_mod")];

//Expresiones regulares
regexTarifa = /^\d{1,}\.{1}\d{1,2}$/i;
regexNumeroPlazas = /^\d{1,}$/i;

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

//Agrego la clase active al elemento que tengamos seleccionado
enlaces[4].classList.add("active");

//Evento click del boton Modificar Parking
botonModificarParking.addEventListener("click",function(e){
    //Anulamos la acción principal
    e.preventDefault();

    //Array de errores
    var errorresParkingModificado = [];

    //Comprobamos si algún campo está vacío
    for(var i=0;i<camposParkingModificado.length;i++) {
        if(camposParkingModificado[i].value == "") {
            //Creamos un error
            errorresParkingModificado.push("El campo " + camposParkingModificado[i].id + " está vacío");
        }
    }

    //Comprobamos si ha habido algún campo vacío
    if(errorresParkingModificado.length > 0) {
        //Hay campos vacíos, muestro un mensaje al usuario
        alert(errorresParkingModificado.join("\n"));
    }
    //No hay campos vacíos seguimos con la validación
    else {
        //validamos el campo tarifa
        if(!regexTarifa.test(camposParkingModificado[1].value)) {
            errorresParkingModificado.push("El campo tarifa no es correcto");
        }

        //Comprobamos si existen errores
        if(errorresParkingModificado.length > 0) {
            //Existen errores, se los mostramos al usuario
            alert(errorresParkingModificado.join("\n"));
        }
        else {
            //Mostramos un cuadro de confirmación al usuario
            var confirmar_modificar_parking = confirm("¿Desea modificar el parking? Pulsa OK para confirmar");

            //Comprobamos si se ha pulsado OK
            if(confirmar_modificar_parking) {
                //Mostramos un mensaje al usuario
                alert("Se ha modificado correctamente el parking seleccionado");

                //No existen errores, enviamos el formulario
                document.forms[0].submit();
            }

            
        }
    }
});

//Evento click del botón Eliminar
botonEliminarParking.addEventListener("click",function(e){
    //Eliminamos la acción principal
    e.preventDefault();

    //Mostramos un cuadro de confirmación al usuario
    var confirmar_eliminar_parking = confirm("¿Está seguro de que desea eliminar el parking seleccionado?");

    //Comprobamos si se ha pulsado OK
    if(confirmar_eliminar_parking) {
        //Mostramos un mensaje al usuario
        alert("El parking seleccionado se ha eliminado correctamente");

        //Enviamos el formulario
        document.forms[1].submit();
    }
});