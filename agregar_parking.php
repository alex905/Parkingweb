<?php
    require_once("./menu.php");
    require_once("./Metodos_agregar_parking.php");

    //Iniciamos la sesión
    session_start();

    $mensaje = "";

    $plazas_generadas = 0;

    //Creamos un objeto de la clase Metodos_BBDD
    $metodos = new Metodos_agregar_parking();

    //Comprobamos si se ha accedido de forma ilegítima.
    if(!isset($_SESSION['existe']) || $_SESSION['administrador'] == "No") {
        header("Location: index.php");
    }
    else {
        //Comprobamos si se ha pulsado el botón Agregar parking
        if(count($_POST) > 0) {
            
            //Insertamos el nuevo parking y obtenemos el id del registro que acabamos de insertar
            $id = $metodos->insertarParking(array(":nombre" => $_POST['nombre_parking'],
            ":direccion" => $_POST['direccion_parking'],
            ":mapa" => $_POST['mapa_parking'], ":tarifa" => $_POST['tarifa_parking']));

            //Generamos las plazas del parking            
            for($i=65; $i<=90; $i++) {
                //Compruebo si se han generado todas las plazas
                if($plazas_generadas == $_POST['numero_plazas']) {
                    break;
                }
                else {
                    //Genero la letra de la plaza
                    $letra = chr($i);

                    //Genero las plazas
                    for($j=1; $j<=50; $j++) {
                        //Compruebo si hay más plazas por generar
                        if($plazas_generadas == $_POST['numero_plazas']) {
                            break;
                        }
                        else {
                            //Creamos la plaza y aumentamos el número de plazas generadas
                            $metodos->insertarPlaza(array(":nombre_plaza" => $letra . $j,
                            ":libre" => "Sí", ":reservada" => "No", "idParking" => $id));

                            $plazas_generadas++;
                        }
                    }
                }
            }
            //Mandamos al usuario al index
            header("Location: index.php");
        }
    }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Parking</title>
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
                <div class="row mb-3">
                    <label for="nombre_parking" class="col-sm-2 col-form-label">Nombre del parking</label>
                    <div class="col-sm-10 mt-2">
                        <input type="text" class="form-control" name="nombre_parking" id="nombre_parking">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tarifa_parking" class="col-sm-2 col-form-label">Tarifa</label>
                    <div class="col-sm-10 mt-2">
                        <input type="text" class="form-control" name="tarifa_parking" id="tarifa_parking">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="direccion_parking" class="col-sm-2 col-form-label">Dirección del parking</label>
                    <div class="col-sm-10 mt-2">
                        <input type="text" class="form-control" name="direccion_parking" id="direccion_parking">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="mapa_parking" class="col-sm-2 col-form-label">Mapa</label>
                    <div class="col-sm-10 mt-2">
                        <input type="text" class="form-control" name="mapa_parking" id="mapa_parking">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="numero_plazas" class="col-sm-2 col-form-label">Número de plazas</label>
                    <div class="col-sm-10 mt-2">
                        <input type="number" class="form-control" name="numero_plazas" id="numero_plazas">
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="nuevo_parking" id="nuevo_parking">Añadir parking</button>
                </div>
            </form>

            <div>
                <?php print($mensaje); ?>
            </div>
        
        </main>
    </div>

    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/agregar_parking.js"></script>
</body>
</html>