<?php
include "../../conexion.php";

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo_electronico = $_POST['correo_electronico'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$certificaciones = $_POST['certificaciones'];
$carrera_universitaria = $_POST['carrera_universitaria'];
$grados = $_POST['grado'];
$asignaturas = $_POST['asignatura'];
$username = $_POST['username'];
$password = $_POST['password'];

// Hash de la contraseña
$hashed_password = hash('sha256', $password);

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // Insertar los datos en la tabla "login"
    $stmt = $conexion->prepare("INSERT INTO login (username, password_hash, role) VALUES (?, ?, ?)");
    $role = "profesor";
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    if (!$stmt->execute()) {
        throw new Exception(mysqli_error($conexion));
    }

    // Obtener el ID del usuario insertado
    $id_usuario = $stmt->insert_id;

    // Insertar los datos en la tabla "profesores"
    $stmt = $conexion->prepare("INSERT INTO profesores (nombre, apellido, correo_electronico, telefono, direccion, certificaciones, carrera_universitaria, login_id) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $nombre, $apellido, $correo_electronico, $telefono, $direccion, $certificaciones, $carrera_universitaria, $id_usuario);
    if (!$stmt->execute()) {
        throw new Exception(mysqli_error($conexion));
    }

    // Obtener el ID del profesor insertado
    $id_profesor = $stmt->insert_id;

    // Insertar los datos en la tabla "profesores_grados"
    foreach ($grados as $id_grado) {
        $stmt = $conexion->prepare("INSERT INTO profesores_grados (id_profesor, id_grado) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_profesor, $id_grado);
        if (!$stmt->execute()) {
            throw new Exception(mysqli_error($conexion));
        }
    }

    // Insertar los datos en la tabla "profesores_asignaturas"
    foreach ($asignaturas as $id_asignatura) {
        $stmt = $conexion->prepare("INSERT INTO profesores_asignaturas (id_profesor, id_asignatura) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_profesor, $id_asignatura);
        if (!$stmt->execute()) {
            throw new Exception(mysqli_error($conexion));
        }
    }

    // Confirmar transacción
    mysqli_commit($conexion);

    header("Location: lobby_profesor.php");
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);

    echo "Error al agregar profesor: " . $e->getMessage();
}

$stmt->close();
$conexion->close();
?>