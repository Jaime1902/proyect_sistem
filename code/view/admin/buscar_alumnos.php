<?php
// Conexión a la base de datos
include "../../conexion.php";

// Verificación de conexión
if (mysqli_connect_errno()) {
    echo "Error al conectarse a MySQL: " . mysqli_connect_error();
    exit();
}

// Búsqueda de alumnos que coincidan con el texto ingresado
$input = $_POST["input"];

$query = "SELECT id_alumno, nombre, apellidos FROM alumnos WHERE CONCAT(nombre, ' ', apellidos) LIKE '%$input%'";
$resultado = mysqli_query($conexion, $query);

// Creación de la lista de resultados
if (mysqli_num_rows($resultado) > 0) {
    echo "<ul>";
    while ($fila = mysqli_fetch_array($resultado)) {
        echo "<li data-alumno-id='" . $fila['id_alumno'] . "'>" . $fila['nombre'] . " " . $fila['apellidos'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No se encontraron resultados.</p>";
}

// Cierre de la conexión a la base de datos
mysqli_close($conexion);
?>
