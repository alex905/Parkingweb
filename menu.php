<?php
    function menu_estandar() {
        print('<li class="nav-item text-center">
        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
      </li>
      
      <li class="nav-item text-center">
        <a href="reservas.php" class="nav-link">Realizar una reserva</a>
      </li>

      <li class="nav-item text-center">
          <a href="contacto.php" class="nav-link">Contacto</a>
      </li>');
    }

    function menu_usuario() {
        print('<li class="nav-item text-center">
        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
      </li>

      <li class="nav-item text-center">
        <a href="modificar_datos_personales.php" class="nav-link">Modificar datos personales</a>
    </li>
      
      <li class="nav-item text-center">
        <a href="reservas.php" class="nav-link">Realizar una reserva</a>
      </li>

      <li class="nav-item text-center">
        <a href="cancelar_reserva.php" class="nav-link">Cancelar reserva</a>
      </li>

      <li class="nav-item text-center">
          <a href="contacto.php" class="nav-link">Contacto</a>
      </li>');
    }

    function menu_administrador() {
        print('<li class="nav-item text-center">
        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
      </li>

      <li class="nav-item text-center">
        <a href="agregar_usuario.php" class="nav-link">Agregar usuarios</a>
      </li>

      <li class="nav-item text-center">
        <a href="lista_usuarios.php" class="nav-link">Modificar usuarios</a>
      </li>

      <li class="nav-item text-center">
        <a href="agregar_parking.php" class="nav-link">Añadir parking</a>
      </li>

      <li class="nav-item text-center">
        <a href="lista_parking.php" class="nav-link">Modificar parking</a>
      </li>

      <li class="nav-item text-center">
        <a href="modificar_datos_personales.php" class="nav-link">Modificar datos personales</a>
      </li>
      
      <li class="nav-item text-center">
        <a href="reservas.php" class="nav-link">Realizar una reserva</a>
      </li>

      <li class="nav-item text-center">
        <a href="cancelar_reserva.php" class="nav-link">Cancelar reserva</a>
      </li>

      <li class="nav-item text-center">
          <a href="contacto.php" class="nav-link">Contacto</a>
      </li>');
    }
?>