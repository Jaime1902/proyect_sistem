<?php

// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
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
$pdf->SetAuthor('Nombre del autor');
$pdf->SetTitle('Título del documento');
$pdf->SetSubject('Asunto del documento');
$pdf->SetKeywords('palabras clave, separadas por, comas');

// Establecer margenes
$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// Agregar una página
$pdf->AddPage();

// Establecer el color de fondo y el color del texto
$pdf->SetFillColor(200, 200, 200);
$pdf->SetTextColor(0, 0, 0);

// Establecer la fuente y el tamaño de la fuente para el título
$pdf->SetFont('helvetica', 'B', 14);

// Obtener el nombre y apellidos del alumno y el grado
$query_info = "SELECT a.nombre, a.apellidos, g.nombre_grado FROM alumnos a INNER JOIN calificaciones c ON a.id_alumno = c.id_alumno INNER JOIN grados g ON c.id_grado = g.id_grado WHERE a.id_alumno = $id_alumno LIMIT 1";
$resultado_info = $mysqli->query($query_info);
$fila_info = $resultado_info->fetch_assoc();

$nombre_completo = $fila_info['nombre'] . ' ' . $fila_info['apellidos'];
$grado = $fila_info['nombre_grado'];

// Agregar el título
$pdf->Cell(0, 10, 'Calificaciones - ' . $nombre_completo . ' - ' . $grado, 0, 1, 'C', 0);

// Establecer la fuente y el tamaño de la fuente para la tabla
$pdf->SetFont('helvetica', '', 8);

// Agregar el encabezado de la tabla
$pdf->Cell(30, 10, 'Asignatura', 1, 0, 'C');
$pdf->Cell(20, 10, 'Semestre 1', 1, 0, 'C');
$pdf->Cell(20, 10, 'Semestre 2', 1, 0, 'C');
$pdf->Cell(20, 10, 'Semestre 3', 1, 0, 'C');
$pdf->Cell(20, 10, 'Semestre 4', 1, 0, 'C');
$pdf->Cell(30, 10, 'Promedio final', 1, 1, 'C');

// Agregar los datos de la tabla
while ($fila = $resultado->fetch_assoc()) {
  $pdf->Cell(30, 10, $fila['nombre_asignatura'], 1, 0, 'L');
  $pdf->Cell(20, 10, $fila['semestre1'], 1, 0, 'C');
  $pdf->Cell(20, 10, $fila['semestre2'], 1, 0, 'C');
  $pdf->Cell(20, 10, $fila['semestre3'], 1, 0, 'C');
  $pdf->Cell(20, 10, $fila['semestre4'], 1, 0, 'C');
  $pdf->Cell(30, 10, $fila['promedio_final'], 1, 1, 'C');
}

// Cerrar la conexión y enviar el PDF al navegador
$mysqli->close();

$pdf->Output('calificaciones.pdf', 'I');

?>
