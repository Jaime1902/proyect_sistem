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

$id_alumno = $_GET['id'];

// Consulta para obtener las calificaciones con información de alumnos y asignaturas
$query = "SELECT c.id_calificacion, a.nombre, a.apellidos, g.nombre_grado, asi.nombre_asignatura, c.semestre1, c.semestre2, c.semestre3, c.semestre4, c.promedio_final
          FROM calificaciones c
          INNER JOIN alumnos a ON c.id_alumno = a.id_alumno
          INNER JOIN grados g ON c.id_grado = g.id_grado
          INNER JOIN asignaturas asi ON c.id_asignatura = asi.id_asignatura
          WHERE c.id_alumno = $id_alumno";

// Ejecutar la consulta
$resultado = $mysqli->query($query);

// Crear un nuevo PDF
require_once('../../../vendor/autoload.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema de Calificaciones');
$pdf->SetTitle('Reporte de Calificaciones');
$pdf->SetSubject('Calificaciones del Alumno');

// Establecer margenes
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// Agregar una página
$pdf->AddPage();

// Agregar el logo del colegio
$logo_path = '../../img/logo/logo.png'; // Cambia esto a la ruta correcta
if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 10, 20, 30, 30, '', '', '', false, 300, '', false, false, 0, false, false, false);
}

// Título del Colegio
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 15, 'Colegio Cristiano Presbiteriano', 0, 1, 'C', 0);

// Espacio debajo del título
$pdf->Ln(5);

// Obtener el nombre y apellidos del alumno y el grado
$query_info = "SELECT a.nombre, a.apellidos, g.nombre_grado FROM alumnos a INNER JOIN calificaciones c ON a.id_alumno = c.id_alumno INNER JOIN grados g ON c.id_grado = g.id_grado WHERE a.id_alumno = $id_alumno LIMIT 1";
$resultado_info = $mysqli->query($query_info);
$fila_info = $resultado_info->fetch_assoc();

$nombre_completo = $fila_info['nombre'] . ' ' . $fila_info['apellidos'];
$grado = $fila_info['nombre_grado'];

// Agregar el título del reporte
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Reporte de Calificaciones', 0, 1, 'C', 0);
$pdf->Ln(2);
$pdf->Cell(0, 10, "Alumno: $nombre_completo - Grado: $grado", 0, 1, 'C', 0);
$pdf->Ln(5);

// Agregar encabezado de la tabla
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell(40, 10, 'Asignatura', 1, 0, 'C');
$pdf->Cell(30, 10, 'Semestre 1', 1, 0, 'C');
$pdf->Cell(30, 10, 'Semestre 2', 1, 0, 'C');
$pdf->Cell(30, 10, 'Semestre 3', 1, 0, 'C');
$pdf->Cell(30, 10, 'Semestre 4', 1, 0, 'C');
$pdf->Cell(30, 10, 'Promedio final', 1, 1, 'C');

// Agregar los datos de la tabla
$pdf->SetFont('helvetica', '', 10);
while ($fila = $resultado->fetch_assoc()) {
    $pdf->Cell(40, 10, $fila['nombre_asignatura'], 1, 0, 'L');
    $pdf->Cell(30, 10, $fila['semestre1'], 1, 0, 'C');
    $pdf->Cell(30, 10, $fila['semestre2'], 1, 0, 'C');
    $pdf->Cell(30, 10, $fila['semestre3'], 1, 0, 'C');
    $pdf->Cell(30, 10, $fila['semestre4'], 1, 0, 'C');
    $pdf->Cell(30, 10, $fila['promedio_final'], 1, 1, 'C');
}

// Cerrar la conexión y enviar el PDF al navegador
$mysqli->close();

$pdf->Output('calificaciones.pdf', 'I');

?>
