<?php
session_start();
// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] == 'administrador')) {
  header("location: admin/index.php");
  exit;
}elseif(!isset($_SESSION['username']) || ($_SESSION['role'] == 'secretaria')){
    header("location: secretaria/index.php");
  exit;
}elseif(!isset($_SESSION['username']) || ($_SESSION['role'] == 'alumno')){
    header("location: alumno/index.php");
  exit;
}elseif(!isset($_SESSION['username']) || ($_SESSION['role'] == 'profesor')){
    header("location: profesor/index.php");
  exit;
}

?>
