<?php
include '../../conexion.php'; // Archivo con la conexión a la base de datos

include("header.php"); //incluya la medida de seguridad



// Recibimos los datos del formulario y los almacenamos en variables
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$lugar_nacimiento = $_POST['lugar_nacimiento'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$codigo_estudiante = $_POST['codigo_estudiante'];
$id_grado = $_POST['id_grado'];
$fecha_inscripcion = $_POST['fecha_inscripcion'];
$padecimiento_alergia = $_POST['padecimiento_alergia'];
$nombre_padre = $_POST['nombre_padre'];
$nombre_madre = $_POST['nombre_madre'];
$cedula_padre = $_POST['cedula_padre'];
$cedula_madre = $_POST['cedula_madre'];
$telefono_emergencia = $_POST['telefono_emergencia'];
$ocupacion_padre = $_POST['ocupacion_padre'];
$ocupacion_madre = $_POST['ocupacion_madre'];
$direccion_exacta = $_POST['direccion_exacta'];

// Creamos la consulta para insertar los datos en la base de datos
$sql = "INSERT INTO alumnos (nombre, apellidos, lugar_nacimiento, fecha_nacimiento, codigo_estudiante, id_grado, fecha_inscripcion, padecimiento_alergia, nombre_padre, nombre_madre, cedula_padre, cedula_madre, telefono_emergencia, ocupacion_padre, ocupacion_madre, direccion_exacta) VALUES ('$nombre', '$apellidos', '$lugar_nacimiento', '$fecha_nacimiento', '$codigo_estudiante', '$id_grado', '$fecha_inscripcion', '$padecimiento_alergia', '$nombre_padre', '$nombre_madre', '$cedula_padre', '$cedula_madre', '$telefono_emergencia', '$ocupacion_padre', '$ocupacion_madre', '$direccion_exacta')";

// Ejecutamos la consulta y verificamos si se insertaron los datos correctamente
if ($conexion->query($sql) === TRUE) {
    echo "El alumno ha sido agregado correctamente";
} else {
    echo "Error al agregar al alumno: " ;
}

// Cerramos la conexión a la base de datos
$conexion->close();
?>
