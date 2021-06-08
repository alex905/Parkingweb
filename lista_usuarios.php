<?php
    require_once("./menu.php");
    require_once("./Metodos_lista_usuarios.php");

    //Iniciamos la sesión
    session_start();

    //Creamos un objeto de la clase Metodos_BBDD
    $metodos = new Metodos_lista_usuarios();

    //Comprobamos si se ha accedido de forma ilegítima o si el usuario no es admin
    if(!isset($_SESSION['existe']) || $_SESSION['administrador'] == "No" ) {
        header("Location: index.php");
    }
    //El usuario es administrador y está logueado
    else {
        //Comprobamos si se ha pulsado el botón Eliminar
        if(isset($_POST['dni_usuario_borrar'])) {
          //Eliminamos al usuario seleccionado y volvemos a la lista de usuarios
          $metodos->borrarUsuario(array(":dni" => $_POST['dni_usuario_borrar']));
        }
        
        //Guardamos los resultados en una variable
        $usuarios = $metodos->obtenerUsuariosAdmin(array(":dni" => $_SESSION['dni']));

    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
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
                $contador = 1;
                //Recorremos los usuarios y los mostramos
                foreach($usuarios as $u) {
                    //Por cada usuario, generamos un formulario con dos botones: modificar y borrar
                    print("<form action='modificar_usuario.php' method='POST' class='row g-3'>
                    <input type='hidden' name='dni_usuario' value='" . $u->DNI . "'>
                    <span class='col-12'>" . $u->DNI . ", " . $u->Nombre . " " . $u->Apellidos .
                    ", " . $u->Email . 
                    " <button type='submit' class='btn btn-success d-flex mb-3' name='seleccionar_usuario'>Seleccionar</button>
                    </form>
                    <form action='" . $_SERVER['PHP_SELF'] . "' method='POST' class='d-flex'>
                    <input type='hidden' name='dni_usuario_borrar' value='" . $u->DNI . "'>
                    <button type='submit' class='btn btn-danger d-flex' name='borrar_usuario' id='" . $contador . "'>Eliminar</button></form></span>
                    ");

                    $contador = $contador + 2;
                }
            ?>

            <div>
                <?php
                  //Compruebo si existe un mensaje en la variable de sesión
                  if(isset($_SESSION['mensaje'])) {
                    print($_SESSION['mensaje']);
                    unset($_SESSION['mensaje']);
                  }
                  else {
                    print "";
                  }
                ?>
            </div>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/borrar_usuario.js"></script>
</body>
</html>