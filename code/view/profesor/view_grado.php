<?php
session_start();

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_profesor'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del profesor desde la sesión
$id_profesor = $_SESSION['id_profesor'];

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
$sql = "SELECT grados.id_grado, grados.nombre_grado
        FROM profesores_grados
        INNER JOIN grados ON profesores_grados.id_grado = grados.id_grado
        WHERE profesores_grados.id_profesor = $id_profesor";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear una variable para almacenar la URL de redirección
    $redirect_url = "view_asignatura.php?id_grado=";

    // Mostrar los resultados de la consulta
    while ($row = $result->fetch_assoc()) {
        echo "ID Grado: " . $row["id_grado"] . ", Nombre Grado: " . $row["nombre_grado"] . "<br>";

        // Agregar un enlace para cada resultado que redirija a view_asignatura.php con el ID del grado correspondiente
        echo '<a href="' . $redirect_url . $row["id_grado"] . '">Ver Asignaturas</a><br>';
    }
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>
