<?php include "header.php";?>
<!DOCTYPE html>
<html>
<head>
    <title>Grados a calificar</title>
    <style>
    #content {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .module-alatorio {
        padding: 20px;
        border-radius: 5px;
        margin: 10px;
        text-align: center;
        background-color: <?php echo $random_color ?>;
        flex: 1 0 20%;
    }

    .module-alatorio a {
        color: #fff;
        text-decoration: none;
        font-size: 24px;
        color: #fff;
        text-decoration: none;
        font-size: 24px;
        display: flex;
        justify-content: center;
    }

    .module-alatorio h2 {
        margin: auto;
    }
    </style>
</head>
<body>
    <h1>Grados a calificar</h1>
    <div id="content">
        <?php
        // Conexión a la base de datos
        include "../../conexion.php";

        // Comprobar la conexión
        if ($conexion->connect_errno) {
            echo 'Error en la conexión: ' . $conexion->connect_error;
            exit();
        }

        // Obtener los 13 grados
        $query = "SELECT * FROM grados ";

        // Colores permitidos
        $allowed_colors = array('#ff9800', '#d32f2f', '#4caf50', '#e53935', '#8bc34a');

        if ($result = $conexion->query($query)) {
            // Imprimir los resultados en una tabla
            $count = 1;
            while ($row = $result->fetch_assoc()) {
                $random_color = $allowed_colors[$count % count($allowed_colors)];
                echo "<div class='module' style='background-color: " . $random_color . ";'>";
                echo "<a href='asignaturas.php?id_grado=" . $row['id_grado'] . "'><h2>" . $row['nombre_grado'] . "</h2></a>";
                echo "</div>";
                $count++;
            }
            $result->free();
        } else {
            echo 'Error en la consulta: ' . $conexion->error;
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
    </div>
</body>
</html>
