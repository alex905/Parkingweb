//Botón Registrarse
var botonRegistrarse = document.getElementById("registrarse");

//variables
var errores = [];

//Expresiones regulares
var regexNombre = /^[A-Z]+$/i;
var regexApellidos = /^[A-Z]+\s{1}[A-Z]+$/i;
var regexDni = /^\d{8}[A-Z]{1}$/;
var regexEmail = /^\w+@{1}[A-Z]+\.[A-Z]{3}$/i;
var regexTelefono = /^\d{9}$/;

//Formato del array: nombre,apellidos,dni,email,pass,repetirPass,telefono,condiciones
var campos = [document.getElementById("nombre_nuevo_usuario"),
document.getElementById("apellidos_nuevo_usuario"),
document.getElementById("dni_nuevo_usuario"),
document.getElementById("email_nuevo_usuario"),
document.getElementById("pass_nuevo_usuario"),
document.getElementById("repetir_pass_usuario"),
document.getElementById("telefono_nuevo_usuario"),
document.getElementById("aceptar_condiciones")];

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

//Agrego la clase active al elemento que tengamos seleccionado
enlaces[1].classList.add("active");

//Evento click botón Registrarse
botonRegistrarse.addEventListener("click",function(e){
    //Anulamos la acción por defecto para impedir que se mande el formulario
    e.preventDefault();

    //Ponemos la variable errores vacía
    errores = [];

    //Comprobamos el valor de cada campo
    for(var i=0;i<campos.length;i++) {
        if(campos[i].value == "") {
            errores.push("El campo " + campos[i].id + " está vacío");
        }
    }

    //Comprobamos si existe algún campo en blanco y mostramos un mensaje al usuario
    if(errores.length > 0) {
        //Hay campos vacíos, por lo tanto muestro un mensaje al usuario
        alert(errores.join("\n"));
    }
    //No hay campos vacíos, continuamos la validación
    else {
        //Comprobamos el campo nombre
        if(!regexNombre.test(campos[0].value)) {
            errores.push("El campo nombre solo admite letras");
        }

        //Comprobamos el campo apellidos
        if(!regexApellidos.test(campos[1].value)) {
            errores.push("El campo apellidos contiene caracteres incorrectos.");
        }

        //Comprobamos el campo DNI
        if(!regexDni.test(campos[2].value)) {
            errores.push("El campo DNI no tiene un formato correcto");
        }

        //Comprobamos el campo Email
        if(!regexEmail.test(campos[3].value)) {
            errores.push("El campo email no es válido");
        }

        //Comprobamos que las contraseñas introducidas son iguales
        if(campos[4].value != campos[5].value) {
            //Las contraseñas no son iguales, generamos un error
            errores.push("Las contraseñas introducidas no coinciden");
        }

        //Comprobamos el campo teléfono
        if(!regexTelefono.test(campos[6].value)) {
            errores.push("El campo teléfono no es correcto");
        }

        //Comprobamos si se han aceptado las condiciones
        if(!campos[7].checked) {
            errores.push("Debes de aceptar las condiciones para poder registrarte");
        }

        //Comprobamos los errores y los mostramos al usuario
        if(errores.length > 0) {
            //Existen errores, se los mostramos al usuario
            alert(errores.join("\n"));
        }
        else {
            //Muestro un mensaje al usuario para indicarle que se ha agregado el usuario correctamente
            alert("El usuario se ha creado correctamente");

            //Enviamos el formulario
            document.forms[0].submit();
        }
    }
});