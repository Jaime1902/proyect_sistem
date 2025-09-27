<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => "Conexión fallida: " . $conn->connect_error]));
}

$promedioSeleccionado = $_GET['promedio'] ?? 1;

$sql = "SELECT nombre_asignatura, 
               (CASE 
                    WHEN $promedioSeleccionado = 1 THEN semestre1
                    WHEN $promedioSeleccionado = 2 THEN (semestre1 + semestre2) / 2
                    WHEN $promedioSeleccionado = 3 THEN (semestre1 + semestre2 + semestre3) / 3
                    WHEN $promedioSeleccionado = 4 THEN promedio_final
                END) AS promedio
        FROM calificaciones 
        INNER JOIN asignaturas ON calificaciones.id_asignatura = asignaturas.id_asignatura";

$result = $conn->query($sql);

$asignaturas = [];
$promedios = [];
$totalPromedio = 0; // Para sumar todos los promedios
$numAsignaturas = 0; // Contar el número de asignaturas

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $asignaturas[] = $row['nombre_asignatura'] ?? 'Sin nombre'; // Evitar valores nulos
        $promedio = floatval($row['promedio']); // Asegurarse de que sea un número
        $promedios[] = $promedio;
        $totalPromedio += $promedio;
        $numAsignaturas++;
    }
}

// Calcular rendimiento de promedio
$rendimientoPromedio = $numAsignaturas > 0 ? $totalPromedio / $numAsignaturas : 0;

echo json_encode([
    'asignaturas' => $asignaturas,
    'promedios' => $promedios,
    'rendimientoPromedio' => $rendimientoPromedio // Nuevo dato
]);
$conn->close();

?>
