<?php
    require_once("./Metodos_BBDD.php");
    require_once("./Metodos_login.php");

    session_start();

    $metodos = new Metodos_login();

    $metodos_BBDD = new Metodos_BBDD();

    //Comprobamos si se han rellenado los campos email y password y los buscamos en la base de datos
    if(isset($_POST['email']) && isset($_POST['password'])) {
        
        //Obtenemos los resultados
        $pass_usuario = $metodos_BBDD -> getPasswordEncriptado(array(':pass'=> $_POST['password']));        

        //Obtenemos los resultados
        $resultado_usuario = $metodos->comprobarUsuarioLogin(array(':email'=> $_POST['email'], ':pass' => $pass_usuario[0]));

        //Comprobamos si existe el usuario.
        if(empty($resultado_usuario)) {
            //El usuario no existe
            $_SESSION['existe'] = false;
            
            //Enviamos al usuario a la página principal
            header("Location: index.php");

        }
        else {
            //El usuario existe
            $_SESSION['existe'] = true;

            //Agregamos los datos del usuarios a las variables de sesión
            $_SESSION['dni'] = $resultado_usuario[0];
            $_SESSION['nombre'] = $resultado_usuario[1];
            $_SESSION['apellidos'] = $resultado_usuario[2];
            $_SESSION['administrador'] = $resultado_usuario[3];

            //Enviamos al usuario a la página principal
            header("Location: index.php");
        }
    }
    //Si no se han enviado los campos, suponemos que el usuario ha accedido a esta página de forma ilegítima, por lo que
    // lo enviamos a la página de inicio
    else {
        header("Location: index.php");
        die();
    }
?>