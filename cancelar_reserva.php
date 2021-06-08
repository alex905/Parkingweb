<?php
    require_once("./menu.php");
    require_once("./Metodos_cancelar_reserva.php");

    session_start();

    //Creamos un objeto de la clase Metodos_cancelar_reserva
    $metodos = new Metodos_cancelar_reserva();

    $reservas = "";

    $mensaje = "";

    $contador = 0;

    //Comprobamos si se ha pulsado el botón Borrar reserva
    if(count($_POST) > 0) {
      //Obtenemos el id y el idParking de la plaza que vamos a modificar


      //Borramos la reserva seleccionada
      $metodos->eliminarReserva(array(":idreserva" => $_POST['id_reserva']));

      //Ponemos la plaza que estaba ocupada libre
      $metodos->cambiarEstadoPlaza(array(":libre" => "Sí", ":reservada" => "No",
    ":idparking" => $_POST['id_parking'], ":nombre_plaza" => $_POST['nombre_plaza']));

      //Mando al usuario al index
      header("Location: index.php");
    }

    //Comprobamos si el usuario es administrador o no
    if($_SESSION['administrador'] == "Sí") {
        //ejecutamos la función para mostrar todas las reservas
        $reservas = $metodos->obtenerReservasAdmin();
    }
    else {
        //ejecutamos la función que muestra todas las reservas del usuario logueado
        $reservas = $metodos->obtenerReservasUsuario(array(":dniUsuario" => $_SESSION['dni']));
    }

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
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
            <?php
                //Mostramos las reservas
                foreach($reservas as $r) {
                    print("<form action='" . $_SERVER['PHP_SELF'] ."' method='POST' class='row g-3' name='eliminar_reserva'>
                    <input type='hidden' name='id_reserva' value='" . $r[0] . "'>
                    <input type='hidden' name='id_parking' value='" . $r[6] . "'>
                    <input type='hidden' name='nombre_plaza' value='" . $r[3] . "'>

                    <p class='col-12'>" . $r[1] . ", " . $r[2] . ", " . $r[3] . ", " . $r[4] . ", " . $r[5] .
                    " <button type='submit' class='btn btn-success' name='borrar_reserva' id='" . $contador . "'>Borrar reserva</button></p></form>");

                    $contador++;
                }
            ?>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/cancelar_reserva.js"></script>
</body>
</html>