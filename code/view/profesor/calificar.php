<!DOCTYPE html>
<html>
<head>
    <title>Calificar notas</title>
</head>
<style>


/* Estilos del contenedor de calificación de notas */
.calificar-notas-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    
    
}

.calificar-notas-title {
    margin-top: 0;
}

.calificar-notas-subtitle {
    margin-top: 20px;
    font-size: 1.2em;
}

/* Estilos de la tabla */
.calificar-notas-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.calificar-notas-table th,
.calificar-notas-table td {
    padding: 10px;
    text-align: left;
}

.calificar-notas-table th {
    background-color: #333;
    color: #fff;
}

.calificar-notas-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Estilos del botón de guardar */
.calificar-notas-submit {
    display: block;
    margin-top: 20px;
    padding: 10px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
}

.calificar-notas-submit:hover {
    background-color: #555;
}
</style>
<body>
    <?php include "header.php"; ?>
    <div class="calificar-notas-container">
        <h1 class="calificar-notas-title">Calificar notas</h1>

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

        // Obtener el nombre del grado
        $query = "SELECT nombre_grado FROM grados WHERE id_grado = " . $id_grado;
        $result = $conexion->query($query);
        $row = $result->fetch_assoc();
        $nombre_grado = $row['nombre_grado'];

        // Obtener el nombre de la asignatura
        $query = "SELECT nombre_asignatura FROM asignaturas WHERE id_asignatura = " . $id_asignatura;
        $result = $conexion->query($query);
        $row = $result->fetch_assoc();
        $nombre_asignatura = $row['nombre_asignatura'];

        // Obtener los alumnos del grado y la asignatura seleccionados
        $query = "SELECT a.id_alumno, a.nombre, n.id_calificacion, n.semestre1, n.semestre2, n.semestre3, n.semestre4 
                  FROM alumnos a 
                  INNER JOIN grados g ON a.id_grado = g.id_grado 
                  INNER JOIN asignaturas asi ON asi.id_asignatura = " . $id_asignatura . " 
                  LEFT JOIN calificaciones n ON n.id_alumno = a.id_alumno AND n.id_asignatura = " . $id_asignatura . "
                  WHERE g.id_grado = " . $id_grado;
        $result = $conexion->query($query);
        ?>

        <h2 class="calificar-notas-subtitle">Grado: <?php echo $nombre_grado; ?></h2>
        <h2 class="calificar-notas-subtitle">Asignatura: <?php echo $nombre_asignatura; ?></h2>

        <form method="post"
              action="guardar_notas.php?id_grado=<?php echo $id_grado; ?>&id_asignatura=<?php echo $id_asignatura; ?>"
              class="calificar-notas-form">
            <table class="calificar-notas-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del alumno</th>
                    <th>Nota 1er semestre</th>
                    <th>Nota 2do semestre</th>
                    <th>Nota 3er semestre</th>
                    <th>Nota 4to semestre</th>
                    <th>Promedio final</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php

                // Mostrar los alumnos en una tabla
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['id_alumno'] . '</td>';
                    echo '<td>' . $row['nombre'] . '</td>';

                    if (isset($row['id_calificacion'])) {
                        // Si el alumno ya tiene nota en esta asignatura, mostrarla
                        if (is_numeric($row['semestre1'])) {
                            echo '<td><input type="number" name="semestre1[' . $row['id_alumno'] . ']" value="' . $row['semestre1'] . '" readonly></td>';
                        } else {
                            echo '<td><input type="number" name="semestre1[' . $row['id_alumno'] . ']" value="' . $row['semestre1'] . '"></td>';
                        }

                        if (is_numeric($row['semestre2'])) {
                            echo '<td><input type="number" name="semestre2[' . $row['id_alumno'] . ']" value="' . $row['semestre2'] . '" readonly></td>';
                        } else {
                            echo '<td><input type="number" name="semestre2[' . $row['id_alumno'] . ']" value="' . $row['semestre2'] . '"></td>';
                        }

                        if (is_numeric($row['semestre3'])) {
                            echo '<td><input type="number" name="semestre3[' . $row['id_alumno'] . ']" value="' . $row['semestre3'] . '" readonly></td>';
                        } else {
                            echo '<td><input type="number" name="semestre3[' . $row['id_alumno'] . ']" value="' . $row['semestre3'] . '"></td>';
                        }

                        if (is_numeric($row['semestre4'])) {
                            echo '<td><input type="number" name="semestre4[' . $row['id_alumno'] . ']" value="' . $row['semestre4'] . '" readonly></td>';
                        } else {
                            echo '<td><input type="number" name="semestre4[' . $row['id_alumno'] . ']" value="' . $row['semestre4'] . '"></td>';
                        }
                        $promedio = ($row['semestre1'] + $row['semestre2'] + $row['semestre3'] + $row['semestre4']) / 4;
                        echo '<td>' . $promedio . '</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    } else {
                        // Si el alumno no tiene nota en esta asignatura, mostrar campos vacíos
                        echo '<td><input type="number" name="semestre1[' . $row['id_alumno'] . ']"></td>';
                        echo '<td><input type="number" name="semestre2[' . $row['id_alumno'] . ']"></td>';
                        echo '<td><input type="number" name="semestre3[' . $row['id_alumno'] . ']"></td>';
                        echo '<td><input type="number" name="semestre4[' . $row['id_alumno'] . ']"></td>';
                        echo '<td></td>';

                    }

                }
                ?>
                </tbody>
            </table>
            <br>
            <input type="submit" value="Guardar" class="calificar-notas-submit">
        </form>
    </div>
</body>
</html>