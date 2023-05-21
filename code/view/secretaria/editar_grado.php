<?php
include("header.php");
include "../../conexion.php";

// Verificar si se ha proporcionado un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id_grado = $_GET['id'];

  // Verificar si se ha enviado el formulario de edición
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el nuevo nombre del grado desde el formulario
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nombre_grado']);

    // Actualizar el nombre del grado en la base de datos
    $consulta = "UPDATE grados SET nombre_grado = '$nuevo_nombre' WHERE id_grado = $id_grado";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si se ha actualizado el grado correctamente
    if ($resultado) {
      echo "Grado actualizado correctamente.";
    } else {
      echo "Error al actualizar el grado. Por favor, inténtalo de nuevo.";
    }
  }

  // Obtener los datos actuales del grado
  $consulta_grado = "SELECT nombre_grado FROM grados WHERE id_grado = $id_grado";
  $resultado_grado = mysqli_query($conexion, $consulta_grado);
  $fila_grado = mysqli_fetch_assoc($resultado_grado);
  $nombre_grado_actual = $fila_grado['nombre_grado'];
} else {
  echo "ID de grado no válido.";
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Editar Grado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    form {
      margin: 20px;
    }
    input[type="text"] {
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ddd;
    }
    button[type="submit"] {
      padding: 10px;
      font-size: 16px;
      background-color: #333;
      color: #fff;
      border-radius: 5px;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <br><br>
  <form class="panel-form" action="" method="POST">
  <h1>Editar Grado</h1>
    <label for="nombre_grado">Nombre del Grado:</label><br>
    <input type="text" id="nombre_grado" name="nombre_grado" value="<?php echo $nombre_grado_actual; ?>"><br><br>
    <button type="submit">Guardar</button>
  </form>
</body>
</html>
