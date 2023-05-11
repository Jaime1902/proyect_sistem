<?php
 date_default_timezone_set('America/Managua');
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'administrador')) {
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
<div id="header">
    <h1>Colegio Cristiano Presbiteriano</h1>
  </div>
  <div id="menu">
    <a href="index.php">Inicio</a>
    <a href="lobby_estudiante.php">Estudiantes</a>
    <a href="mensualidad.php">Mensualidad</a>
    <a href="lobby_profesor.php">Profesores</a>
    <a href="lobby_cursos.php">Cursos</a>
    <a href="calificaciones.php">Calificaciones</a>
    <a href="close.php">Cerrar sesión</a>
  </div>
    
</body>
</html>