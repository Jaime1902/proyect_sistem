<?php
    // Conexión a la base de datos
    include "../../conexion.php";

    // Obtener el ID de la asignatura a eliminar
    $id_asignatura = $_GET['id'];

    // Eliminar la asignatura de la base de datos
    $query = "DELETE FROM asignaturas WHERE id_asignatura = $id_asignatura";
    $result = $conexion->query($query);

    // Redirigir a la lista de asignaturas
    header('Location: view_cursos.php');
    exit;
?>