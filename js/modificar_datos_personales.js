var boton_guardar_cambios_personales = document.getElementById("guardar_cambios_datos_personales");

var campos_datos_personales = [document.getElementById("nombre_usuario"),
document.getElementById("apellidos_usuario"),
document.getElementById("email_usuario"),
document.getElementById("tel_usuario")];

var cambiar_pass = document.getElementsByName("cambiar_pass");
var campo_pass = document.getElementById("pass_usuario");

//Expresiones regulares
var regexNombre = /^[A-Z]+$/i;
var regexApellidos = /^[A-Z]+\s{1}[A-Z]+$/i;
var regexEmail = /^\w+@{1}[A-Z]+\.[A-Z]{3}$/i;
var regexTelefono = /^\d{9}$/;

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

if(enlaces.length == 5) {
    enlaces[1].classList.add("active");
}
else {
    //Agrego la clase active al elemento que tengamos seleccionado
    enlaces[5].classList.add("active");
}




boton_guardar_cambios_personales.addEventListener("click",function(e){
    var errores = [];
    //Anulamos la acción principal del botón
    e.preventDefault();

    //Comprobamos si ha algún campo vacío
    for(var i=0;i<campos_datos_personales.length;i++) {
        if(campos_datos_personales[i].value == "") {
            //Creamos un error y lo agregamos al array de errores
            errores.push("El campo " + campos_datos_personales[i].id + " está vacío");
        }
    }

    //Comprobamos si se ha seleccionado la opción de cambiar la contraseña
    if(cambiar_pass[1].checked) {
        //Se ha seleccionado la opción de cambiar la contraseña
        //Comprobamos si el campo está vacío
        if(campo_pass.value == "") {
            errores.push("El campo Contraseña está vacío");
        }
    }

    //Comprobamos si hay algún campo vacío
    if(errores.length > 0) {
        //Mostramos los errores al usuario
        alert(errores.join("\n"));
    }
    else {
        //No hay campos vacíos

        //Comprobamos el campo nombre
        if(!regexNombre.test(campos_datos_personales[0].value)) {
            //Mostramos un error
            errores.push("El campo nombre tiene carácteres incorrectos");
        }

        //Comprobamos el campo apellidos
        if(!regexApellidos.test(campos_datos_personales[1].value)) {
            //Mostramos un error
            errores.push("El campo apellidos tiene carácteres incorrectos");
        }

        //Comprobamos el campo email
        if(!regexEmail.test(campos_datos_personales[2].value)) {
            errores.push("El campo email no es correcto");
        }

        //Comprobamos el campo teléfono
        if(!regexTelefono.test(campos_datos_personales[3].value)) {
            errores.push("El campo teléfono tiene carácteres incorrectos");
        }

        //Comprobamos si existen errores
        if(errores.length > 0) {
            //Mostramos los errores al usuario
            alert(errores.join("\n"));
        }
        else {
            //Mostramos un cuadro de confirmación al usuario
            var confirmar_modificar_datos = confirm("Se va a proceder a modificar los datos del usuario. Pulsa OK para confirmar");

            //Comprobamos lo que ha pulsado el usuario
            if(confirmar_modificar_datos) {
                //Mostramos un mensaje al usuario
                alert("Los cambios se han aplicado correctamente");

                //Enviamos el formulario
                document.forms[0].submit();
            }
        }
    }
});