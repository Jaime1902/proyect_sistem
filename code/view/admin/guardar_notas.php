<?php
    // Conexión a la base de datos
    include "../../conexion.php";

    // Comprobar la conexión
    if ($conexion->connect_errno) {
        echo 'Error en la conexión: ' . $conexion->connect_error;
        exit();
    }

    // Obtener los datos del grado y la asignatura seleccionados
    $id_grado = $_GET['id_grado'];
    $id_asignatura = $_GET['id_asignatura'];

    // Recuperar las notas enviadas por el formulario
    $notas_semestre1 = $_POST['semestre1'];
    $notas_semestre2 = $_POST['semestre2'];
    $notas_semestre3 = $_POST['semestre3'];
    $notas_semestre4 = $_POST['semestre4'];

    // Validar las notas enviadas por el formulario
    foreach ($notas_semestre1 as $id_alumno => $nota) {
        if ($nota < 0 || $nota > 100) {
            echo 'La nota del primer semestre para el alumno ' . $id_alumno . ' no es válida.';
            exit();
        }
    }

    foreach ($notas_semestre2 as $id_alumno => $nota) {
        if ($nota < 0 || $nota > 100) {
            echo 'La nota del segundo semestre para el alumno ' . $id_alumno . ' no es válida.';
            exit();
        }
    }

    foreach ($notas_semestre3 as $id_alumno => $nota) {
        if ($nota < 0 || $nota > 100) {
            echo 'La nota del tercer semestre para el alumno ' . $id_alumno . ' no es válida.';
            exit();
        }
    }

    foreach ($notas_semestre4 as $id_alumno => $nota) {
        if ($nota < 0 || $nota > 100) {
            echo 'La nota del cuarto semestre para el alumno ' . $id_alumno . ' no es válida.';
            exit();
        }
    }

    // Guardar las notas en la base de datos
    foreach ($notas_semestre1 as $id_alumno => $nota_semestre1) {
        $nota_semestre2 = $notas_semestre2[$id_alumno];
        $nota_semestre3 = $notas_semestre3[$id_alumno];
        $nota_semestre4 = $notas_semestre4[$id_alumno];
        $promedio_final = ($nota_semestre1 + $nota_semestre2 + $nota_semestre3 + $nota_semestre4) / 4;

        // Verificar si ya existe una nota para el alumno en la asignatura y el grado seleccionados
        $query = "SELECT * FROM calificaciones WHERE id_alumno='$id_alumno' AND id_grado='$id_grado' AND id_asignatura='$id_asignatura'";
        $resultado = $conexion->query($query);

        if ($resultado->num_rows > 0) {
            // Si ya existe una nota, actualizarla
            $query = "UPDATE calificaciones SET semestre1='$nota_semestre1', semestre2='$nota_semestre2 ', semestre3='$nota_semestre3', semestre4='$nota_semestre4', promedio_final='$promedio_final' WHERE id_alumno='$id_alumno' AND id_grado='$id_grado' AND id_asignatura='$id_asignatura'";
        } else {
        // Si no existe una nota, insertar una nueva
        $query = "INSERT INTO calificaciones (id_alumno, id_grado, id_asignatura, semestre1, semestre2, semestre3, semestre4, promedio_final) VALUES ('$id_alumno', '$id_grado', '$id_asignatura', '$nota_semestre1', '$nota_semestre2', '$nota_semestre3', '$nota_semestre4', '$promedio_final')";
        }
         // Ejecutar la consulta
    if (!$conexion->query($query)) {
        echo 'Error al guardar las notas: ' . $conexion->error;
        exit();
    }
}

// Cerrar la conexión
$conexion->close();

// Redirigir al usuario a la página de calificaciones
header('Location: evaluar.php?id_asignatura=' . $id_asignatura .'&id_grado=' . $id_grado);
exit();
?>
