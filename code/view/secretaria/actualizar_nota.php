<?php
    // Conexión a la base de datos
    include "../../conexion.php";

    // Obtener los datos de la calificación a actualizar
    $id_calificacion = $_POST['id_calificacion'];
    $query = "SELECT * FROM calificaciones WHERE id_calificacion = " . $id_calificacion;
    $result = $conexion->query($query);
    $row = $result->fetch_assoc();
    if (!$row) {
        echo 'La calificación no existe';
        exit();
    }

    $semestre1 = $row['semestre1'];
    $semestre2 = $row['semestre2'];
    $semestre3 = $row['semestre3'];
    $semestre4 = $row['semestre4'];

    // Verificar si se desea actualizar algún semestre
    if (!isset($_POST['semestre1']) && !isset($_POST['semestre2']) && !isset($_POST['semestre3']) && !isset($_POST['semestre4'])) {
        echo 'No se especificó ningún valor a actualizar';
        exit();
    }

    // Convertir los valores vacíos en NULL
    $_POST['semestre1'] = $_POST['semestre1'] !== '' ? $_POST['semestre1'] : null;
    $_POST['semestre2'] = $_POST['semestre2'] !== '' ? $_POST['semestre2'] : null;
    $_POST['semestre3'] = $_POST['semestre3'] !== '' ? $_POST['semestre3'] : null;
    $_POST['semestre4'] = $_POST['semestre4'] !== '' ? $_POST['semestre4'] : null;

    // Actualizar la calificación en la base de datos
    $query = "UPDATE calificaciones SET ";
    $params = array();

    if (isset($_POST['semestre1']) && $row['semestre1'] !== $_POST['semestre1']) {
        $query .= "semestre1 = ?, ";
        $params[] = &$_POST['semestre1'];
    }
    if (isset($_POST['semestre2']) && $row['semestre2'] !== $_POST['semestre2']) {
        $query .= "semestre2 = ?, ";
        $params[] = &$_POST['semestre2'];
    }
    if (isset($_POST['semestre3']) && $row['semestre3'] !== $_POST['semestre3']) {
        $query .= "semestre3 = ?, ";
        $params[] = &$_POST['semestre3'];
    }
    if (isset($_POST['semestre4']) && $row['semestre4'] !== $_POST['semestre4']) {
        $query .= "semestre4 = ?, ";
        $params[] = &$_POST['semestre4'];
    }

    // Eliminar la última coma y espacio en $query
    $query = rtrim($query, ', ');

    // Agregar la cláusula WHERE
    $query .= " WHERE id_calificacion = ?";
    $params[] = &$_POST['id_calificacion'];

    // Preparar la consulta
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        echo 'Error al preparar la consulta: ' . $conexion->error;
        exit();
    }

    // Agregar los parámetros
    $types = '';
    foreach ($params as $param) {
        if (is_int($param)) {
            $types .= 'i';
        } elseif (is_float($param)) {
            $types .= 'd';
        } elseif (is_null($param)) {
            $types .= 's';
            $param = null;
        } elseif (is_string($param)) {
            $types .= 's';
        } else {
            $types .= 'b';
        }
    }
    array_unshift($params, $types);
    call_user_func_array(array($stmt, 'bind_param'), $params);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        echo 'Error al ejecutar la consulta: ' . $stmt->error;
        exit();
    }

    // Verificar si se actualizó alguna fila
    if ($stmt->affected_rows === 0) {
        echo 'No se actualizó ninguna fila';
    } else {
      header('Location: editar_nota.php?id_calificacion=' . $id_calificacion);
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conexion->close();
?>