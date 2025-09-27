<?php
include "header.php"; 
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_SESSION["id_login"])) {
    $id_login = $_SESSION["id_login"];
  
    $sql = "SELECT a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado
            FROM alumnos a
            INNER JOIN grados g ON a.id_grado = g.id_grado
            WHERE a.login_id = $id_login";
    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre_alumno = $row["nombre"] . " " . $row["apellidos"];
        $nombre_grado = $row["nombre_grado"];
        $fecha_nacimiento = $row["fecha_nacimiento"];
        
       

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="container" id="content">
        <div class="alert alert-info">
            <?php 
                $randomIcon = rand(0, 3);
                echo $randomIcon == 0 ? '<i class="fa fa-hand-peace-o" title="¡Hola!"></i>' : 
                     ($randomIcon == 1 ? '<i class="fa-solid fa-hand" title="¡Hola!"></i>' : 
                     '<i class="fa fa-graduation-cap" title="¡Felicidades!"></i>');
            ?>
            <strong>Bienvenido Estudiante, <?php echo $nombre_alumno; ?>!</strong>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Información del Estudiante
            </div>
            <div class="panel-body">
                <table class="table">
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
     <!-- Dropdown para seleccionar promedio -->
     <div class="panel panel-primary">
            <div class="panel-heading">
                Seleccionar Promedio
            </div>
            <div class="panel-body">
                <select id="promedioSelect" class="form-control">
                    <option value="2">Segundo Promedio</option>
                    <option value="3">Tercer Promedio</option>
                    <option value="4">Promedio Final</option>
                </select>
            </div>
        </div>

        <!-- Gráfico de barras -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                Promedio por Asignaturas
            </div>
            <div class="panel-body">
                <canvas id="chartPromedios"></canvas>
                <p id="notaFelicidades" 
                   style="margin-top: 20px; 
                          font-weight: bold; 
                          color: #4CAF50; 
                          text-align: center;">
                </p>
            </div>
        </div>
    </div>

</div>

<script>
// Inicializar el gráfico
let chart = null;
let delayed;
function obtenerColor(promedio) {
    if (promedio >= 90) {
        return 'rgba(106, 255, 115, 0.8)'; 
    } else if (promedio >= 76) {
        return 'rgba(140, 255, 106, 0.8)'; 
    } else if (promedio >= 60) {
        return 'rgba(152, 234, 250, 0.8)'; 
    } else {
        return 'rgba(255, 0, 0, 0.8)';
    }
}


// Función para actualizar el gráfico
function actualizarGrafico(promedioSeleccionado) {
    fetch('get_promedios.php?promedio=' + promedioSeleccionado)
        .then(response => response.json())
        .then(data => {
            const { asignaturas, promedios, rendimientoPromedio } = data;

            if (chart) {
                chart.destroy(); // Destruir el gráfico anterior
            }
             // Generar colores dinámicamente según los promedios
             const colores = promedios.map(promedio => obtenerColor(promedio));

            const ctx = document.getElementById('chartPromedios').getContext('2d');
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: asignaturas,
                    datasets: [{
                        data: promedios,
                        backgroundColor: colores,
                        borderColor: colores.map(color => color.replace('0.8', '1')),
                        borderWidth: 2,
                        borderRadius: 5,
                    }]
                },
                options: {
                    
                    animation: {
                        onComplete: () => {
                        delayed = true;
                    },
                        delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 500 + context.datasetIndex * 200  ;
                        }
                        return delay;
                    },
                    },
                    plugins: {
                    legend: {
                         display: false // Esto oculta por completo la leyenda (incluida la barrita verde)
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, barPercentage: 0.1, categoryPercentage: 0.8 },
                        y: { beginAtZero: true, grid: { display: false } }
                    }
                    
                    
                }
            });

            // Actualizar mensaje de felicitaciones
            const maxPromedio = Math.max(...promedios);
            const maxIndex = promedios.indexOf(maxPromedio); // Índice del promedio más alto
            const asignaturaMaxPromedio = asignaturas[maxIndex] || "No definida";
             // Actualizar mensaje de rendimiento de promedio
             document.getElementById('notaFelicidades').innerHTML =
                `Rendimiento promedio general: <strong>${rendimientoPromedio.toFixed(2)}</strong>.<br></br> El promedio mas alto: <strong>${maxPromedio.toFixed(2)}</strong> de la asignatura <strong>${asignaturaMaxPromedio}</strong>.`;
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
        });
}

// Evento para actualizar el gráfico al cambiar el promedio
document.getElementById('promedioSelect').addEventListener('change', (event) => {
    const promedioSeleccionado = event.target.value;
    actualizarGrafico(promedioSeleccionado);
});

// Cargar el gráfico inicial
actualizarGrafico(2);
</script>
</body>
</html>

<?php
    } else {
        $_SESSION['error'] = "No se encontró ningún registro de alumno y grado para el usuario actual.";
        header("Location: 403.php");
    }
} else {
    header("Location: ../../index.php");
    exit();
}
?>
