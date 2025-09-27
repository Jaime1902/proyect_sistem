<?php
session_start();
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

if (!isset($_SESSION['id_login'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}
$id_login = (int) $_SESSION['id_login'];

// Consulta filtrada
$sql = "SELECT asig.nombre_asignatura, 
               (CASE 
                    WHEN ? = 1 THEN cal.semestre1
                    WHEN ? = 2 THEN (cal.semestre1 + cal.semestre2) / 2
                    WHEN ? = 3 THEN (cal.semestre1 + cal.semestre2 + cal.semestre3) / 3
                    WHEN ? = 4 THEN cal.promedio_final
                END) AS promedio
        FROM calificaciones cal
        INNER JOIN asignaturas asig ON cal.id_asignatura = asig.id_asignatura
        INNER JOIN alumnos a ON cal.id_alumno = a.id_alumno
        WHERE a.login_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $promedioSeleccionado, $promedioSeleccionado, $promedioSeleccionado, $promedioSeleccionado, $id_login);
$stmt->execute();
$result = $stmt->get_result();

$asignaturas = [];
$promedios = [];
$totalPromedio = 0;
$numAsignaturas = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $asignaturas[] = $row['nombre_asignatura'] ?? 'Sin nombre';
        $promedio = floatval($row['promedio']);
        $promedios[] = $promedio;
        $totalPromedio += $promedio;
        $numAsignaturas++;
    }
} else {
    echo json_encode(['error' => 'No se encontraron registros para este usuario']);
    exit;
}

// Calcular promedio general
$rendimientoPromedio = $numAsignaturas > 0 ? $totalPromedio / $numAsignaturas : 0;

echo json_encode([
    'asignaturas' => $asignaturas,
    'promedios' => $promedios,
    'rendimientoPromedio' => $rendimientoPromedio
]);

$conn->close();
?>
