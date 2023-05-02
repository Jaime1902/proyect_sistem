<?php
// Datos para la conexión a la base de datos
$host = "localhost"; // Cambia esto si tu servidor de MySQL está en otro host
$user = "root"; // Nombre de usuario de MySQL
$pass = ""; // Contraseña de MySQL
$db = "project_db"; // Nombre de la base de datos a la que se desea conectar

// Conexión a la base de datos utilizando la clase mysqli
$conexion = new mysqli($host, $user, $pass, $db);

// Verificamos si hubo algún error en la conexión
if ($conexion->connect_errno) {
    // Si hubo un error, se muestra un mensaje y se detiene la ejecución del script
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecemos el conjunto de caracteres a utf8 para evitar problemas con acentos y caracteres especiales
$conexion->set_charset("utf8");
?>
