<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'administrador')) {
  header("location: ../../index.php");
  exit;
}
// Verificar si ha pasado más de 5 minutos desde la última acción del usuario
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 120)) {
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
    <title>Document</title>
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
      <a href="give_alumno.php">
        <img src="../../img/logo/graduado.png" alt="Estudiantes">
        <h2>Añadir Alumno</h2>
      </a>
    </div>
    <div class="module module-teacher">
      <a href="view_a.php">
        <img src="../../img/logo/instructor.png" alt="Profesores">
        <h2>Visualizar Alumno</h2>
      </a>
    </div>
  </div>
</body>
</html>