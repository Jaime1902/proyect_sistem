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
            border-radius: 15px;
            overflow: hidden;
            color: #fff;
        }

        .card img {
            height: 150px;
            object-fit: cover;
        }

        .card .card-body {
            padding: 40px;
        }

        .bg-red {
            background-color: #e53935;
        }

        .bg-green {
            background-color: #8bc34a;
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
           
            if (!isset($_SESSION['id_profesor'])) {
                header("Location: ../../index.php");
                exit;
            }
            $id_profesor = $_SESSION['id_profesor'];
            if (!isset($_GET['id_grado'])) {
                header("Location: view_grado.php");
                exit;
            }

            $id_grado = $_GET['id_grado'];

            $servername = "localhost";
            $username = "root";
            $password = "mysql";
            $dbname = "project_db";
            
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Obtener el nombre del grado
            $query_grado = "SELECT nombre_grado FROM grados WHERE id_grado = $id_grado";
            $result_grado = $conn->query($query_grado);
            $nombre_grado = $result_grado->fetch_assoc()['nombre_grado'];
        ?>

        <h1>Asignaturas de <?php echo $nombre_grado; ?></h1>

        <div class="row">
            <?php
                // Obtener las asignaturas del profesor para el grado seleccionado
                $query = "SELECT asignaturas.id_asignatura, asignaturas.nombre_asignatura, asignaturas.ruta_imagen
                          FROM profesores_asignaturas
                          INNER JOIN asignaturas ON profesores_asignaturas.id_asignatura = asignaturas.id_asignatura
                          WHERE profesores_asignaturas.id_profesor = $id_profesor AND asignaturas.id_grado = $id_grado";

                $result = $conn->query($query);

                $colors = ['bg-red', 'bg-green', 'bg-blue'];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagen = !empty($row['ruta_imagen']) ? $row['ruta_imagen'] : 'img/Asignatura/predeterminada.png';
                        $color_class = $colors[array_rand($colors)];

                        echo '
                            <div class="col-md-4 mb-4">
                                <div class="card ' . $color_class . ' text-center">
                                    <img src="' . $imagen . '" class="card-img-top" alt="' . $row['nombre_asignatura'] . '">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row['nombre_asignatura'] . '</h5>
                                        <a href="calificar.php?id_asignatura=' . $row['id_asignatura'] . '&id_grado=' . $id_grado . '" class="btn btn-light">Ver detalles</a>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                } else {
                    echo '<div class="alert alert-warning">No se encontraron asignaturas para este grado.</div>';
                }

                $conn->close();
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>