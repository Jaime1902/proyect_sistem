<?php include "header.php";?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar nota</title>
</head>
<body>
    <h1>Editar nota</h1>

    <?php
        // Conexión a la base de datos
        include "../../conexion.php";

        // Obtener el identificador de la calificación
        $id_calificacion = $_GET['id_calificacion'];

        // Verificar si el valor de $id_calificacion es un número válido
        if (!is_numeric($id_calificacion)) {
            echo 'El identificador de la calificación no es válido';
            exit();
        }

        // Convertir $id_calificacion a entero para evitar ataques de inyección SQL
        $id_calificacion = intval($id_calificacion);

        // Obtener los datos de la calificación
        $query = "SELECT c.*, a.nombre AS nombre_alumno, asi.nombre_asignatura AS nombre_asignatura 
                  FROM calificaciones c 
                  INNER JOIN alumnos a ON c.id_alumno = a.id_alumno 
                  INNER JOIN asignaturas asi ON c.id_asignatura = asi.id_asignatura 
                  WHERE id_calificacion = " . $id_calificacion;
        $result = $conexion->query($query);
        $row = $result->fetch_assoc();

        // Verificar si la calificación existe
        if (!$row) {
            echo 'La calificación no existe';
            exit();
        }
    ?>

    <h2>Alumno: <?php echo $row['nombre_alumno']; ?></h2>
    <h2>Asignatura: <?php echo $row['nombre_asignatura']; ?></h2>

    <form method="post" action="actualizar_nota.php">
        <input type="hidden" name="id_calificacion" value="<?php echo $id_calificacion; ?>">
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1er semestre</td>
                    <td><input type="number" name="semestre1" value="<?php echo $row['semestre1']; ?>"></td>
                </tr>
                <tr>
                    <td>2do semestre</td>
                    <td><input type="number" name="semestre2" value="<?php echo $row['semestre2']; ?>"></td>
                </tr>
                <tr>
                    <td>3er semestre</td>
                    <td><input type="number" name="semestre3" value="<?php echo $row['semestre3']; ?>"></td>
                </tr>
                <tr>
                    <td>4to semestre</td>
                    <td><input type="number" name="semestre4" value="<?php echo $row['semestre4']; ?>"></td>
                </tr>
            </tbody>
        </table>
        <button id="actualizar-btn" type="submit" disabled>Actualizar</button>
    </form>

    <script>
        // Obtener todos los elementos input de la tabla
        const inputs = document.querySelectorAll('table input');

        // Verificar si algún input ha cambiado
        function checkChanges() {
            for (const input of inputs) {
                if (input.value !== '<?php echo $row['semestre1'] ?>' || input.value !== '<?php echo $row['semestre2'] ?>' || input.value !== '<?php echo $row['semestre3'] ?>' || input.value !== '<?php echo $row['semestre4'] ?>') {
                    document.getElementById('actualizar-btn').disabled = false;
                    return;
                }
            }
            document.getElementById('actualizar-btn').disabled = true;
        }

        // Escuchar los cambios en los inputs
        for (const input of inputs) {
            input.addEventListener('input', checkChanges);
        }
    </script>
</body>
</html>