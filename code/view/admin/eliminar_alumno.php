<?php
include '../../conexion.php';

if (isset($_GET['id'])) {
	$id_alumno = $_GET['id'];

	// Eliminar registros de la tabla mensualidades
	$sql_mensualidades = "DELETE FROM mensualidades WHERE id_alumno = ?";
	$stmt_mensualidades = $conexion->prepare($sql_mensualidades);
	$stmt_mensualidades->bind_param("i", $id_alumno);
	$stmt_mensualidades->execute();

	// Eliminar registros de la tabla calificaciones
	$sql_calificaciones = "DELETE FROM calificaciones WHERE id_alumno = ?";
	$stmt_calificaciones = $conexion->prepare($sql_calificaciones);
	$stmt_calificaciones->bind_param("i", $id_alumno);
	$stmt_calificaciones->execute();

	// Eliminar registro de la tabla alumnos
	$sql_alumnos = "DELETE FROM alumnos WHERE id_alumno = ?";
	$stmt_alumnos = $conexion->prepare($sql_alumnos);
	$stmt_alumnos->bind_param("i", $id_alumno);
	$stmt_alumnos->execute();

	if ($stmt_mensualidades->affected_rows > 0 || $stmt_calificaciones->affected_rows > 0 || $stmt_alumnos->affected_rows > 0) {
		// Si se eliminaron registros de alguna tabla, redirigir a la lista de alumnos
		header('Location: view_alumno.php');
		exit;
	} else {
		echo "No se pudo eliminar el alumno.";
	}
} else {
	echo "ID de alumno no especificado.";
}
?>