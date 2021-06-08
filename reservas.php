<?php
    require_once("./menu.php");
    require_once("./Metodos_reservas.php");
    require_once("./Metodos_index.php");

    //Iniciamos la sesión
    session_start();

    $resultado = "";

    $parkings = "";

    $existe_plaza = "";

    $mensaje_plaza_reservada = "";

    //Creamos un objeto de la clase Metodos_BBDD
    $metodos = new Metodos_reservas();
    $metodos_index = new Metodos_index();

    $formulario_reserva_plaza = '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST" class="row g-3" id="formulario_reserva" name="formulario_reserva">
    <p>introduce la siguiente información</p>
    <div class="col-12">
    <label for="matricula" class="form-label">Matrícula</label>
    <input type="text" name="matricula" id="matricula" class="form-control" placeholder="Ej:1234ABC">
    </div>
    <div class="col-12">
    <input type="submit" name="confirmar_reserva" value="Confirmar reserva" id="confirmar_reserva">
    </div></form>';

    $formulario_login = '<form action="login.php" method="POST">
    <span class="mt-3">Estás accediendo a una zona restringida. Por favor, inicia sesión para continuar</span>
    <div class="mt-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email">
    </div>
    
    <div class="mt-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-primary d-flex mt-3" name="Acceder">Acceder</button>
  </form>';

    //Comprobamos si se está accediendo como usuario logueado
    if(isset($_SESSION['existe'])) {
        
        //Obtengo el nombre y el id de todos los parking y los guardo en una variable
        $nombres_parkings = $metodos_index->getIdNombreParkings();

        //Recorro los resultados y los muestro dejando por defecto la primera opción
        $parkings = "<option value='0' selected>Elige una opción...</option>";
        foreach($nombres_parkings as $resultado) {
           $parkings .= "<option value='" . $resultado->id . "'>" . $resultado->nombre . "</option>";
        }

        //Guardo el formualario en la variable resultado para mostrárselo al usuario
        $resultado = '<span>Por favor seleccione un parking y pulse el botón Seleccionar</span><form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
        <select name="selector_parking">' . $parkings . '</select>
        <button type="submit" name="seleccionar_parking">Seleccionar</button></form>';

        //Compruebo si se ha pulsado el botón Seleccionar y se ha elegido una opción diferente de la primera
        if(isset($_POST['seleccionar_parking']) && $_POST['selector_parking'] != 0) {
            
            //Guardamos el resultado en una variable
            $plazas_libres = $metodos->contarPlazasLibres(array(":idParking" => $_POST['selector_parking'],
            ":libre" => "Sí"));

            //Comprobamos el resultado
            if($plazas_libres > 0) {
                //Hay plazas libres
                $existe_plaza = true;

                //Mostramos un mensaje al usuario con el número de plazas disponibles
                $mensaje_plaza_reservada = "Hay disponibles " . $plazas_libres[0] . " plazas libres en el parking selecccionado";

                //Guardo el id del parking seleccionado en una variable de sesion
                $_SESSION['idParkingSeleccionado'] = $_POST['selector_parking'];

            }
            else {
                //No hay plazas libres. Mostramos un mensaje al usuario
                $existe_plaza = false;
            }
        }

        //Botón Confirmar reserva
        if(isset($_POST['matricula'])) {
          //Inserto el vehículo junto con el DNI del usuario
          $metodos->insertarVehiculo(array(":matricula" => $_POST['matricula'], ":dniUsuario" => $_SESSION['dni'] ));

          //Obtengo la primera plaza que está vacía y guardo su id y su nombre en variables
          $plaza_vacia = $metodos->obtenerPrimeraPlazaVacia(array(":libre" => "Sí", ":idParking" => $_SESSION['idParkingSeleccionado']));

          //Guardo el nombre de la plaza y su id en variables
          $id_plaza = $plaza_vacia[0];
          $nombre_plaza = $plaza_vacia[1];

          //Cambiamos el estado de la plaza libre a reservada
          $metodos->modificarEstadoPlaza(array(":libre" => "No", ":reservada" => "Sí", "idplaza" => $id_plaza));

          //Realizamos la reserva en la base de datos
          $metodos->realizarReserva(array(":dni" => $_SESSION['dni'], ":matricula" => $_POST['matricula'],
          ":idParking" => $_SESSION['idParkingSeleccionado'], "idPlaza" => $id_plaza));

          //Agregamos los datos de la reserva a las variables de sesión
          $_SESSION['idPlaza'] = $id_plaza;
          $_SESSION['matricula'] = $_POST['matricula'];

          $mensaje_plaza_reservada = "Se ha reservado correctamente la plaza " . $nombre_plaza . " para el vehículo " .
          $_SESSION['matricula'];

          //Mando al usuario a la página principal
          header("Location: index.php");
        }

    }
    else {
        //Si el usuario no está logueado, mostramos un formulario para que haga login
        $resultado = $formulario_login;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
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

        <main class="row">
            <div class="col-12">
                <?php
                    print $resultado;
                ?>
            </div>

            <div class="col-12">
                <?php
                    if($existe_plaza) {
                        print($formulario_reserva_plaza);
                    }
                    elseif(!isset($_POST['seleccionar_parking'])) {
                        print "";
                    }
                    else {
                      print ("No existen plazas disponibles para el parking seleccionado.");
                    }
                ?>
            </div>

            <div class="col-12">
                <?php
                  print $mensaje_plaza_reservada;
                ?>
            </div>
        <main>
    </div>

    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/reservas.js"></script>
</body>
</html>