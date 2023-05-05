<?php
include "../../conexion.php";

if (isset($_POST['grado'])) {
    $grados = implode(",", $_POST['grado']);
    $consulta_asignaturas = "SELECT a.id_asignatura, a.nombre_asignatura, g.nombre_grado 
                             FROM asignaturas a 
                             INNER JOIN grados g ON a.id_grado = g.id_grado 
                             WHERE a.id_grado IN ($grados)";
    $resultado_asignaturas = mysqli_query($conexion, $consulta_asignaturas);
    if (mysqli_num_rows($resultado_asignaturas) > 0) {
        echo "<option value=''>Seleccione una asignatura</option>";
        while ($fila_asignaturas = mysqli_fetch_assoc($resultado_asignaturas)) {
            echo "<option value='" . $fila_asignaturas['id_asignatura'] . "'>" . $fila_asignaturas['nombre_asignatura'] . " (" . $fila_asignaturas['nombre_grado'] . ")</option>";
        }
    } else {
        echo "<option value=''>No se encontraron asignaturas</option>";
    }
}

mysqli_close($conexion);
?>
