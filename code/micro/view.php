<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "mysql";
$db   = "project_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT l.id_libro, l.titulo, l.autor, l.ruta_pdf, a.nombre_asignatura
        FROM libros l
        JOIN asignaturas a ON l.id_asignatura = a.id_asignatura
        ORDER BY l.fecha_subida DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Biblioteca Digital</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <!-- Remix Icon -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6">
  <!-- Encabezado -->
  <header class="text-center mb-12">
    <h1 class="text-4xl md:text-5xl font-extrabold text-blue-700 drop-shadow-lg">
      Biblioteca Digital
    </h1>
    <p class="text-gray-600 mt-2 text-sm md:text-base">Explora y descarga los libros disponibles</p>
  </header>

  <!-- Grid de Libros -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div
        class="bg-white/90 backdrop-blur-md shadow-xl rounded-2xl overflow-hidden hover:shadow-2xl transform hover:scale-[1.03] transition-all duration-300 flex flex-col">

        <!-- Preview PDF -->
        <div class="h-64 bg-gray-100 flex items-center justify-center relative">
          <canvas id="preview-<?php echo $row['id_libro']; ?>" class="max-h-full hidden"></canvas>
          <div id="loader-<?php echo $row['id_libro']; ?>" class="absolute">
            <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-blue-500"></div>
          </div>
        </div>

        <!-- Info -->
        <div class="p-5 flex-1 flex flex-col">
          <h2
            class="text-lg md:text-xl font-semibold text-gray-800 mb-1 truncate"
            title="<?php echo htmlspecialchars($row['titulo']); ?>">
            <?php echo htmlspecialchars($row['titulo']); ?>
          </h2>

          <p class="text-gray-500 text-sm mb-1 flex items-center gap-2">
            <i class="ri-user-3-fill text-gray-400 text-lg"></i>
            <?php echo htmlspecialchars($row['autor']); ?>
          </p>

          <p class="text-blue-600 text-sm font-medium mb-4 flex items-center gap-2">
            <i class="ri-book-2-fill text-blue-400 text-lg"></i>
            <?php echo htmlspecialchars($row['nombre_asignatura']); ?>
          </p>

          <!-- Botones -->
          <div class="mt-auto flex gap-3">
            <a href="/proyect_sistem/code/pdfjs/web/viewer.html?file=/proyect_sistem/code/pdfs/<?php echo urlencode(basename($row['ruta_pdf'])); ?>"
              target="_blank"
              class="flex-1 text-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all flex items-center justify-center gap-2 text-sm font-medium">
              <i class="ri-eye-fill text-white text-lg"></i>
              Ver
            </a>

            <a href="<?php echo $row['ruta_pdf']; ?>" download
              class="flex-1 text-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all flex items-center justify-center gap-2 text-sm font-medium">
              <i class="ri-download-2-fill text-white text-lg"></i>
              Descargar
            </a>
          </div>
        </div>
      </div>

      <!-- Script Preview PDF -->
      <script>
        document.addEventListener("DOMContentLoaded", () => {
          const url = "<?php echo $row['ruta_pdf']; ?>";
          const canvas = document.getElementById("preview-<?php echo $row['id_libro']; ?>");
          const loader = document.getElementById("loader-<?php echo $row['id_libro']; ?>");
          const ctx = canvas.getContext("2d");

          pdfjsLib.getDocument(url).promise.then(pdf => pdf.getPage(1)).then(page => {
            const viewport = page.getViewport({ scale: 1 }); // más grande
            canvas.width = viewport.width;
            canvas.height = viewport.height;
            page.render({ canvasContext: ctx, viewport: viewport }).promise.then(() => {
              loader.style.display = "none";
              canvas.style.display = "block";
            });
          }).catch(err => {
            loader.style.display = "none";
            ctx.font = "14px Arial";
            ctx.fillText("Error cargando preview", 10, 50);
            canvas.style.display = "block";
          });
        });
      </script>
    <?php endwhile; ?>
  </div>
</body>
</html>
