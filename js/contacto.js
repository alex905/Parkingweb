//Declaramos las variables que contienen los diferentes elementos
var btnEnviar = document.getElementById("enviar");
var inputNombre = document.getElementById("nombre");
var inputApellidos = document.getElementById("apellidos");
var inputEmail = document.getElementById("email");

var campos_contacto = [document.getElementById("nombre"),
document.getElementById("apellidos"),
document.getElementById("email"),
document.getElementById("mensaje")];

//Expresiones regulares
var regexNombre = /^[A-Z]+$/i;
var regexApellidos = /^[A-Z]+\s{1}[A-Z]+$/i;
var regexEmail = /^\w+@{1}[A-Z]+\.[A-Z]{3}$/i;

//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

if(enlaces.length == 5) {
    enlaces[4].classList.add("active");
}
else {
    //Agrego la clase active al elemento que tengamos seleccionado
    enlaces[8].classList.add("active");
}

// Evitamos el comportamiento normal del botón enviar
btnEnviar.addEventListener("click",function(e) {
    e.preventDefault();

    var errores = [];

    //Comprobamos si hay algún campo vacío
    for(var i=0;i<campos_contacto.length;i++) {
        if(campos_contacto[i].value == "") {
            //Agregamos un error al array
            errores.push("El campo " + campos_contacto[i].id + " está vacío");
        }
    }

    //Comprobamos si hay algún campo vacío y se lo mostramos al usuario
    if(errores.length > 0) {
        alert(errores.join("\n"));
    }
    else {
        //Comprobamos el campo nombre
        if(!regexNombre.test(campos_contacto[0].value)) {
            //Agregamos un error al array
            errores.push("El campo nombre no es correcto");
        }

        //Comprobamos el campo apellidos
        if(!regexApellidos.test(campos_contacto[1].value)) {
            //Agregamos un error al array
            errores.push("El campo apellidos no es correcto");
        }

        //Comprobamos el campo email
        if(!regexEmail.test(campos_contacto[2].value)) {
            //Agregamos un error al array
            errores.push("El campo email no es correcto");
        }

        //Comprobamos si existe algún error
        if(errores.length > 0) {
            alert(errores.join("\n"));
        }
        else {
            //Enviamos el formulario
            document.forms[0].submit();
        }
    }
});