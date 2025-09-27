<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grados a Calificar</title>
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
            border: 2px solid #e0e0e0;
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
            background-color: #e8e8e8;
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
        <h1 class="text-center mb-4">Grados a Calificar</h1>
        <div id="content">
            <?php
            // Validar que el usuario haya iniciado sesión
            if (!isset($_SESSION['id_profesor'])) {
                header("Location: ../../index.php");
                exit;
            }

            // Obtener el ID del profesor desde la sesión
            $id_profesor = $_SESSION['id_profesor'];

            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "mysql";
            $dbname = "project_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Consulta SQL para obtener los grados del profesor
            $sql = "SELECT grados.id_grado, grados.nombre_grado
                    FROM profesores_grados
                    INNER JOIN grados ON profesores_grados.id_grado = grados.id_grado
                    WHERE profesores_grados.id_profesor = $id_profesor";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Colores permitidos
                $allowed_colors = ['#ff9800', '#d32f2f', '#4caf50', '#e53935', '#8bc34a'];
                $count = 0;

                while ($row = $result->fetch_assoc()) {
                    $random_color = $allowed_colors[$count % count($allowed_colors)];
                    echo "<div class='module-alatorio' style='border-left: 8px solid $random_color;'>";
                    echo "<a href='view_asignatura.php?id_grado=" . $row['id_grado'] . "'>";
                    echo "<h2>" . $row['nombre_grado'] . "</h2>";
                    echo "</a>";
                    echo "</div>";
                    $count++;
                }
            } else {
                echo "<p class='text-center'>No se encontraron grados asignados.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>