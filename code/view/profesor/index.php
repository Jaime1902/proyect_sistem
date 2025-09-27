<?php
include('header.php');

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_profesor'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del profesor desde la sesión
$id_profesor = $_SESSION['id_profesor'];

// Realizar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos del profesor de la base de datos
$stmt = $conn->prepare("SELECT nombre, apellido, correo_electronico, telefono, carrera_universitaria FROM profesores WHERE id_profesor = ?");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = htmlentities($row['nombre']);
    $apellido = htmlentities($row['apellido']);
    $correo = htmlentities($row['correo_electronico']);
    $telefono = htmlentities($row['telefono']);
    $carrera_universitaria = htmlentities($row['carrera_universitaria']);
} else {
    $_SESSION['error'] = "Profesor no encontrado.";
    header("Location: 403.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">¡Bienvenido, <?php echo $nombre . ' ' . $apellido; ?>!</h1>
    <table class="table table-hover table-striped fs-5" style="padding: 1rem;">

        <thead class="table-primary">
            <tr>
                <th><i class="fas fa-info-circle"></i> Información</th>
                <th><i class="fas fa-database"></i> Detalle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fas fa-envelope"></i> Correo electrónico</td>
                <td><?php echo $correo; ?></td>
            </tr>
            <tr>
                <td><i class="fas fa-phone"></i> Teléfono</td>
                <td><?php echo $telefono; ?></td>
            </tr>
            <tr>
                <td><i class="fas fa-graduation-cap"></i> Carrera universitaria</td>
                <td><?php echo $carrera_universitaria; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
