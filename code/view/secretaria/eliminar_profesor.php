<?php
include "../../conexion.php";

if (isset($_GET['id'])) {
  $id_profesor = $_GET['id'];

  // Eliminar los registros de profesores_grados
  $consulta_grados = "DELETE FROM profesores_grados WHERE id_profesor = $id_profesor";
  mysqli_query($conexion, $consulta_grados);

  // Eliminar los registros de profesores_asignaturas
  $consulta_asignaturas = "DELETE FROM profesores_asignaturas WHERE id_profesor = $id_profesor";
  mysqli_query($conexion, $consulta_asignaturas);

  // Eliminar el registro del profesor
  $consulta_profesor = "DELETE FROM profesores WHERE id_profesor = $id_profesor";
  mysqli_query($conexion, $consulta_profesor);

  // Redirigir a la página de lista de profesores
  header("Location: view_prof.php");
  exit();
}

mysqli_close($conexion);
?>