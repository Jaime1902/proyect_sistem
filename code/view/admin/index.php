<?php 
  include("header.php"); 
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
  <div id="content">
    <div class="module module-student">
      <a href="lobby_estudiante.php">
        <img src="../../img/logo/graduado.png" alt="Estudiantes">
        <h2>Estudiantes</h2>
      </a>
    </div>
    <div class="module module-teacher">
      <a href="lobby_profesor.php">
        <img src="../../img/logo/instructor.png" alt="Profesores">
        <h2>Profesores</h2>
      </a>
    </div>
    <div class="module module-class">
      <a href="lobby_cursos.php">
        <img src="../../img/logo/cuadernos.png" alt="Cursos">
        <h2>Cursos y Grados</h2>
      </a>
    </div>
    <div class="module module-grade">
      <a href="calificaciones.php">
        <img src="../../img/logo/grafico-de-barras.png" alt="Calificaciones">
        <h2>Calificaciones</h2>
      </a>
    </div>
    <div class="module module-pricing">
      <a href="mensualidad.php">
        <img src="../../img/logo/metodo-de-pago.png" alt="mensualidad">
        <h2>Mensualidad</h2>
      </a>
    </div>
    <div class="module module-class">
      <a href="lobby_usuario.php">
        <img src="../../img/logo/agregar-usuario.png" alt="usuarios">
        <h2>Agregar usuario</h2>
      </a>
    </div>
  </div>
</body>
</html> 

