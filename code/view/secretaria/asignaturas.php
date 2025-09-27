<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas por grado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            color: #fff;
        }

        .card img {
            height: 150px;
            object-fit: cover;
        }

        .card .card-body {
            padding: 15px;
        }

        .bg-red {
            background-color: #8bc34a;
        }

        .bg-green {
            background-color: #e53935;
        }

        .bg-blue {
            background-color: #ff9800;
        }

        h1 {
            margin-bottom: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <?php
            // Conexión a la base de datos
            include "../../conexion.php";

            // Comprobar la conexión
            if ($conexion->connect_errno) {
                echo '<div class="alert alert-danger">Error en la conexión: ' . $conexion->connect_error . '</div>';
                exit();
            }

            // Obtener el nombre del grado correspondiente al ID
            $id_grado = $_GET['id_grado'];
            $query_grado = "SELECT nombre_grado FROM grados WHERE id_grado = $id_grado";
            $result_grado = $conexion->query($query_grado);
            $row_grado = $result_grado->fetch_assoc();
            $nombre_grado = $row_grado['nombre_grado'];
        ?>

        <h1>Asignaturas de <?php echo $nombre_grado; ?></h1>

        <div class="row">
            <?php
                // Obtener las asignaturas correspondientes al grado seleccionado
                $query = "SELECT id_asignatura, nombre_asignatura, ruta_imagen FROM asignaturas WHERE id_grado = $id_grado";
                $result = $conexion->query($query);

                // Colores disponibles para las tarjetas
                $colors = ['bg-red', 'bg-green', 'bg-blue'];

                // Mostrar las asignaturas con imágenes
                while ($row = $result->fetch_assoc()) {
                    // Determinar la imagen a usar
                    $imagen = !empty($row['ruta_imagen']) ? $row['ruta_imagen'] : 'img/Asignatura/predeterminada.png';

                    // Seleccionar un color aleatorio
                    $color_class = $colors[array_rand($colors)];

                    echo '
                        <div class="col-md-4 mb-4">
                            <div class="card ' . $color_class . ' text-center">
                                <img src="' . $imagen . '" class="card-img-top" alt="' . $row['nombre_asignatura'] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row['nombre_asignatura'] . '</h5>
                                    <a href="evaluar.php?id_asignatura=' . $row['id_asignatura'] . '&id_grado=' . $id_grado . '" class="btn btn-light">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    ';
                }

                // Liberar memoria y cerrar la conexión a la base de datos
                $result->free();
                $conexion->close();
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
