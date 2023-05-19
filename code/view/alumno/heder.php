<?php

 date_default_timezone_set('America/Managua');
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'alumno')) {
  header("location: ../../index.php");
  exit;
}

// Verificar si ha pasado más de 5 minutos desde la última acción del usuario
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 360)) {
  // Destruir la sesión
  session_unset();
  session_destroy();
  header("location: ../../index.php");
  exit;
}

// Actualizar el tiempo de última actividad de la sesión
$_SESSION['last_activity'] = time();

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<script>
    // Función para recargar la página después de cierto tiempo de inactividad
    function reloadAfterInactivity() {
        setTimeout(function() {
            location.reload();
        }, <?php echo (360 - (time() - $_SESSION['last_activity'])) * 1000; ?>);
    }

    // Llamar la función de recarga automática en la carga de la página
    window.onload = function() {
        reloadAfterInactivity();
    };
</script>
<body>
<nav class="red-header">
    <div class="container-fluid">
      <div class="header-container">
        <h5 class="header-text">Colegio Cristiano Presbiteriano</h5>
      </div>
    </div>
  </nav>
  <div class="sub-header">
    <div class="container">
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="view_asignatura.php">Ver Calificaciones</a></li>
        <li><a href="close.php">cerrar sesion</a></li>
      </ul>
    </div>
  </div>
  
</body>
</html>

