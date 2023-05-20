<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "project_db";

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verifica si hay errores de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del formulario
    $usuario = $_POST['usuario'];
    $nuevaContrasena = $_POST['nuevaContrasena'];

    // Verifica si el usuario existe
    $sql = "SELECT * FROM login WHERE username = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario existe, procede a actualizar la contraseña
        $sql = "UPDATE login SET password_hash = SHA2('$nuevaContrasena', 256) WHERE username = '$usuario'";
        if ($conn->query($sql) === TRUE) {
            header("Location: lobby_usurio.php");
        } else {
            echo "Error al actualizar la contraseña: " . $conn->error;
        }
    } else {
        echo "El usuario no existe.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
