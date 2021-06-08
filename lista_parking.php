<?php
    require_once("./menu.php");
    require_once("./Metodos_lista_parking.php");

    //Iniciamos la sesión
    session_start();

    //Creamos un objeto de la clase Metodos_BBDD
    $metodos = new Metodos_lista_parking();

    //Comprobamos si se ha accedido de forma ilegítima o si el usuario no es admin
    if(!isset($_SESSION['existe']) || $_SESSION['administrador'] == "No" ) {
        header("Location: index.php");
    }
    //El usuario es administrador y está logueado
    else {
        
        //Guardamos los resultados en una variable
        $parkings = $metodos->obtenerDatosParkingsAdmin();
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Parkings</title>
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
                //Recorremos los parkings y los mostramos
                foreach($parkings as $p) {
                    //Por cada parking, generamos un formulario con dos botones: modificar y borrar
                    print("<form action='modificar_parking.php' method='POST' class='row g-3'>
                    <input type='hidden' name='id_parking' value='" . $p->ID . "'>
                    <input type='hidden' name='nombre_parking' value='" . $p->Nombre . "'>
                    <input type='hidden' name='direccion_parking' value='" . $p->Direccion . "'>
                    <input type='hidden' name='mapa_parking' value='" . $p->Mapa . "'>
                    <p class='col-12'>" . $p->ID . ", " . $p->Nombre . ", " . $p->Direccion .
                    " <button type='submit' class='btn btn-success' name='seleccionar'>Seleccionar</button></p></form>");
                    
                   
        
                }
            ?>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/lista_parking.js"></script>
</body>
</html>