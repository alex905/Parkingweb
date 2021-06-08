<?php
    //Comenzamos la sesión
    session_start();

    //Eliminamos todas las variables de sesión
    session_unset();

    //Destruimos la sesión actual
    session_destroy();

    //Volvemos a la página principal de nuestra aplicación
    header("Location: index.php");
?>