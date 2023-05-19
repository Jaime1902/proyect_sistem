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

// Insertar o actualizar los registros de calificaciones para cada alumno
foreach ($notas_semestre1 as $id_alumno => $nota_semestre1) {
    $nota_semestre2 = $notas_semestre2[$id_alumno];
    $nota_semestre3 = $notas_semestre3[$id_alumno];
    $nota_semestre4 = $notas_semestre4[$id_alumno];

    // Verificar si el registro de calificaciones ya existe
    $query = "SELECT COUNT(*) FROM calificaciones WHERE id_alumno='$id_alumno' AND id_grado='$id_grado' AND id_asignatura='$id_asignatura'";
    $result = $conexion->query($query);
    $row = $result->fetch_row();
    $count = $row[0];

    if ($count == 0) {
        // El registro de calificaciones no existe, insertar un nuevo registro
        $query = "INSERT INTO calificaciones (id_alumno, id_grado, id_asignatura, semestre1, semestre2, semestre3, semestre4, promedio_final) VALUES ('$id_alumno', '$id_grado', '$id_asignatura', ";
        $query .= $nota_semestre1 !== "" ? "'".intval($nota_semestre1)."', " : "NULL, ";
        $query .= $nota_semestre2 !== "" ? "'".intval($nota_semestre2)."', " : "NULL, ";
        $query .= $nota_semestre3 !== "" ? "'".intval($nota_semestre3)."', " : "NULL, ";
        $query .= $nota_semestre4 !== "" ? "'".intval($nota_semestre4)."', " : "NULL, ";
        $query .= "NULL)";

        // Ejecutar la consulta
        if (!$conexion->query($query)) {
            echo 'Error al guardar las notas: ' . $conexion->error;
            exit();
        }
    } else {
        // El registro de calificaciones ya existe, no se actualiza ningún dato si ya tienen valor
        $query = "UPDATE calificaciones SET ";
        $query .= $nota_semestre1 !== "" ? "semestre1=IF(semestre1 IS NULL, '".intval($nota_semestre1)."', semestre1), " : "";
        $query .= $nota_semestre2 !== "" ? "semestre2=IF(semestre2 IS NULL, '".intval($nota_semestre2)."', semestre2), " : "";
        $query .= $nota_semestre3 !== "" ? "semestre3=IF(semestre3 IS NULL, '".intval($nota_semestre3)."', semestre3), " : "";
        $query .= $nota_semestre4 !== "" ? "semestre4=IF(semestre4 IS NULL, '".intval($nota_semestre4)."', semestre4), " : "";
        $query .= "promedio_final=NULL ";
        $query .= "WHERE id_alumno='$id_alumno' AND id_grado='$id_grado' AND id_asignatura='$id_asignatura'";

        // Ejecutar la consulta
        if (!$conexion->query($query)) {
            echo 'Error al guardar las notas: ' . $conexion->error;
            exit();
        }
    }
}

// Cerrar la conexión
$conexion->close();

// Redirigir al usuario a la página de calificaciones
header('Location: calificar.php?id_asignatura=' . $id_asignatura .'&id_grado=' . $id_grado);
exit();
?>
