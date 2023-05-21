<?php
include "../../conexion.php";

// Verificar si se ha proporcionado un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id_grado = $_GET['id'];

  // Eliminar el grado de la base de datos
  $consulta = "DELETE FROM grados WHERE id_grado = $id_grado";
  $resultado = mysqli_query($conexion, $consulta);

  // Verificar si se ha eliminado el grado correctamente
  if ($resultado) {
    header("Location: view_grados.php");
  } else {
    echo "Error al eliminar el grado. Por favor, inténtalo de nuevo.";
  }
} else {
  echo "ID de grado no válido.";
}

mysqli_close($conexion);
