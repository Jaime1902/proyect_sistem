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

// Consulta para obtener los datos del alumno
$query = "SELECT nombre, apellidos, lugar_nacimiento, fecha_nacimiento, codigo_estudiante, fecha_inscripcion, padecimiento_alergia, nombre_padre, nombre_madre, cedula_padre, cedula_madre, telefono_emergencia, ocupacion_padre, ocupacion_madre, direccion_exacta, g.nombre_grado
          FROM alumnos a
          INNER JOIN grados g ON a.id_grado = g.id_grado
          WHERE a.id_alumno = $id_alumno";

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

// Obtener el nombre completo del alumno y el grado
$fila = $resultado->fetch_assoc();

$nombre_completo = $fila['nombre'] . ' ' . $fila['apellidos'];
$grado = $fila['nombre_grado'];

// Agregar el título
$pdf->Cell(0, 10, 'Datos del alumno - ' . $nombre_completo . ' - ' . $grado, 0, 1, 'C', 0);

// Establecer la fuente y el tamaño de la fuente para la tabla
$pdf->SetFont('helvetica', '', 10);

// Generar la tabla vertical con los datos del alumno
$pdf->MultiCell(0, 10, 'Nombre completo: ' . $nombre_completo, 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Código de estudiante: ' . $fila['codigo_estudiante'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Fecha de nacimiento: ' . $fila['fecha_nacimiento'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Lugar de nacimiento: ' . $fila['lugar_nacimiento'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Fecha de inscripción: ' . $fila['fecha_inscripcion'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Padecimiento o alergia: ' . $fila['padecimiento_alergia'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Nombre del padre: ' . $fila['nombre_padre'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Cédula del padre: ' . $fila['cedula_padre'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Ocupación del padre: ' . $fila['ocupacion_padre'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Nombre de la madre: ' . $fila['nombre_madre'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Cédula de la madre: ' . $fila['cedula_madre'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Ocupación de la madre: ' . $fila['ocupacion_madre'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Teléfono de emergencia: ' . $fila['telefono_emergencia'], 0, 'L', 0, 1);
$pdf->MultiCell(0, 10, 'Dirección exacta: ' . $fila['direccion_exacta'], 0, 'L', 0, 1);

// Cerrar el resultado y la conexión a la base de datos
$resultado->close();
$mysqli->close();

// Salida del PDF
$pdf->Output('datos_alumno.pdf', 'I');
