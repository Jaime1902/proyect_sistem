<?php
include "../../conexion.php";

// Verificar si se recibe el ID de la asignatura
if (isset($_GET['id'])) {
    $id_asignatura = $_GET['id'];

    // Iniciar transacción
    $conexion->begin_transaction();

    try {
        // Eliminar los registros en profesores_asignaturas
        $delete_profesores_asignaturas = "DELETE FROM profesores_asignaturas WHERE id_asignatura = ?";
        $stmt = $conexion->prepare($delete_profesores_asignaturas);
        $stmt->bind_param("i", $id_asignatura);
        $stmt->execute();

        // Eliminar las calificaciones relacionadas con esta asignatura
        $delete_calificaciones = "DELETE FROM calificaciones WHERE id_asignatura = ?";
        $stmt = $conexion->prepare($delete_calificaciones);
        $stmt->bind_param("i", $id_asignatura);
        $stmt->execute();

        // Eliminar la asignatura
        $delete_asignatura = "DELETE FROM asignaturas WHERE id_asignatura = ?";
        $stmt = $conexion->prepare($delete_asignatura);
        $stmt->bind_param("i", $id_asignatura);
        $stmt->execute();

        // Confirmar la transacción
        $conexion->commit();

        // Redirigir al usuario a la lista de asignaturas
        header("Location: view_cursos.php");
        exit();

    } catch (Exception $e) {
        // Si ocurre algún error, hacer rollback
        $conexion->rollback();
        echo "Error al eliminar la asignatura y sus registros relacionados: " . $e->getMessage();
    }
}
?>
