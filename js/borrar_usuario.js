//Obtengo el botón para eliminar el usuario
var botonEliminar = document.getElementsByName("borrar_usuario");

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

//Agrego la clase active al elemento que tengamos seleccionado
enlaces[2].classList.add("active");

//Recorro los botones y agrego la el evento click
for(var i=0; i<botonEliminar.length; i++) {
    botonEliminar[i].addEventListener("click",function(e){
        //Anulo la acción principal
        e.preventDefault();

        //Mostramos un cuadro de alerta al usuario
        var confirmar_borrar_usuario = confirm("¿Está seguro de que desea borrar el usuario seleccionado? Pulsa OK para confirmar");

        //Comprobamos la opción que ha elegido el usuario
        if(confirmar_borrar_usuario) {
            //Mostramos un mensaje al usuario
            alert("El usuario se ha eliminado correctamente");

            //Enviamos el formulario
            document.forms[this.id].submit();
        }
    });
}