<?php
// Conexión a la base de datos
include"../../conexion.php";

// Verificación de conexión
if (mysqli_connect_errno()) {
	echo "Error al conectarse a MySQL: " . mysqli_connect_error();
	exit();
}

// Recopilación de los datos del formulario
$id_alumno = $_POST['id_alumno_id'];
$fecha_pago = $_POST['fecha_pago'];
$monto = $_POST['monto'];

// Consulta de inserción de la mensualidad en la base de datos
$query = "INSERT INTO mensualidades (id_alumno, fecha_pago, monto) VALUES ($id_alumno, '$fecha_pago', $monto)";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
	echo "Mensualidad guardada correctamente";
} else {
	echo "Error al guardar la mensualidad";
}

// Cierre de la conexión a la base de datos
mysqli_close($conexion);
?>
