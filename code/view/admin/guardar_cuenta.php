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
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Verifica si el usuario ya existe
    $sql = "SELECT * FROM login WHERE username = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El usuario ya existe. Por favor, elige otro nombre de usuario.";
    } else {
        // Inserta la nueva cuenta en la base de datos
        $sql = "INSERT INTO login (username, password_hash, role) VALUES ('$usuario', SHA2('$contrasena', 256), '$rol')";
        if ($conn->query($sql) === TRUE) {
            header("Location: lobby_usurio.php");
        } else {
            echo "Error al crear la nueva cuenta: " . $conn->error;
        }
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
