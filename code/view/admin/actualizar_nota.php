<?php
// Conexión a la base de datos
include "../../conexion.php";

// Comprobar la conexión
if ($conexion->connect_errno) {
    echo 'Error en la conexión: ' . $conexion->connect_error;
    exit();
}

// Obtener el id de la calificación a actualizar
$id_calificacion = $_POST['id_calificacion'];

// Obtener las notas a través de $_POST
$semestre1 = $_POST['semestre1'];
$semestre2 = $_POST['semestre2'];
$semestre3 = $_POST['semestre3'];
$semestre4 = $_POST['semestre4'];

// Calcular el promedio final
$promedio_final = ($semestre1 + $semestre2 + $semestre3 + $semestre4) / 4;

// Actualizar la calificación en la base de datos
$query = "UPDATE calificaciones SET semestre1 = " . $semestre1 . ", semestre2 = " . $semestre2 . ", semestre3 = " . $semestre3 . ", semestre4 = " . $semestre4 . ", promedio_final = " . $promedio_final . " WHERE id_calificacion = " . $id_calificacion;

if ($conexion->query($query)) {
    // Si la actualización se realizó correctamente, redirigir a la página de calificación
    header("Location: calificaciones.php");
} else {
    // Si hubo un error en la actualización, mostrar un mensaje de error
    echo "Error al actualizar la calificación: " . $conexion->error;
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
