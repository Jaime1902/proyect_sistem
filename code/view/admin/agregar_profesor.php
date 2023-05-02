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

// Iniciar transacción
mysqli_begin_transaction($conexion);

try {
    // Insertar los datos en la tabla "profesores"
    $consulta = "INSERT INTO profesores (nombre, apellido, correo_electronico, telefono, direccion, certificaciones, carrera_universitaria) 
                 VALUES ('$nombre', '$apellido', '$correo_electronico', '$telefono', '$direccion', '$certificaciones', '$carrera_universitaria')";
    $resultado = mysqli_query($conexion, $consulta);

    if (!$resultado) {
        throw new Exception(mysqli_error($conexion));
    }

    // Obtener el ID del profesor insertado
    $id_profesor = mysqli_insert_id($conexion);

    // Insertar los datos en la tabla "profesores_grados"
    foreach ($grados as $id_grado) {
        $consulta = "INSERT INTO profesores_grados (id_profesor, id_grado) 
                     VALUES ('$id_profesor', '$id_grado')";
        $resultado = mysqli_query($conexion, $consulta);

        if (!$resultado) {
            throw new Exception(mysqli_error($conexion));
        }
    }

    // Insertar los datos en la tabla "profesores_asignaturas"
    foreach ($asignaturas as $id_asignatura) {
        $consulta = "INSERT INTO profesores_asignaturas (id_profesor, id_asignatura) 
                     VALUES ('$id_profesor', '$id_asignatura')";
        $resultado = mysqli_query($conexion, $consulta);

        if (!$resultado) {
            throw new Exception(mysqli_error($conexion));
        }
    }

    // Confirmar transacción
    mysqli_commit($conexion);

    echo "Profesor agregado exitosamente";
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);

    echo "Error al agregar profesor: " . $e->getMessage();
}

mysqli_close($conexion);
?>
