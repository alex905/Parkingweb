<?php
    require_once("./menu.php");
    require_once("./Metodos_index.php");

    //Iniciamos la sesión
    session_start();

    $parkings = "";

    $info_parking_usuario = "";

    $datos_usuario = "";

    $formulario_login = '<form action="login.php" method="POST">
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

    //Comprobamos si existe la variable de sesión $_SESSION['existe']
    if(isset($_SESSION['existe'])) {
      //La variable existe, comprobamos si el usuario es correcto
      if($_SESSION['existe']) {
        $datos_usuario = "<div><h4>Bienvenido " . $_SESSION['nombre'] . " " . $_SESSION['apellidos'] . "</h4>" .
        "<p>DNI: " . $_SESSION['dni'] . "</p>" . "<p><a href='logout.php'>Cerrar sesión</a></p></div>";
      }
      //Si no existe el usuario, se muestra un mensaje al usuario
      else {
        $formulario_login .= "<div><p>El usuario o la contraseña son incorrectos</p></div>";
      }
    }
    
    //Creo un objeto de la clase Metodos_BBDD
    $metodos = new Metodos_index();

    //Guardo los resultados en una variable mediante la función getIdNombreParkings()
    $nombres_parkings = $metodos->getIdNombreParkings();

    //Comprobamos si se ha pulsado el botón Consultar Parking
    if(!isset($_POST["consultar"])) {
        //Recorro los resultados y los muestro dejando por defecto la primera opción
        $parkings = "<option value='0' selected>Elige una opción...</option>";
        foreach($nombres_parkings as $resultado) {
           $parkings .= "<option value='" . $resultado->id . "'>" . $resultado->nombre . "</option>";
        }
    }
    //Si se ha pulsado el botón Consultar y se ha seleccionado una opción distinta a la primera
    else {
        if($_POST['idParking'] != 0) {
            $parkings = "<option value='0'>Elige una opción...</option>";

            //Volvemos a recorrer los resultados y seleccionamos el que hemos elegido
            foreach($nombres_parkings as $resultado) {
                //Comprobamos cual es la opción que hemos elegido al pulsar el botón Consultar
                if($resultado->id == $_POST['idParking']) {
                    $parkings .= "<option value='" . $resultado->id . "' selected>" . $resultado->nombre . "</option>";
                }
                else {
                    //Si no coincide, añadimos la opción de forma normal
                    $parkings .= "<option value='" . $resultado->id . "'>" . $resultado->nombre . "</option>";
                }
            }

            //Obtenemos todos los datos del parking
            $datos_parking = $metodos->getDatosParkingSeleccionadoIndex(array(':id'=> $_POST['idParking']));

            //Guardamos los datos del parking en una variable para mostrarlos formateados
            foreach($datos_parking as $info) {
                $info_parking_usuario = "<h3>" . $info->nombre . "</h3>" .
                "<p>Dirección: " . $info->Direccion . "</p>" .
                "<h3>Plazas</h3>" .
                "<p>Plazas libres: " . $info->Libres . "</p>" . 
                "<p>Plazas ocupadas: " . $info->Ocupadas . "</p>" .
                "<p>Plazas totales: " . $info->Totales . "</p>" .
                "<p>Precio: " . $info->tarifa . " €/min</p>" .
                $info->mapa;
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkingweb</title>
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

        <main class ="row">
          <section class="col-8">
            <h2>¿Qué es Parkingweb?</h2>
            <p>Parkingweb es una aplicación web que te permite consultar las plazas libres y las plazas ocupadas
            de cualquier parking de la ciudad, además de ofrecerte la posibilidad de poder reservar una o varias plazas
            en cualquier parking en el que haya plazas disponibles. También se puede consultar las tarifas de los diferentes parkings
            </p>

            <h3>Selecciona un parking para consultar sus plazas y sus tarifas</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <select name="idParking" id="idParking" class="d-flex">
                <?php
                  //Mostramos el contenido de la variable $parkings que contiene todos los nombres de los parkings
                  print($parkings);
                ?>
              </select>
              <input type="submit" class="mt-3" name="consultar" id="consultar" value="Consultar parking">
            </form>
            <!--Div que contiene la información del parking que hemos consultado -->
              <div>
                <?php
                  print($info_parking_usuario);
                ?>
              </div>

          </section>
          <!--Sección login -->
          <section class="col-4">
            <?php
              //Compruebo si existe las variables de sesión para mostrar el formulario
              if(!isset($_SESSION['existe'])) {
                print($formulario_login);
                print('<div class="col-12 mt-3">
                <p>¿Aún no te has registrado? <a href="agregar_usuario.php">Regístrate ahora</a></p>
                </div>');
              }
              elseif(isset($_SESSION['existe']) && !$_SESSION['existe']) {
                print($formulario_login);
                print('<div class="col-12 mt-3">
                <p>¿Aún no te has registrado?<a href="agregar_usuario.php">Regístrate ahora</a></p>
                </div>');
              }
              elseif(isset($_SESSION['existe']) && $_SESSION['existe']) {
                print($datos_usuario);
              }
            ?>
          </section>
        </main>

        <!--footer -->
        <footer class="mt-5">
          <h4>Alejandro Carrillo Roldán</h4>
          <p>C.F.G.S Desarrollo de Aplicaciones Web</p>
          <p>I.E.S Punta del Verde (Sevilla)</p>
        </footer>
        
    </div>

    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/index.js"></script>
</body>
</html>