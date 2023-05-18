<?php
// Iniciar sesión
session_start();

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_profesor'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del profesor desde la sesión
$id_profesor = $_SESSION['id_profesor'];

// Realizar la conexión a la base de datos (asegúrate de reemplazar los valores con los correctos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos del profesor de la base de datos utilizando una consulta preparada
$stmt = $conn->prepare("SELECT nombre, apellido, correo_electronico, telefono, carrera_universitaria FROM profesores WHERE id_profesor = ?");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El profesor fue encontrado, obtener los datos y mostrarlos
    $row = $result->fetch_assoc();
    $nombre = htmlentities($row['nombre']);
    $apellido = htmlentities($row['apellido']);
    $correo = htmlentities($row['correo_electronico']);
    $telefono = htmlentities($row['telefono']);
    $carrera_universitaria = htmlentities($row['carrera_universitaria']);
} else {
    // El profesor no fue encontrado, puedes mostrar un mensaje de error o redireccionar a otra página
    echo "Profesor no encontrado.";
    exit;
}

// Incluir el archivo header.php que contiene la estructura del encabezado de la página
include('header.php');
?>

<!-- Aquí va el contenido específico de la página index.php -->
<h1>Bienvenido, <?php echo $nombre . ' ' . $apellido; ?>!</h1>
<p>Correo electrónico: <?php echo $correo; ?></p>
<p>Teléfono: <?php echo $telefono; ?></p>
<p>Carrera universitaria: <?php echo $carrera_universitaria; ?></p>

<?php
// Aquí va el resto del contenido de la página index.php

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();

// Incluir el archivo footer.php que contiene la estructura del pie de página
include('footer.php');
?>