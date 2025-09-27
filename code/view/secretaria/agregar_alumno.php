<?php
session_start(); // Asegúrate de iniciar la sesión
include '../../conexion.php';

// Recibimos los datos del formulario
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
$username = $_POST['username'];
$raw_password = $_POST['password'];

// Hasheamos la contraseña
$hashed_password = hash('sha256', $raw_password);

// Verificar si el nombre de usuario ya existe
$stmt_check_username = $conexion->prepare("SELECT id FROM login WHERE username = ?");
$stmt_check_username->bind_param("s", $username);
$stmt_check_username->execute();
$stmt_check_username->store_result();

if ($stmt_check_username->num_rows > 0) {
    $_SESSION['error'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
    header("Location: give_alumno.php"); // Cambia a la página del formulario
    exit();
}
$stmt_check_username->close();

// Inserción en `login`
$stmt_login = $conexion->prepare("INSERT INTO login (username, password_hash, role) VALUES (?, ?, ?)");
$role = "alumno";
$stmt_login->bind_param("sss", $username, $hashed_password, $role);

if (!$stmt_login->execute()) {
    $_SESSION['error'] = "Error al agregar al alumno: " . $stmt_login->error;
    header("Location: 403.php");
    exit();
}

$login_id = $stmt_login->insert_id;

// Inserción en `alumnos`
$stmt_alumnos = $conexion->prepare("INSERT INTO alumnos (nombre, apellidos, lugar_nacimiento, fecha_nacimiento, codigo_estudiante, id_grado, fecha_inscripcion, padecimiento_alergia, nombre_padre, nombre_madre, cedula_padre, cedula_madre, telefono_emergencia, ocupacion_padre, ocupacion_madre, direccion_exacta, login_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt_alumnos->bind_param("sssssissssssssssi", $nombre, $apellidos, $lugar_nacimiento, $fecha_nacimiento, $codigo_estudiante, $id_grado, $fecha_inscripcion, $padecimiento_alergia, $nombre_padre, $nombre_madre, $cedula_padre, $cedula_madre, $telefono_emergencia, $ocupacion_padre, $ocupacion_madre, $direccion_exacta, $login_id);

if ($stmt_alumnos->execute()) {
    $_SESSION['success'] = "El alumno se agregó correctamente.";
    header("Location: give_alumno.php");
} else {
    $_SESSION['error'] = "Error al agregar al alumno: " . $stmt_alumnos->error;
    header("Location: 403.php");
}

$stmt_login->close();
$stmt_alumnos->close();
$conexion->close();
?>
