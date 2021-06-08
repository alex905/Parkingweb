<?php
    require_once("./menu.php");
    require_once("./Metodos_modificar_usuario.php");
    require_once("./Metodos_BBDD.php");

    //iniciamos sesión
    session_start();

    $metodosBBDD = new Metodos_BBDD();
    $metodos_modificar_usuario = new Metodos_modificar_usuario();

    $mensaje = "";

    $datos_usuario = "";

    //Comprobamos si se ha accedido de forma ilegal
    if(isset($_SESSION['existe'])) {
        //Obtenemos los datos de nuestro usuario
        $datos_usuario = $metodos_modificar_usuario->obtenerDatosUsuario(array(":dni" => $_SESSION['dni']));

        //Comprobamos si se ha pulsado el botón de aplicar cambios
        if(count($_POST) > 0) {

            $parametros = array(':nombre' => $_POST['nombre_usuario'],
                                ':apellidos' => $_POST['apellidos_usuario'],
                                ':email' => $_POST['email_usuario'] );

            //Comprobamos si el usuario quiere modificar su contraseña
            if($_POST['cambiar_pass'] == "p1") {
                //Ejecutamos la función que obtiene la password de forma encriptada y guardamos los resultados

                $pass_usuario = $metodosBBDD->getPasswordEncriptado(array(':pass'=> $_POST['pass_usuario']));

                //Añadimos al array de parámetros el parámetro preparado pass
                $parametros[':pass'] = $pass_usuario[0];
            }
            //Se ha seleccionado la opción de mantener la misma contraseña
            else {
                //Ejecutamos la función obtenerPasswordDni para obtener la contraseña del usuario actual
                $pass_usuario = $metodos_modificar_usuario->obtenerPasswordDni(array(":dni" => $_SESSION['dni']));

                //Guardamos en el array parámetros el parámetro pass que hemos obtenido
                $parametros[':pass'] = $pass_usuario[0];
              }

                //Agregamos el parámetro teléfono al array de parámetros
                $parametros[':telefono'] = $_POST['tel_usuario'];

                $parametros[':administrador'] = $_POST['admin'];

                $parametros[':dni'] = $_SESSION['dni'];

                //Ejecutamos la función actulizarUsuario
                $metodos_modificar_usuario->actualizarUsuario($parametros);

                //Modificamos las variables de sesión
                $_SESSION['nombre'] = $_POST['nombre_usuario'];
                $_SESSION['apellidos'] = $_POST['apellidos_usuario'];
                $_SESSION['administrador'] = $_POST['admin'];

                //Mandamos al usuario a la página principal
                header("Location: index.php");
        }
            
    }
    else {
        header("Location:index.php");
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar datos personales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos_generales.css">
</head>
<body>
    <div id="contenedor" class="container">
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="mb-3">
                    <input type="hidden" class="form-control" id="dni_usuario" name="dni_usuario" value="<?php print($datos_usuario[4]); ?>">
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php print($datos_usuario[0]); ?>">
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos_usuario" name="apellidos_usuario" value="<?php print($datos_usuario[1]); ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_usuario" name="email_usuario" value="<?php print($datos_usuario[2]); ?>">
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cambiar_pass" id="misma_pass" value="p0" checked>
                    <label class="form-check-label" for="cambiar_pass">Usar la misma contraseña</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cambiar_pass" id="diferente_pass" value="p1">
                    <label class="form-check-label" for="cambiar_pass">Usar una contraseña diferente</label>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass_usuario" name="pass_usuario">
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="tel_usuario" name="tel_usuario" value="<?php print($datos_usuario[3]); ?>">
                </div>

                <?php
                  //Comprobamos si el usuario logueado es admin y creamos una casilla para cambiar su valor
                  if($_SESSION['administrador'] == "Sí") {
                    print('<div class="mb-3">
                    <label class="form-label">Administrador</label>
                    </div><div class="mb-3">
                    <input class="form-check-input" type="radio" name="admin" id="admin_si" value="Sí" checked>
                    <label class="form-check-label" for="admin_si">Sí</label>
                    </div>
                    
                    <div class="mb-3">
                    <input class="form-check-input" type="radio" name="admin" id="admin_no" value="No">
                    <label class="form-check-label" for="admin_no">No</label>
                    </div>');
                  }
                ?>

                <button type="submit" class="btn btn-primary" name="guardar_cambios_datos_personales" id="guardar_cambios_datos_personales">Guardar cambios</button>
            </form>
        </main>
        <div>
            <?php print($mensaje); ?>
        </div>
    </div>

    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/modificar_datos_personales.js"></script>
</body>
</html>