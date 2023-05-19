<?php
session_start();

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_profesor'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del profesor desde la sesión
$id_profesor = $_SESSION['id_profesor'];

// Obtener el ID del grado desde la URL
if (isset($_GET['id_grado'])) {
    $id_grado = $_GET['id_grado'];
} else {
    // Redirigir en caso de que no se proporcione un ID de grado válido
    header("Location: grados.php");
    exit;
}

// Realizar la consulta SQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT asignaturas.id_asignatura, asignaturas.nombre_asignatura
        FROM profesores_asignaturas
        INNER JOIN asignaturas ON profesores_asignaturas.id_asignatura = asignaturas.id_asignatura
        WHERE profesores_asignaturas.id_profesor = $id_profesor AND asignaturas.id_grado = $id_grado";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los resultados de la consulta
    while ($row = $result->fetch_assoc()) {
        echo "ID Asignatura: " . $row["id_asignatura"] . ", Nombre Asignatura: " . $row["nombre_asignatura"] . "<br>";
        
        // Agregar un enlace para cada asignatura que redirija a calificar.php con el ID de la asignatura correspondiente
        echo '<a href="calificar.php?id_asignatura=' . $row['id_asignatura'] . '&id_grado=' . $_GET['id_grado'] . '">' . $row['nombre_asignatura'] . '</a>';
    }
} else {
    echo "No se encontraron asignaturas para este grado y profesor.";
}

// Cerrar la conexión
$conn->close();
?>
