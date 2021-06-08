<?php
    require_once("./menu.php");
    require_once("./Metodos_modificar_parking.php");

    //Iniciamos la sesión
    session_start();

    $mensaje = "";

    //Creamos un nuevo objeto de la clase Metodos_BBDD
    $metodos = new Metodos_modificar_parking();

    //Comprobamos si se ha accedido de forma ilegítima o si el usuario no es admin
    if(!isset($_SESSION['existe']) || $_SESSION['administrador'] == "No" ) {
        header("Location: index.php");
    }
    //El usuario es administrador y está logueado
    else {

        //Obtenemos los datos y los guardamos en una variable
        $datos_parking = $metodos->obtenerDatosParkingPorId(array(":id" => $_POST['id_parking']));

        

        //Guardo el resultado en la consulta que hemos realizado anteriormente y que contiene todos los datos del parking
        $datos_parking[4] = $metodos->modificarCaracteres(array(":id" => $_POST['id_parking']));

        //Creo una variable de sesión con el id del parking seleccionado
        $_SESSION['idParkingSeleccionado'] = $_POST['id_parking'];

        
        //Botón ELIMINAR
        if(isset($_POST['id_parking_seleccionado'])) {
            //Ejecutamos la función para eliminar el parking seleccionado
            $metodos->eliminarParking(array(":idParking" => $_POST['id_parking_seleccionado']));

            //Guardo un mensaje en una variable de sesión
            $_SESSION['mensaje'] = "El parking " . $datos_parking[1] . " se ha eliminado correctamente";

            

            //Mando al usuario a la lista de parkings
            header("Location: lista_parking.php");
            
        }

        //Botón MODIFICAR
        if(isset($_POST['nombre_parking_mod'])) {
          //Modificamos el parking seleccionado
          $metodos->modificarParking(array(":nombreParking" => $_POST['nombre_parking_mod'],
          ":tarifaParking" => $_POST['tarifa_parking_mod'],":direccionParking" => $_POST['direccion_parking_mod'],
          ":mapaParking" => $_POST['mapa_parking_mod'],":idParking" => $_POST['id_parking']));

            //Mandamos al usuario a la lista de parkings
            header("Location: lista_parking.php");
          
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Parking</title>
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="mb-3">
                    <label for="nombre_parking_mod" class="form-label">Nombre del parking</label>
                    <input type="hidden" name="id_parking" value="<?php print($datos_parking[0]); ?>">
                    <input type="text" class="form-control" id="nombre_parking_mod" name="nombre_parking_mod" id="nombre_parking_mod" value="<?php print($datos_parking[1]); ?>">
                </div>

                <div class="mb-3">
                    <label for="tarifa_parking_mod" class="form-label">Tarifa</label>
                    <input type="text" class="form-control" id="tarifa_parking_mod" name="tarifa_parking_mod" id="tarifa_parking_mod" value="<?php print($datos_parking[2]); ?>">
                </div>

                <div class="mb-3">
                    <label for="direccion_parking_mod" class="form-label">Dirección del parking</label>
                    <input type="text" class="form-control" id="direccion_parking_mod" name="direccion_parking_mod" id="direccion_parking_mod" value="<?php print($datos_parking[3]); ?>">
                </div>
                

                <div class="mb-3">
                    <label for="mapa_parking_mod" class="form-label">Mapa</label>
                    <input type="text" class="form-control" id="mapa_parking_mod" name="mapa_parking_mod" id="mapa_parking_mod" value='<?php print($datos_parking[4]); ?>''>
                </div>

                <button type="submit" class="btn btn-primary" name="modificar_parking" id="modificar_parking" value="modificar_parking">Modificar</button>

            </form>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="mt-3">
              <input type="hidden" name="id_parking_seleccionado" value="<?php print($_SESSION['idParkingSeleccionado']); ?>">
              <button type="submit" class="btn btn-danger" name="eliminar_parking" id="eliminar_parking">Eliminar</button>
            </form>
        </main>
    </div>
    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/modificar_parking.js"></script>
</body>
</html>