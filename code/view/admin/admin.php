<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'administrador' && $_SESSION['role'] != 'secretaria')) {
  header("location: ..\index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style type="text/css">
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background-color: #fff;
      color: #333;
    }

    #header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 60px;
      padding: 0 20px;
      background-color: #d32f2f;
      color: #fff;
    }

    #header h1 {
      font-size: 24px;
      font-weight: normal;
      margin: 0;
    }

    #menu {
      display: flex;
      align-items: center;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      height: 60px;
      padding: 0 20px;
    }

    #menu a {
      color: #333;
      text-decoration: none;
      margin-right: 20px;
      font-weight: bold;
      font-size: 16px;
    }

    #menu a:hover {
      color: #d32f2f;
    }

    #content {
      display: flex;
      flex-wrap: wrap;
      margin: 20px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      border-radius: 5px;
    }

    .module {
      display: flex;
      align-items: center;
      justify-content: center;
      width: calc(33.33% - 20px);
      height: 150px;
      margin: 10px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      text-align: center;
    }

    .module a {
      display: block;
      width: 100%;
      height: 100%;
      padding: 20px;
      color: #fff;
      text-decoration: none;
    }

    .module-user {
      background-color: #4caf50;
    }

    .module-student {
      background-color: #d32f2f;
    }

    .module-teacher {
      background-color: #ff9800;
    }

    .module-class {
      background-color: #e53935;
    }

    .module-grade {
      background-color: #8bc34a;
    }

    .module img {
      max-width: 100%;
      max-height: 100%;
    }

    @media screen and (max-width: 768px) {
      #content {
        margin: 10px;
      }

      .module {
        width: calc(50% - 20px);
      }
    }

    @media screen and (max-width: 480px) {
      .module {
        width:calc(100% - 20px);
}
}
</style>

</head>
<body>
  <div id="header">
    <h1>Colegio Cristiano Presbiteriano</h1>
  </div>
  <div id="menu">
    <a href="#">Inicio</a>
    <a href="#">Usuarios</a>
    <a href="#">Estudiantes</a>
    <a href="#">Profesores</a>
    <a href="#">Cursos</a>
    <a href="#">Calificaciones</a>
    <a href=" ../../index.php">Cerrar sesión</a>
  </div>
  <div id="content">
    <div class="module module-user">
      <a href="#">
        <img src="user.png" alt="Usuarios">
        <h2>Usuarios</h2>
      </a>
    </div>
    <div class="module module-student">
      <a href="#">
        <img src="student.png" alt="Estudiantes">
        <h2>Estudiantes</h2>
      </a>
    </div>
    <div class="module module-teacher">
      <a href="#">
        <img src="../../img/logo/teacher.png" alt="Profesores">
        <h2>Profesores</h2>
      </a>
    </div>
    <div class="module module-class">
      <a href="#">
        <img src="class.png" alt="Cursos">
        <h2>Cursos</h2>
      </a>
    </div>
    <div class="module module-grade">
      <a href="#">
        <img src="grade.png" alt="Calificaciones">
        <h2>Calificaciones</h2>
      </a>
    </div>
  </div>
</body>
</html> 
