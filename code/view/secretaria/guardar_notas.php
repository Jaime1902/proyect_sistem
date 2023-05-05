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

  // Verificar si ya existen registros para los alumnos y la asignatura seleccionados
$query = "SELECT * FROM calificaciones WHERE id_grado='$id_grado' AND id_asignatura='$id_asignatura'";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    // Si ya existen registros, actualizarlos
    foreach ($notas_semestre1 as $id_alumno => $nota_semestre1) {
        $nota_semestre2 = $notas_semestre2[$id_alumno];
        $nota_semestre3 = $notas_semestre3[$id_alumno];
        $nota_semestre4 = $notas_semestre4[$id_alumno];
        
        // Calcular el promedio final solo con las notas que se hayan enviado
        $notas = array();
        if ($nota_semestre1 !== "") {
            $notas[] = intval($nota_semestre1);
        }
        if ($nota_semestre2 !== "") {
            $notas[] = intval($nota_semestre2);
        }
        if ($nota_semestre3 !== "") {
            $notas[] = intval($nota_semestre3);
        }
        if ($nota_semestre4 !== "") {
            $notas[] = intval($nota_semestre4);
        }
        $promedio_final = count($notas) > 0 ? array_sum($notas) / count($notas) : null;

        // Actualizar las notas de los semestres que se hayan enviado
        $query = "UPDATE calificaciones SET ";
        $query .= $nota_semestre1 !== "" ? "semestre1='".intval($nota_semestre1)."', " : "semestre1=NULL, ";
        $query .= $nota_semestre2 !== "" ? "semestre2='".intval($nota_semestre2)."', " : "semestre2=NULL, ";
        $query .= $nota_semestre3 !== "" ? "semestre3='".intval($nota_semestre3)."', " : "semestre3=NULL, ";
        $query .= $nota_semestre4 !== "" ? "semestre4='".intval($nota_semestre4)."', " : "semestre4=NULL, ";
        $query .= $promedio_final !== null ? "promedio_final='".round($promedio_final, 2)."' " : "promedio_final=NULL ";
        $query .= "WHERE id_alumno='$id_alumno' AND id_grado='$id_grado' AND id_asignatura='$id_asignatura'";

        // Ejecutar la consulta
        if (!$conexion->query($query)) {
            echo 'Error al actualizar las notas: ' . $conexion->error;
            exit();
        }
    }
} else {
    // Si no existen registros, insertar nuevos registros
    foreach ($notas_semestre1 as $id_alumno => $nota_semestre1) {
        $nota_semestre2 = $notas_semestre2[$id_alumno];
        $nota_semestre3 = $notas_semestre3[$id_alumno];
        $nota_semestre4 = $notas_semestre4[$id_alumno];
        
        // Calcular el promedio final solo con las notas que se hayan enviado
        $notas = array();
        if ($nota_semestre1 !== "") {
            $notas[] = intval($nota_semestre1);
        }
        if ($nota_semestre2 !== "") {
            $notas[] = intval($nota_semestre2);
        }
        if ($nota_semestre3 !== "") {
            $notas[] = intval($nota_semestre3);
        }
        if ($nota_semestre4 !== "") {
            $notas[] = intval($nota_semestre4);
        }
        $promedio_final = count($notas) > 0 ? array_sum($notas) / count($notas) : null;

        // Insertar un nuevo registro
        $query = "INSERT INTO calificaciones (id_alumno, id_grado, id_asignatura, semestre1, semestre2, semestre3, semestre4, promedio_final) VALUES ('$id_alumno', '$id_grado', '$id_asignatura', ";
        $query .= $nota_semestre1 !== "" ? "'".intval($nota_semestre1)."', " : "NULL, ";
        $query .= $nota_semestre2 !== "" ? "'".intval($nota_semestre2)."', " : "NULL, ";
        $query .= $nota_semestre3 !== "" ? "'".intval($nota_semestre3)."', " : "NULL, ";
        $query .= $nota_semestre4 !== "" ? "'".intval($nota_semestre4)."', " : "NULL, ";
        $query .= $promedio_final !== null ? "'".round($promedio_final, 2)."')" : "NULL)";

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
    header('Location: evaluar.php?id_asignatura=' . $id_asignatura .'&id_grado=' . $id_grado);
    exit();
?>