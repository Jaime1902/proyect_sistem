<?php
include("header.php");
include "../../conexion.php";

// Variable para almacenar mensajes de éxito o error
$mensaje = "";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validar los campos del formulario (aquí puedes agregar tus propias validaciones según tus requisitos)
  if (empty($_POST['nombre_grado'])) {
    $mensaje = "El campo Nombre de Grado es obligatorio.";
  } else {
    $nombre_grado = mysqli_real_escape_string($conexion, $_POST['nombre_grado']);
  
    // Insertar el grado en la tabla
    $insertar_grado = "INSERT INTO grados (nombre_grado) VALUES ('$nombre_grado')";
    if (mysqli_query($conexion, $insertar_grado)) {
      $mensaje = "El grado se ha guardado exitosamente.";
    } else {
      $mensaje = "Error al guardar el grado: " . mysqli_error($conexion);
    }
  }
}
?>

<!-- Resto del código HTML y estilos -->
<br><br>
<form class="panel-form" action="" method="POST">
<h2>Guardar Grado</h2>
  <label for="nombre_grado">Nombre de Grado:</label>
  <input type="text" id="nombre_grado" name="nombre_grado" required>

  <input type="submit" value="Guardar">
</form>

<p><?php echo $mensaje; ?></p>

<?php mysqli_close($conexion); ?>

<!-- Resto del código HTML y estilos -->
