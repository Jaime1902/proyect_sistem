<?php
$host = "localhost"; // Cambia esto si tu servidor de MySQL está en otro host
$user = "root";
$pass = "";
$db = "project_db";

// Conexión a la base de datos
$conexion = new mysqli($host, $user, $pass, $db);

// Verificamos si hay algún error de conexión
if ($conexion->connect_errno) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecemos el conjunto de caracteres a utf8 para evitar problemas con acentos y caracteres especiales
$conexion->set_charset("utf8");
?>