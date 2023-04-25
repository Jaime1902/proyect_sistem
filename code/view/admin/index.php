<?php
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
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="header">
    <h1>Colegio Cristiano Presbiteriano</h1>
  </div>
  <div id="menu">
    <a href="index.php">Inicio</a>
    <a href="A_estudiante.php">Estudiantes</a>
    <a href="#">Mensualidad</a>
    <a href="#">Profesores</a>
    <a href="#">Cursos</a>
    <a href="#">Calificaciones</a>
    <a href="close.php">Cerrar sesión</a>
  </div>
  <div id="content">
    <div class="module module-student">
      <a href="A_estudiante.php">
        <img src="../../img/logo/graduado.png" alt="Estudiantes">
        <h2>Estudiantes</h2>
      </a>
    </div>
    <div class="module module-teacher">
      <a href="#">
        <img src="../../img/logo/instructor.png" alt="Profesores">
        <h2>Profesores</h2>
      </a>
    </div>
    <div class="module module-class">
      <a href="#">
        <img src="../../img/logo/cuadernos.png" alt="Cursos">
        <h2>Cursos</h2>
      </a>
    </div>
    <div class="module module-grade">
      <a href="#">
        <img src="../../img/logo/grafico-de-barras.png" alt="Calificaciones">
        <h2>Calificaciones</h2>
      </a>
    </div>
    <div class="module module-pricing">
      <a href="#">
        <img src="../../img/logo/metodo-de-pago.png" alt="mensualidad">
        <h2>Mensualidad</h2>
      </a>
    </div>
  </div>
</body>
</html> 

