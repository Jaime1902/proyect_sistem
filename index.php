<?php
// Verifica si la solicitud es un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Registra el error en la base de datos
    $error_message = $_POST['error_message'];

    $sql = "INSERT INTO errores (mensaje) VALUES ('$error_message')";
    if ($conn->query($sql) === true) {
        echo "Error registrado correctamente.";
    } else {
        echo "Error al registrar el error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Error 403 - Acceso denegado</title>
</head>
<body>
    <h1>Error 403 - Acceso denegado</h1>
    <p>Lo sentimos, no tienes permiso para acceder a esta página.</p>

    <form method="POST" action="">
        <input type="text" name="error_message" placeholder="Describe el error...">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
