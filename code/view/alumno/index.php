<?php
include "header.php";
$conn = new mysqli("localhost", "root", "mysql", "project_db");
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

if (!isset($_SESSION["id_login"])) {
    header("Location: ../../index.php");
    exit();
}

$id_login = $_SESSION["id_login"];

$sql = "SELECT a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado
        FROM alumnos a
        INNER JOIN grados g ON a.id_grado = g.id_grado
        WHERE a.login_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Alumno no encontrado");
}

$row = $result->fetch_assoc();
$nombre_alumno = $row["nombre"] . " " . $row["apellidos"];
$nombre_grado = $row["nombre_grado"];
$fecha_nacimiento = $row["fecha_nacimiento"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Estudiante</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            background: #f5f7fa;
        }

        .welcome-alert {
            font-size: 16px;
            font-weight: 500;
        }

        .card-panel {
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-panel:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        #chartPromedios {
            max-width: 100%;
        }

        .panel-heading {
            font-weight: bold;
            font-size: 16px;
        }

        @media(max-width: 768px) {
            .welcome-alert {
                font-size: 14px;
            }

            .card-panel {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Bienvenida -->
        <div class="alert alert-info text-center welcome-alert">
            <i class="fa fa-graduation-cap"></i> ¡Bienvenido, <?php echo $nombre_alumno; ?>!
        </div>

        <!-- Información del estudiante -->
        <div class="card-panel">
            <h4><i class="fa fa-user"></i> Información del Estudiante</h4>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Nombre completo:</th>
                        <td><?php echo $nombre_alumno; ?></td>
                    </tr>
                    <tr>
                        <th>Grado:</th>
                        <td><?php echo $nombre_grado; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de nacimiento:</th>
                        <td><?php echo $fecha_nacimiento; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Selección de promedio -->
        <div class="card-panel">
            <h4><i class="fa fa-chart-bar"></i> Seleccionar Promedio</h4>
            <select id="promedioSelect" class="form-control input-lg">
                <option value="2">Segundo Promedio</option>
                <option value="3">Tercer Promedio</option>
                <option value="4">Promedio Final</option>
            </select>
        </div>

        <!-- Gráfico de promedios -->
        <div class="card-panel">
            <h4><i class="fa fa-chart-area"></i> Promedio por Asignaturas</h4>
            <canvas id="chartPromedios"></canvas>
            <!-- Contenedor para el mensaje -->
            <div id="notaFelicidades" class="mt-3 p-3 rounded-3 text-center fw-semibold"></div>
        </div>
    </div>

    <script>
        // Función para obtener color según promedio
        function obtenerColor(promedio) {
            if (promedio >= 90) return 'rgba(106, 255, 115, 0.8)';
            if (promedio >= 76) return 'rgba(140, 255, 106, 0.8)';
            if (promedio >= 60) return 'rgba(152, 234, 250, 0.8)';
            return 'rgba(255, 0, 0, 0.8)';
        }

        let chart = null;
        let delayed;

        function actualizarGrafico(promedioSeleccionado) {
            fetch('get_promedios.php?promedio=' + promedioSeleccionado)
                .then(res => res.json())
                .then(data => {
                    const {
                        asignaturas,
                        promedios,
                        rendimientoPromedio
                    } = data;

                    if (chart) chart.destroy();

                    const ctx = document.getElementById('chartPromedios').getContext('2d');

                    const backgroundColors = promedios.map(p => {
                        let grad = ctx.createLinearGradient(0, 0, ctx.canvas.width, 0);
                        grad.addColorStop(0, obtenerColor(p).replace('0.8', '1'));
                        grad.addColorStop(1, obtenerColor(p).replace('0.8', '0.6'));
                        return grad;
                    });

                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: asignaturas,
                            datasets: [{
                                label: 'Promedio',
                                data: promedios,
                                backgroundColor: backgroundColors,
                                borderRadius: 10,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            indexAxis: 'y', // Horizontal bars
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.parsed.x.toFixed(2)} puntos`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            animation: {
                                duration: 1200,
                                easing: 'easeOutBounce'
                            }
                        }
                    });

                    // Mensaje de rendimiento
                    const maxProm = Math.max(...promedios);
                    const idxMax = promedios.indexOf(maxProm);
                    const asigMax = asignaturas[idxMax] || "No definida";

                    document.getElementById('notaFelicidades').innerHTML = `
    <div class="alert alert-success shadow-sm">
        Rendimiento general: <strong>${rendimientoPromedio.toFixed(2)}</strong>.<br>
        Promedio más alto: <strong>${maxProm.toFixed(2)}</strong> en <strong>${asigMax}</strong>.
    </div>
`;
                })
                .catch(console.error);
        }


        // Evento dropdown
        document.getElementById('promedioSelect').addEventListener('change', e => {
            actualizarGrafico(e.target.value);
        });

        // Inicializar gráfico
        actualizarGrafico(2);
    </script>
</body>

</html>