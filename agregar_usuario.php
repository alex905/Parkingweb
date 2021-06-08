<?php
    require_once("./menu.php");
    require_once("./Metodos_BBDD.php");
    require_once("./Metodos_agregar_usuario.php");

    //Iniciamos la sesión
    session_start();

    $mensaje = "";

    //Creamos un objeto de la clase Metodos_BBDD
    $metodos_BBDD = new Metodos_BBDD();
    $metodos = new Metodos_agregar_usuario();

    //Comprobamos si se ha pulsado el botón Registrarse
    if(count($_POST) > 0 ) {
       
        //Obtengo la salida de la función password
        $password = $metodos_BBDD->getPasswordEncriptado(array(':pass' => $_POST['pass_nuevo_usuario']));

        //Creo un array que contendrá los parámetros de la consulta SQL
        $parametros = array(":dni" => $_POST['dni_nuevo_usuario'], 
                            ":nombre" => $_POST['nombre_nuevo_usuario'],
                            ":apellidos" => $_POST['apellidos_nuevo_usuario'],
                            ":email" => $_POST['email_nuevo_usuario'],
                            ":pass" => $password[0],
                            ":telefono" => $_POST['telefono_nuevo_usuario'],
                            ":administrador" => "No");

        //Ejecuto la consulta
        $metodos->insertarNuevoUsuario($parametros);

        //Mando al usuario al index
        header("Location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <header>
        <h1 class="text-center">Parkingweb</h1>
        <!--<nav class="navbar navbar-dark bg-primary"></nav> -->
        <!-- Menu-->
        <nav class="row navbar navbar-expand-lg navbar-light bg-light">
            <div class="col-12">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-around">
                        <?php
                        //Comprobamos las variables de sesión
                        if(!isset($_SESSION['existe']) || !$_SESSION['existe']) {
                            //Si no se ha intentado loguear o se ha logueado de forma incorrecta, mostramos el menú estándar
                            menu_estandar();
                        }
                        //Si se ha logueado correctamente el usuario, comprobamos si es un usuario normal o un administrador
                        if(isset($_SESSION['existe']) && $_SESSION['existe']) {
                            //Comprobamos si es un usuario administrador
                            if($_SESSION['administrador'] == "Sí") {
                            menu_administrador();
                            }
                            //Comprobamos si es un usuario estándar
                            else {
                            menu_usuario();
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    
        <main>
            <form class="row g-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="registro_usuario">
                <div class="col-md-6">
                    <label for="nombre_nuevo_usuario" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre_nuevo_usuario" name="nombre_nuevo_usuario" placeholder="Escribe tu nombre aquí...">
                </div>

                <div class="col-md-6">
                    <label for="apellidos_nuevo_usuario" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos_nuevo_usuario" name="apellidos_nuevo_usuario" placeholder="Escribe tus apellidos aquí...">
                 </div>

                <div class="col-3">
                    <label for="dni_nuevo_usuario" class="form-label">DNI</label>
                    <input type="text" class="form-control" id="dni_nuevo_usuario" name="dni_nuevo_usuario" placeholder="Ej: 12345678Z">
                </div>
                <div class="col-9">
                    <label for="email_nuevo_usuario" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email_nuevo_usuario" name="email_nuevo_usuario" placeholder="Ej: prueba@gmail.com">
                 </div>
                <div class="col-md-4">
                    <label for="pass_nuevo_usuario" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass_nuevo_usuario" name="pass_nuevo_usuario" placeholder="Establece una contraseña">
                </div>
                <div class="col-md-4">
                    <label for="repetir_pass_usuario" class="form-label">Repetir contraseña</label>
                    <input type="password" class="form-control" id="repetir_pass_usuario" name="repetir_pass_usuario" placeholder="Vuelve a escribir la contraseña">
                </div>
                <div class="col-md-4">
                    <label for="telefono_nuevo_usuario" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono_nuevo_usuario" name="telefono_nuevo_usuario" placeholder="Ej: 600123456">
                </div>
                <div class="col-12">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aceptar_condiciones" name="aceptar_condiciones">
                    <label class="form-check-label" for="gridCheck">
                     Confirmo que acepto las condiciones establecidas del servicio Parkingweb
                    </label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="registrarse" id="registrarse">Registrarse</button>
                </div>
            </form>
        
        </main>

        <div>
            <?php print($mensaje); ?>
        </div>
    </div>

    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/agregar_usuario.js"></script>
</body>
</html>