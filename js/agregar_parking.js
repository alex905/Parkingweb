//Botón Nuevo Parking
var botonAgregarParking = document.getElementById("nuevo_parking");

//Array que contiene todos los campos. Formato: nombre, tarifa, dirección, mapa, número de plazas
var camposParkingNuevo = [document.getElementById("nombre_parking"),
document.getElementById("tarifa_parking"),
document.getElementById("direccion_parking"),
document.getElementById("mapa_parking"),
document.getElementById("numero_plazas")];

//Expresiones regulares
regexTarifa = /^\d{1,}\.{1}\d{1,2}$/i;
regexNumeroPlazas = /^\d{1,}$/i;

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

//Agrego la clase active al elemento que tengamos seleccionado
enlaces[3].classList.add("active");

//Evento click del boton Nuevo Parking
botonAgregarParking.addEventListener("click",function(e){
    //Anulamos la acción principal
    e.preventDefault();

    //Array de errores
    var erroresNuevoParking = [];

    //Comprobamos si algún campo está vacío
    for(var i=0;i<camposParkingNuevo.length;i++) {
        if(camposParkingNuevo[i].value == "") {
            //Creamos un error
            erroresNuevoParking.push("El campo " + camposParkingNuevo[i].id + " está vacío");
        }
    }

    //Comprobamos si ha habido algún campo vacío
    if(erroresNuevoParking.length > 0) {
        //Hay campos vacíos, muestro un mensaje al usuario
        alert(erroresNuevoParking.join("\n"));
    }
    //No hay campos vacíos seguimos con la validación
    else {
        //validamos el campo tarifa
        if(!regexTarifa.test(camposParkingNuevo[1].value)) {
            erroresNuevoParking.push("El campo tarifa no es correcto");
        }

        //Validamos el número de plazas
        if(!regexNumeroPlazas.test(camposParkingNuevo[4].value)) {
            erroresNuevoParking.push("El campo número de plazas no es correcto");
        }

        //Comprobamos si existen errores
        if(erroresNuevoParking.length > 0) {
            //Existen errores, se los mostramos al usuario
            alert(erroresNuevoParking.join("\n"));
        }
        else {
            //No existen errores, enviamos el formulario y mostramos un mensaje al usuario
            alert("Se ha añadido correctamente el parking");
            document.forms[0].submit();
        }
    }
});