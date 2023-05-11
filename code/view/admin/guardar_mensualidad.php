<?php
// Conexión a la base de datos
include "../../conexion.php";

// Verificación de conexión
if (mysqli_connect_errno()) {
    echo "Error al conectarse a MySQL: " . mysqli_connect_error();
    exit();
}

// Recopilación de los datos del formulario
$id_alumno = $_POST['id_alumno_id'];
$fecha_pago = $_POST['fecha_pago'];
$monto = $_POST['monto'];

// Consulta preparada con marcadores de posición
$stmt = $conexion->prepare("INSERT INTO mensualidades (id_alumno, fecha_pago, monto) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $id_alumno, $fecha_pago, $monto);

// Ejecución de la consulta
if ($stmt->execute()) {
    header("Location: mensualidad.php");
} else {
    echo "Error al guardar la mensualidad";
}

// Cierre de la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
