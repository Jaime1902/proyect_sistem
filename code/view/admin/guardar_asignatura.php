<?php
// Conexión a la base de datos
include"../../conexion.php";
// Verificación de conexión
if (mysqli_connect_errno()) {
	echo "Error al conectarse a MySQL: " . mysqli_connect_error();
	exit();
}

// Recopilación de datos del formulario
$nombre_asignatura = $_POST['nombre_asignatura'];
$id_grado = $_POST['id_grado'];

// Consulta de inserción de datos
$query = "INSERT INTO asignaturas (nombre_asignatura, id_grado) VALUES ('$nombre_asignatura', $id_grado)";
$resultado = mysqli_query($conexion, $query);

// Verificación del resultado de la inserción
if ($resultado) {
	echo "La asignatura se ha guardado correctamente.";
} else {
	echo "Error al guardar la asignatura: " . mysqli_error($conexion);
}

// Cierre de la conexión a la base de datos
mysqli_close($conexion);
?>
