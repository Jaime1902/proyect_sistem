<?php
include '../../conexion.php'; // Archivo con la conexión a la base de datos

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
$username = $_POST['username'];
$raw_password = $_POST['password'];

// Hasheamos la contraseña usando SHA2
$hashed_password = hash('sha256', $raw_password);

// Creamos la consulta preparada para insertar el registro en la tabla `login`
$stmt_login = $conexion->prepare("INSERT INTO login (username, password_hash, role) VALUES (?, ?, ?)");
$role = "alumno"; // asumimos que el nuevo usuario es un alumno
$stmt_login->bind_param("sss", $username, $hashed_password, $role);

// Ejecutamos la consulta para insertar el registro en la tabla `login`
if (!$stmt_login->execute()) {
    echo "Error al agregar al alumno: " . $stmt_login->error;
    $stmt_login->close();
    $conexion->close();
    exit();
}

// Obtenemos el valor del `id` generado por la tabla `login` para asignarlo a la llave foránea `login_id` en la tabla `alumnos`
$login_id = $stmt_login->insert_id;

// Creamos la consulta preparada para insertar el registro en la tabla `alumnos`
$stmt_alumnos = $conexion->prepare("INSERT INTO alumnos (nombre, apellidos, lugar_nacimiento, fecha_nacimiento, codigo_estudiante, id_grado, fecha_inscripcion, padecimiento_alergia, nombre_padre, nombre_madre, cedula_padre, cedula_madre, telefono_emergencia, ocupacion_padre, ocupacion_madre, direccion_exacta, login_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt_alumnos->bind_param("sssssissssssssssi", $nombre, $apellidos, $lugar_nacimiento, $fecha_nacimiento, $codigo_estudiante, $id_grado, $fecha_inscripcion, $padecimiento_alergia, $nombre_padre, $nombre_madre, $cedula_padre, $cedula_madre, $telefono_emergencia, $ocupacion_padre, $ocupacion_madre, $direccion_exacta, $login_id);

// Ejecutamos la consulta para insertar el registro en la tabla `alumnos`
if ($stmt_alumnos->execute()) {
    echo "El alumno ha sido agregado correctamente";
} else {
    echo "Error al agregar al alumno: " . $stmt_alumnos->error;
}

// Cerramos las consultas preparadas y la conexión a la base de datos
$stmt_login->close();
$stmt_alumnos->close();
$conexion->close();
?>