<?php
// Conexión a la base de datos
include "../../conexion.php";

// Verificamos si la conexión fue exitosa
if (!$conexion) {
    die("La conexión ha fallado: " . mysqli_connect_error());
}

// Recuperamos las asignaturas seleccionadas
$asignaturas = $_POST['asignaturas'];

// Construimos la consulta SQL para obtener los grados disponibles
$query = "SELECT DISTINCT grados.id_grado, grados.nombre FROM grados
          JOIN asignaturas_grados ON grados.id_grado = asignaturas_grados.id_grado
          WHERE asignaturas_grados.id_asignatura IN (" . implode(',', $asignaturas) . ")
          ORDER BY grados.nombre ASC";

$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error al obtener los grados: " . mysqli_error($conexion));
}

// Construimos las opciones HTML para el elemento select de grados
$options = '';
while ($fila = mysqli_fetch_assoc($resultado)) {
    $selected = in_array($fila['id_grado'], $grado) ? 'selected' : '';
    $options .= "<option value='{$fila['id_grado']}' $selected>{$fila['nombre']}</option>";
}

echo $options;
?>
