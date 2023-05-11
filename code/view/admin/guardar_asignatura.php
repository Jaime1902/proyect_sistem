<?php
// Conexión a la base de datos
include "../../conexion.php";

// Verificación de conexión
if (mysqli_connect_errno()) {
    echo "Error al conectarse a MySQL: " . mysqli_connect_error();
    exit();
}

// Recopilación de datos del formulario
$nombre_asignatura = $_POST['nombre_asignatura'];
$id_grado = $_POST['id_grado'];

// Consulta preparada con marcadores de posición
$stmt = $conexion->prepare("INSERT INTO asignaturas (nombre_asignatura, id_grado) VALUES (?, ?)");
$stmt->bind_param("si", $nombre_asignatura, $id_grado);

// Ejecución de la consulta
if ($stmt->execute()) {
    header("Location: lobby_cursos.php");
} else {
    echo "Error al guardar la asignatura: " . $stmt->error;
}

// Cierre de la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
