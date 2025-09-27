<?php
// Conexión a la base de datos
include "../../conexion.php";
include "header.php";

// Obtener el ID de la asignatura a editar
$id_asignatura = $_GET['id'];

// Obtener los datos de la asignatura
$query = "SELECT * FROM asignaturas WHERE id_asignatura = $id_asignatura";
$result = $conexion->query($query);
$row = $result->fetch_assoc();

// Si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_asignatura = $_POST['nombre_asignatura'];
    $ruta_imagen = $row['ruta_imagen']; // Mantener la imagen actual por defecto

    // Verificar si se subió una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Información del archivo
        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        // Validar la extensión del archivo
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($extension), $extensionesPermitidas)) {
            // Generar un nombre único para la imagen
            $nombreUnico = uniqid('asignatura_', true) . '.' . $extension;

            // Ruta de destino para guardar la imagen
            $rutaDestino = '../../img/Asignatura/' . $nombreUnico;

            // Mover la imagen al destino
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                $ruta_imagen = $rutaDestino;
            } else {
                echo "Error al mover la imagen.";
                exit();
            }
        } else {
            echo "Extensión no permitida. Solo se permiten imágenes JPG, JPEG, PNG y GIF.";
            exit();
        }
    }

    // Actualizar la asignatura en la base de datos
    $query = "UPDATE asignaturas SET nombre_asignatura = '$nombre_asignatura', ruta_imagen = '$ruta_imagen' WHERE id_asignatura = $id_asignatura";
    $result = $conexion->query($query);

    // Redirigir a la lista de asignaturas
    header('Location: view_cursos.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar asignatura</title>
</head>
<body>
    <br><br>

    <form class="panel-form" method="POST" enctype="multipart/form-data">
        <h1>Editar asignatura</h1>
        <div>
            <label for="nombre_asignatura">Nombre:</label>
            <input type="text" id="nombre_asignatura" name="nombre_asignatura" value="<?php echo $row['nombre_asignatura']; ?>" required>
        </div>
        <div>
            <label for="imagen">Imagen de la asignatura:</label><br>
            <img src="<?php echo $row['ruta_imagen']; ?>" alt="Imagen actual" style="max-width: 150px; margin-bottom: 10px;">
            <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
