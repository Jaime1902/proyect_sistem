<?php
session_start();
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = 'mysql';
$database = 'project_db';

$mysqli = new mysqli($host, $user, $password, $database);

// Comprobar la conexión
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}
// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'secretaria')) {
  header("location: ../../index.php");
  exit;
}

$id_alumno = $_GET['id'];

// Consulta para obtener los datos del alumno
$query = "SELECT nombre, apellidos, lugar_nacimiento, fecha_nacimiento, codigo_estudiante, fecha_inscripcion, padecimiento_alergia, nombre_padre, nombre_madre, cedula_padre, cedula_madre, telefono_emergencia, ocupacion_padre, ocupacion_madre, direccion_exacta, g.nombre_grado
          FROM alumnos a
          INNER JOIN grados g ON a.id_grado = g.id_grado
          WHERE a.id_alumno = $id_alumno";

$resultado = $mysqli->query($query);

// Crear un nuevo PDF
require_once('../../../vendor/autoload.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Colegio Cristiano Presbiteriano');
$pdf->SetTitle('Reporte de Datos del Alumno');
$pdf->SetSubject('Datos del Alumno');
$pdf->SetKeywords('reporte, alumno, colegio');

// Configuración de página
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 15);

// Añadir una página
$pdf->AddPage();

$logo_path = '../../img/logo/logo.png'; // Cambia esto a la ruta correcta
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 10, 15, 30, 30, '', '', '', false, 300, '', false, false, 0, false, false, false);
}

$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Colegio Cristiano Presbiteriano', 0, 1, 'C', 0);
$pdf->Ln(10);

// Título del reporte
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Datos del Alumno', 0, 1, 'C', 0);
$pdf->Ln(5);

// Obtener los datos del alumno
$fila = $resultado->fetch_assoc();
$nombre_completo = $fila['nombre'] . ' ' . $fila['apellidos'];
$grado = $fila['nombre_grado'];

// Información general
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Información General', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);

// Crear tabla
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$fields = [
    'Nombre completo' => $nombre_completo,
    'Código de estudiante' => $fila['codigo_estudiante'],
    'Fecha de nacimiento' => $fila['fecha_nacimiento'],
    'Lugar de nacimiento' => $fila['lugar_nacimiento'],
    'Grado' => $grado,
    'Fecha de inscripción' => $fila['fecha_inscripcion'],
    'Padecimiento o alergia' => $fila['padecimiento_alergia'],
    'Nombre del padre' => $fila['nombre_padre'],
    'Cédula del padre' => $fila['cedula_padre'],
    'Ocupación del padre' => $fila['ocupacion_padre'],
    'Nombre de la madre' => $fila['nombre_madre'],
    'Cédula de la madre' => $fila['cedula_madre'],
    'Ocupación de la madre' => $fila['ocupacion_madre'],
    'Teléfono de emergencia' => $fila['telefono_emergencia'],
    'Dirección exacta' => $fila['direccion_exacta']
];

// Agregar filas a la tabla
foreach ($fields as $key => $value) {
    $pdf->Cell(70, 8, $key, 1, 0, 'L', 1);
    $pdf->Cell(0, 8, $value, 1, 1, 'L', 0);
}

// Cerrar conexión
$resultado->close();
$mysqli->close();

// Salida del PDF
$pdf->Output('datos_alumno.pdf', 'I');

?>
