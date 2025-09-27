<?php include "header.php";?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grados a calificar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    #content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .module-alatorio {
        padding: 30px;
        border-radius: 10px;
        margin: 10px;
        text-align: center;
        flex: 1 0 21%;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid #e0e0e0; /* Borde sutil */
        background-color: #fff;
    }

    .module-alatorio:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    }

    .module-alatorio a {
        color: #333;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
        display: block;
        padding: 10px;
        border-radius: 5px;
        background-color: #f0f0f0;
        transition: background-color 0.3s ease;
    }

    .module-alatorio a:hover {
        background-color:rgb(255, 255, 255); /* Fondo más oscuro al pasar el mouse */
    }

    .module-alatorio h2 {
        margin: 0;
        font-size: 22px;
    }

    .module-alatorio .module-title {
        font-size: 18px;
        color: #444;
    }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Grados a calificar</h1>
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
                    echo "<div class='module-alatorio' style='border-left: 8px solid " . $random_color . ";'>";
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
