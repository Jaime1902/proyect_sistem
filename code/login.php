<?php
session_start();

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Verificar que el nombre de usuario tenga una longitud válida
  if (strlen($username) < 3 || strlen($username) > 50) {
    $_SESSION['login_error'] = "El nombre de usuario debe tener entre 3 y 50 caracteres";
    header("location: login_error.php");
  }
  // Verificar que la contraseña tenga una longitud válida
  elseif (strlen($password) < 8 || strlen($password) > 20) {
    $_SESSION['login_error'] = "Contraseña inválida.";
    header("location: login_error.php");
  }
  // Verificar que el nombre de usuario y la contraseña contengan solo caracteres seguros
  elseif (!preg_match("/^[a-zA-Z0-9_-]+$/", $username) || !preg_match("/^[a-zA-Z0-9_-]+$/", $password)) {
    $_SESSION['login_error'] = "Nombre de usuario o contraseña inválidos.";
    header("location: login_error.php");
  } else {
    // Convertir la contraseña en un hash
    $password_hash = hash('sha256', $password);

    // Preparar la consulta
    $stmt = $conexion->prepare("SELECT * FROM login WHERE username=? AND password_hash=?");
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
      $fila = $resultado->fetch_assoc();
      $_SESSION['username'] = $fila['username'];
      $_SESSION['role'] = $fila['role'];
      
      if ($_SESSION['role'] == 'administrador') {
        header("location: view\admin\admin.php");
      } elseif ($_SESSION['role'] == 'secretaria') {
        header("location: view\secretaria\secret.php");
      }
    } else {
      $_SESSION['login_error'] = "Nombre de usuario o contraseña incorrectos.";
      header("location: login_error.php");
    }
  }
}
?>
