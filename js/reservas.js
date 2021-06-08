//Botón Confirmar reserva
var boton_confirmar_reserva = ""; 

var campo_matricula_reserva = "";

var formulario_reserva = "";

//Expresiones regulares
var regexMatricula = /(^[A-Z]{2}\d{4}[A-Z]{2}$)|(^\d{4}[A-Z]{3}$)/i;

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

if(enlaces.length == 5) {
    enlaces[2].classList.add("active");
}
else {
    //Agrego la clase active al elemento que tengamos seleccionado
    enlaces[6].classList.add("active");
}

//Comprobamos si existe el formulario para introducir la matrícula
if(document.forms[1] != undefined) {
    //Capturamos el botón confirmar reserva
    boton_confirmar_reserva = document.getElementById("confirmar_reserva");

    //Establecemos el evento click del botón confirmar reserva
    boton_confirmar_reserva.addEventListener("click",function(e){
        //Bloqueamos la acción principal
        e.preventDefault();

        //Obtenemos el campo matrícula
        var campo_matricula_reserva = document.getElementById("matricula");

        //Comprobamos que el campo matrícula no esté vacío
        if(campo_matricula_reserva.value == "") {
            //Mostramos un mensaje al usuario
            alert("El campo matrícula está vacío");
        }
        else {
            //Comprobamos que se ha introducido una matrícula con el formato correcto
            if(!regexMatricula.test(campo_matricula_reserva.value)) {
                //Mostramos un error al usuario
                alert("La matrícula introducida no es correcta");
            }
            else {
                //Muestro un cuadro de confirmación al usuario
                var confirmar_reserva = confirm("Se va a proceder a realizar su reserva para la matrícula " + campo_matricula_reserva.value + ". Pulsa OK para confirmar su reserva");

                //Comprobamos la opción que ha elegido el usuario
                if(confirmar_reserva) {
                    //Mostramos un mensaje al usuario
                    alert("Su reserva se ha realizado correctamente");

                    //No hay errores, enviamos el formulario y realizamos la reserva
                    document.forms[1].submit();
                }

                
            }
        }
    });
}