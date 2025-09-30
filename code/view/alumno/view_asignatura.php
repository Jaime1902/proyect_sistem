<?php
include "header.php";

// Conexión
$conn = new mysqli("localhost", "root", "mysql", "project_db");
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

if (!isset($_SESSION["id_login"])) {
    header("Location: ../../index.php");
    exit();
}

$id_login = (int) $_SESSION["id_login"];

// Obtener info del alumno y grado
$sql = "SELECT a.id_grado, a.nombre, a.apellidos, g.nombre_grado
        FROM alumnos a
        INNER JOIN grados g ON a.id_grado = g.id_grado
        WHERE a.login_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_login);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
    die("Alumno o grado no encontrado.");
}
$alumno = $result->fetch_assoc();
$id_grado = $alumno["id_grado"];
$nombre_alumno = $alumno["nombre"] . " " . $alumno["apellidos"];
$nombre_grado = $alumno["nombre_grado"];

// Obtener asignaturas
$sql = "SELECT id_asignatura, nombre_asignatura, ruta_imagen 
        FROM asignaturas 
        WHERE id_grado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_grado);
$stmt->execute();
$asignaturas = $stmt->get_result();
$colores = ['#1abc9c', '#3498db', '#e74c3c', '#f39c12', '#9b59b6'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Asignaturas - <?php echo $nombre_grado; ?></title>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
<style>
    body { background: #f5f7fa; }
    .card-asignatura {
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        color: white;
        display: flex;
        flex-direction: column;
    }
    .card-asignatura:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
    .card-img {
        height: 150px;
        background-size: cover;
        background-position: center;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        padding: 15px 10px;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media(max-width:768px){
        .card-img { height: 120px; }
    }
</style>
</head>
<body>
<div class="container">
    <div class="page-header text-center">
        <h2><i class="ri-book-2-fill"></i> Asignaturas de <?php echo $nombre_grado; ?></h2>
        <p class="text-muted">Alumno: <?php echo $nombre_alumno; ?></p>
    </div>
    <div class="row">
        <?php while ($row = $asignaturas->fetch_assoc()):
            $color = $colores[array_rand($colores)];
            $imagen = !empty($row['ruta_imagen']) ? $row['ruta_imagen'] : 'img/Asignatura/predeterminada.png';
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card-asignatura" style="background-color: <?php echo $color; ?>;"
                 onclick="redirectToNotas(<?php echo $row['id_asignatura']; ?>)">
                <div class="card-img" style="background-image: url('<?php echo $imagen; ?>');"></div>
                <div class="card-title"><?php echo htmlspecialchars($row['nombre_asignatura']); ?></div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
function redirectToNotas(id) {
    window.location.href = "calificaciones.php?id_asignatura=" + id;
}
</script>
</body>
</html>
