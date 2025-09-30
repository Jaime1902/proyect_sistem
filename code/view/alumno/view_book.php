<?php
include "header.php"; 
// Conexión a la BD
$host = "localhost";
$user = "root";
$pass = "mysql";
$db   = "project_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Error en la conexión: " . $conn->connect_error);

// ID del login que guardaste en la sesión
$login_id = (int) $_SESSION['id_login'];

// Buscar el alumno por login_id
$sql = "SELECT id_alumno, id_grado, nombre, apellidos 
        FROM alumnos 
        WHERE login_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $login_id);
$stmt->execute();
$res = $stmt->get_result();
$alumno = $res->fetch_assoc();

if (!$alumno) {
    die("Alumno no encontrado");
}
$id_grado = $alumno['id_grado'];

// Obtener libros relacionados a ese grado
$sql = "SELECT l.id_libro, l.titulo, l.autor, l.ruta_pdf, a.nombre_asignatura
        FROM libros l
        INNER JOIN asignaturas a ON l.id_asignatura = a.id_asignatura
        WHERE a.id_grado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_grado);
$stmt->execute();
$libros = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Libros Disponibles</title>
  <!-- Remixicon -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    body {
      background: #f7f9fc;
    }
    .book-card {
      border: 1px solid #ddd;
      border-radius: 6px;
      background: #fff;
      margin-bottom: 30px;
      transition: transform 0.2s;
    }
    .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .book-header {
      background: #5bc0de;
      color: white;
      height: 180px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4em;
      border-top-left-radius: 6px;
      border-top-right-radius: 6px;
    }
    .book-body {
      padding: 15px;
      min-height: 200px;
      display: flex;
      flex-direction: column;
    }
    .book-body h4 {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .book-body p {
      margin: 0 0 8px;
      font-size: 14px;
    }
    .book-actions {
      margin-top: auto;
    }
    .book-actions .btn {
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Encabezado -->
    <div class="page-header text-center">
      <h1><i class="ri-book-open-fill"></i> Libros Disponibles</h1>
      <p class="text-muted">Alumno: <?php echo $alumno['nombre']." ".$alumno['apellidos']; ?></p>
    </div>

    <!-- Grid de libros -->
    <div class="row">
      <?php while ($row = $libros->fetch_assoc()): ?>
        <div class="col-sm-6 col-md-4">
          <div class="book-card">
            <div class="book-header">
              <i class="ri-file-pdf-2-fill"></i>
            </div>
            <div class="book-body">
              <h4 title="<?php echo htmlspecialchars($row['titulo']); ?>">
                <?php echo htmlspecialchars($row['titulo']); ?>
              </h4>
              <p><i class="ri-user-3-fill"></i> <?php echo htmlspecialchars($row['autor']); ?></p>
              <p class="text-info"><i class="ri-book-2-fill"></i> <?php echo htmlspecialchars($row['nombre_asignatura']); ?></p>
              <div class="book-actions">
                <a  href="/proyect_sistem/code/pdfjs/web/viewer.html?file=/proyect_sistem/code/pdfs/<?php echo urlencode(basename($row['ruta_pdf'])); ?>" 
                   target="_blank" class="btn btn-primary btn-sm">
                  <i class="ri-eye-fill"></i> Ver
                </a>
                <a href="<?php echo $row['ruta_pdf']; ?>" download class="btn btn-success btn-sm">
                  <i class="ri-download-2-fill"></i> Descargar
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
