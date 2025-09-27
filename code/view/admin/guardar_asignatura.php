<?php
// Conexión a la base de datos
include "../../conexion.php";

// Verificación de conexión
if (mysqli_connect_errno()) {
    echo "Error al conectarse a MySQL: " . mysqli_connect_error();
    exit();
}

// Recopilación de datos del formulario
$nombre_asignatura = $_POST['nombre_asignatura'];
$id_grado = $_POST['id_grado'];
$ruta_imagen = '../../img/Asignatura/predeterminada.png'; // Ruta por defecto para la imagen

// Verificar si se subió una imagen
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

// Consulta preparada para insertar los datos en la base de datos
$stmt = $conexion->prepare("INSERT INTO asignaturas (nombre_asignatura, id_grado, ruta_imagen) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $nombre_asignatura, $id_grado, $ruta_imagen);

// Ejecución de la consulta
if ($stmt->execute()) {
    header("Location: lobby_cursos.php");
} else {
    echo "Error al guardar la asignatura: " . $stmt->error;
}

// Cierre de la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
