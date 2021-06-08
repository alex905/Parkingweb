//obtengo todos los botones de las diferentes reservas
var botones = document.getElementsByName("borrar_reserva");

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

if(enlaces.length == 5) {
    enlaces[3].classList.add("active");
}
else {
    //Agrego la clase active al elemento que tengamos seleccionado
    enlaces[7].classList.add("active");
}

//Recorro los botones y agrego función al evento click
for(var i=0;i<botones.length;i++) {
    botones[i].addEventListener("click",function(e){
        //Bloqueo la acción principal
        e.preventDefault();

        //Muestro un dialogo de confirmación
        var confirmar_cancelar_reserva = confirm("¿Desea eliminar la reserva seleccionada?");

        //Comprobamos si se ha dado confirmación por parte del usuario
        if(confirmar_cancelar_reserva) {
            //Muestro un mensaje al usuario y le indico que se ha eliminado la reserva
            alert("La reserva se ha cancelado correctamente");

            //Enviamos el formulario
            document.forms[this.id].submit();
        }
    });
}