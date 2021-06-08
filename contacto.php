<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'PHPMailer-6.4.0/src/Exception.php';
    require 'PHPMailer-6.4.0/src/PHPMailer.php';
    require 'PHPMailer-6.4.0/src/SMTP.php';
    require_once("./Menu.php");

    $mensaje_correcto = "";

    session_start();

    //Compruebo si se han enviado los datos
    if(isset($_POST['enviar'])) {
        $mail = new PHPMailer(true);

        try {
            //Ajustes del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contacto.parkingweb@gmail.com';
            $mail->Password = 'Parkingweb1';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('contacto.parkingweb@gmail.com', 'Parkingweb');
            $mail->addAddress('contacto1.parkingweb@gmail.com','Contacto - Parkingweb');
            $mail->isHTML();
            $mail->Subject = $_POST['nombre'] . " " . $_POST['apellidos'];
            $mail->Body = "Email del cliente: <b>" . $_POST['email'] . "</b><br>" . $_POST['mensaje'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->CharSet = 'UTF-8';

            if($mail->send()) {
                $mensaje_correcto = '<i class="bi bi-check" id="icono"></i> El mensaje se ha enviado correctamente';
            }
        } catch(Exception $e) {
            echo 'Error: ' . $mail->ErrorInfo;
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkingweb - Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/estilos_generales.css">
    <link rel="stylesheet" href="./css/contacto.css">
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form_contacto">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre: *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos: *</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email: *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div>
                    <label for="mensaje">Mensaje: *</label>
                    <textarea class="form-control" placeholder="Escribe tu mensaje aquí..." id="mensaje" name="mensaje"></textarea>
                    
                </div>

                <div id="botonesFormulario" class="d-flex col-12 justify-content-around">
                    <input class="btn btn-success" type="submit" id="enviar" name="enviar" value="Enviar"></button>
                    <button class="btn btn-danger" type="reset" id="reset">Borrar formulario</button>
                </div>
            </form>
            <p id="correcto" name="correcto" class="text-center"><?php echo $mensaje_correcto; ?></p>
        </main>
    </div>

    <!--Scripts JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="./js/contacto.js"></script>
</body>
</html>