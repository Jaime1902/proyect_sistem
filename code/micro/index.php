<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "mysql";
$db   = "project_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $id_asignatura = $_POST['id_asignatura'] ?? '';
    $pdf = $_FILES['pdf'] ?? null;

    $carpetaDestino = "../pdfs/";
    if (!file_exists($carpetaDestino)) mkdir($carpetaDestino, 0777, true);

    if ($pdf && $pdf['tmp_name']) {
        $nombreArchivo = basename($pdf["name"]);
        $rutaArchivo = $carpetaDestino . time() . "_" . $nombreArchivo;
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));

        if ($tipoArchivo != "pdf") {
            $mensaje = ["tipo" => "error", "texto" => "Solo se permiten archivos PDF."];
        } else {
            if (move_uploaded_file($pdf["tmp_name"], $rutaArchivo)) {
                $stmt = $conn->prepare("INSERT INTO libros (id_asignatura, titulo, autor, ruta_pdf) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $id_asignatura, $titulo, $autor, $rutaArchivo);
                $mensaje = $stmt->execute() ? ["tipo" => "success", "texto" => "Libro subido correctamente."] : ["tipo" => "error", "texto" => "Error al guardar en la base de datos."];
                $stmt->close();
            } else {
                $mensaje = ["tipo" => "error", "texto" => "Error al subir el archivo."];
            }
        }
    }
}

$asignaturas = $conn->query("SELECT id_asignatura, nombre_asignatura FROM asignaturas ORDER BY nombre_asignatura");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Subir Libro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Remix Icon -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <!-- Dropzone.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

  <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2
      class="text-xl sm:text-2xl font-bold mb-6 text-center text-blue-600 flex items-center justify-center gap-2 leading-tight">
      <i class="ri-book-2-fill text-blue-600 text-2xl sm:text-3xl"></i>
      Subir Libro
    </h2>

    <?php if ($mensaje): ?>
    <div
      class="mb-4 p-3 rounded-lg text-white flex items-center gap-2 text-sm sm:text-base <?php echo $mensaje['tipo'] == 'error' ? 'bg-red-500' : 'bg-green-500'; ?>">
      <?php if ($mensaje['tipo'] == 'error'): ?>
      <i class="ri-error-warning-fill text-white text-lg sm:text-xl"></i>
      <?php else: ?>
      <i class="ri-checkbox-circle-fill text-white text-lg sm:text-xl"></i>
      <?php endif; ?>
      <span><?php echo $mensaje['texto']; ?></span>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block font-medium text-gray-700 text-sm sm:text-base">Título del libro</label>
        <input type="text" name="titulo" required
          class="mt-1 block w-full p-2 sm:p-3 text-sm sm:text-base border rounded-lg focus:ring focus:ring-blue-300">
      </div>

      <div>
        <label class="block font-medium text-gray-700 text-sm sm:text-base">Autor</label>
        <input type="text" name="autor"
          class="mt-1 block w-full p-2 sm:p-3 text-sm sm:text-base border rounded-lg focus:ring focus:ring-blue-300">
      </div>

      <div>
        <label class="block font-medium text-gray-700 text-sm sm:text-base">Asignatura</label>
        <select name="id_asignatura" required
          class="mt-1 block w-full p-2 sm:p-3 text-sm sm:text-base border rounded-lg focus:ring focus:ring-blue-300">
          <option value="">Seleccione una asignatura</option>
          <?php while ($row = $asignaturas->fetch_assoc()): ?>
          <option value="<?php echo $row['id_asignatura']; ?>"><?php echo $row['nombre_asignatura']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- Zona Drag & Drop -->
      <div class="mt-4">
        <label class="block font-medium text-gray-700 text-sm sm:text-base mb-1">Archivo PDF</label>
        <div id="pdfDropzone"
          class="dropzone flex flex-col items-center justify-center border-2 sm:border-4 border-dashed border-blue-400 rounded-xl sm:rounded-2xl bg-gradient-to-b from-blue-50 to-white hover:from-blue-100 hover:to-white transition cursor-pointer p-6 sm:p-8 text-center text-gray-500">
          <i class="ri-upload-cloud-2-fill text-3xl sm:text-4xl mb-2 text-blue-400"></i>
          <p class="mb-2 text-sm sm:text-base">Arrastra el PDF aquí o haz click para seleccionarlo</p>
          <span class="text-xs sm:text-sm text-gray-400" id="fileName">Ningún archivo seleccionado</span>
        </div>
      </div>

      <button type="submit"
        class="w-full bg-blue-600 text-white p-2 sm:p-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2 text-sm sm:text-base mt-4">
        <i class="ri-upload-line text-white text-lg sm:text-xl"></i>
        Subir Libro
      </button>
    </form>
  </div>

</body>
</html>


    <script>
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone("#pdfDropzone", {
            url: "#",
            autoProcessQueue: false,
            acceptedFiles: "application/pdf",
            maxFiles: 1,
            addRemoveLinks: true,
            dictDefaultMessage: "",
            init: function() {
                this.on("addedfile", function(file) {
                    document.getElementById("fileName").textContent = file.name;
                });
                this.on("removedfile", function() {
                    document.getElementById("fileName").textContent = "Ningún archivo seleccionado";
                });
            }
        });

        const form = document.querySelector("form");
        form.addEventListener("submit", function(e) {
            if (myDropzone.files.length > 0) {
                const fileInput = document.createElement("input");
                fileInput.type = "hidden";
                fileInput.name = "pdf";
                fileInput.value = myDropzone.files[0];
                form.appendChild(fileInput);
            }
        });
    </script>

</body>
</html>
