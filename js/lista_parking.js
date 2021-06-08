//Guardamos todos los enlaces del menú en una variable
var enlaces = document.getElementsByClassName("nav-link");

//Quito la clase active al elemento index
enlaces[0].classList.remove("active");

//Agrego la clase active al elemento que tengamos seleccionado
enlaces[4].classList.add("active");