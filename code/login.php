<?php
session_start();

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Verificar que el nombre de usuario y la contraseña contengan solo caracteres seguros
  if (preg_match('/^[a-zA-Z0-9.]+$/', $username) && preg_match('/^[a-zA-Z0-9.]+$/', $password)) {
    // Convertir la contraseña en un hash
    $password_hash = hash('sha256', $password);

    // Preparar la consulta
    $stmt = $conexion->prepare("SELECT * FROM login WHERE username=? AND password_hash=?");
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
      $_SESSION['last_activity'] = time();
      $fila = $resultado->fetch_assoc();
      $_SESSION['username'] = $fila['username'];
      $_SESSION['role'] = $fila['role'];
      $_SESSION['id_login'] = $fila['id']; // Almacenar el ID de login en una variable de sesión
      
      // Realizar la consulta para obtener el ID de alumno correspondiente al ID de login
      $stmt = $conexion->prepare("SELECT id_alumno FROM alumnos WHERE login_id=?");
      $stmt->bind_param("i", $_SESSION['id_login']);
      $stmt->execute();
      $resultado = $stmt->get_result();

      if ($resultado->num_rows == 1) {
        // Encontrar el registro de alumno correspondiente al usuario autenticado
        $fila = $resultado->fetch_assoc();
        $_SESSION['id_alumno'] = $fila['id_alumno']; // Almacenar el ID de alumno en una variable de sesión
      }

      // Realizar la consulta para obtener el ID de profesor correspondiente al ID de login
      $stmt = $conexion->prepare("SELECT id_profesor FROM profesores WHERE login_id=?");
      $stmt->bind_param("i", $_SESSION['id_login']);
      $stmt->execute();
      $resultado = $stmt->get_result();

      if ($resultado->num_rows == 1) {
        // Encontrar el registro de profesor correspondiente al usuario autenticado
        $fila = $resultado->fetch_assoc();
        $_SESSION['id_profesor'] = $fila['id_profesor']; // Almacenar el ID de profesor en una variable de sesión
      }

      // Redirigir al usuario a la página correspondiente según su rol
      if ($_SESSION['role'] == 'administrador') {
        header("location: view/admin/index.php");
        exit();
      } elseif ($_SESSION['role'] == 'secretaria') {
        header("location: view/secretaria/index.php");
        exit();
      } elseif ($_SESSION['role'] == 'alumno') {
        header("location: view/alumno/index.php");
        exit();
      } elseif ($_SESSION['role'] == 'profesor') {
        header("location: view/profesor/index.php");
        exit();
      }
    } else {
      $_SESSION['login_error'] = "Nombre de usuario o contraseña incorrectos.";
      header("location: login_error.php");
      exit();
    }
  } else {
    $_SESSION['login_error'] = "Nombre de usuario o contraseña inválidos.";
    header("location: login_error.php");
    exit();
  }
}
?>