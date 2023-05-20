<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Editar Profesor</title>
  <!-- Incluimos los archivos necesarios de Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>

<?php
// Conexión a la base de datos
include"../../conexion.php";
include"header.php";

// Verificamos si la conexión fue exitosa
if (!$conexion) {
    die("La conexión ha fallado: " . mysqli_connect_error());
}

// Verificamos si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Recuperamos los datos del formulario
    $id_profesor = $_POST['id_profesor'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $certificaciones = $_POST['certificaciones'];
    $carrera_universitaria = $_POST['carrera_universitaria'];
    $grados = $_POST['grados'];
    $asignaturas = $_POST['asignaturas'];

    // Actualizamos los datos del profesor
    $query = "UPDATE profesores SET nombre='$nombre', apellido='$apellido', correo_electronico='$correo_electronico', telefono='$telefono', direccion='$direccion', certificaciones='$certificaciones', carrera_universitaria='$carrera_universitaria' WHERE id_profesor=$id_profesor";
    if (!mysqli_query($conexion, $query)) {
        die("Error al actualizar los datos del profesor: " . mysqli_error($conexion));
    }

    // Actualizamos las tablas intermedias profesores_grados y profesores_asignaturas
    // Borramos todos los registros antiguos y luego insertamos los nuevos
    $query = "DELETE FROM profesores_grados WHERE id_profesor=$id_profesor";
    if (!mysqli_query($conexion, $query)) {
        die("Error al borrar los registros antiguos de profesores_grados: " . mysqli_error($conexion));
    }
    foreach ($grados as $id_grado) {
        $query = "INSERT INTO profesores_grados (id_profesor, id_grado) VALUES ($id_profesor, $id_grado)";
        if (!mysqli_query($conexion, $query)) {
            die("Error al insertar los nuevos registros de profesores_grados: " . mysqli_error($conexion));
        }
    }

    $query = "DELETE FROM profesores_asignaturas WHERE id_profesor=$id_profesor";
    if (!mysqli_query($conexion, $query)) {
        die("Error al borrar los registros antiguos de profesores_asignaturas: " . mysqli_error($conexion));
    }
    foreach ($asignaturas as $id_asignatura) {
        $query = "INSERT INTO profesores_asignaturas (id_profesor, id_asignatura) VALUES ($id_profesor, $id_asignatura)";
        if (!mysqli_query($conexion, $query)) {
            die("Error al insertar los nuevos registros de profesores_asignaturas: " . mysqli_error($conexion));
        }
    }

    // Redirigimos al usuario a la página de listado de profesores
    header("Location: lobby_profesor.php");
    exit();
}

// Recuperamos el ID del profesor a editar
if (!isset($_GET['id'])) {
    die("Se requiere el ID del profesor a editar");
}
$id_profesor = $_GET['id'];

// Recuperamos los datos del profesor
$query = "SELECT * FROM profesores WHERE id_profesor=$id_profesor";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error al recuperar los datos del profesor: " . mysqli_error($conexion));
}
$profesor = mysqli_fetch_assoc($resultado);


// Recuperamos los grados del profesor
$query = "SELECT id_grado FROM profesores_grados WHERE id_profesor=$id_profesor";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error al recuperar los grados del profesor: " . mysqli_error($conexion));
}
$grados = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $grados[] = $fila['id_grado'];
}

// Recuperamos las asignaturas del profesor
// Recuperamos las asignaturas del profesor
$query = "SELECT id_asignatura FROM profesores_asignaturas WHERE id_profesor=$id_profesor";
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die("Error al recuperar las asignaturas del profesor: " . mysqli_error($conexion));
}
$asignaturas = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $asignaturas[] = $fila['id_asignatura'];
}

// Recuperamos los grados y las asignaturas de la base de datos
// Recuperamos los grados y las asignaturas de la base de datos
$query = "SELECT * FROM grados";
$resultado_grados = mysqli_query($conexion, $query);
if (!$resultado_grados) {
    die("Error al recuperar los grados: " . mysqli_error($conexion));
}

$query = "SELECT * FROM asignaturas";
$resultado_asignaturas = mysqli_query($conexion, $query);
if (!$resultado_asignaturas) {
    die("Error al recuperar las asignaturas: " . mysqli_error($conexion));
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar Profesor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <br><br>
    <form class="panel-form" method="post">
    <h1>Editar Profesor</h1>
        <input type="hidden" name="id_profesor" value="<?php echo $profesor['id_profesor']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $profesor['nombre']; ?>" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="<?php echo $profesor['apellido']; ?>" required><br>

        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" name="correo_electronico" id="correo_electronico" value="<?php echo $profesor['correo_electronico']; ?>" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" id="telefono" value="<?php echo $profesor['telefono']; ?>" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" value="<?php echo $profesor['direccion']; ?>" required><br>

        <label for="certificaciones">Certificaciones:</label>
        <input type="text" name="certificaciones" id="certificaciones" value="<?php echo $profesor['certificaciones']; ?>"><br>

        <label for="carrera_universitaria">Carrera universitaria:</label>
        <input type="text" name="carrera_universitaria" id="carrera_universitaria" value="<?php echo $profesor['carrera_universitaria']; ?>"><br>

        <label for="grados">Grados:</label>
        <select name="grados[]" id="grados" multiple required>
            <?php while ($grado = mysqli_fetch_assoc($resultado_grados)): ?>
            <option value="<?php echo $grado['id_grado']; ?>" <?php if (in_array($grado['id_grado'], $grados)): ?>selected<?php endif; ?>><?php echo $grado['nombre_grado']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="asignaturas">Asignaturas:</label>
        <select name="asignaturas[]" id="asignaturas" multiple required>
            <?php
            while ($asignatura = mysqli_fetch_assoc($resultado_asignaturas)):
                $id_asignatura = $asignatura['id_asignatura'];
                $nombre_asignatura = $asignatura['nombre_asignatura'];
                $id_grado = $asignatura['id_grado'];

                // Recuperamos el nombre del grado de la tabla "grados"
                $query_grado = "SELECT nombre_grado FROM grados WHERE id_grado = $id_grado";
                $resultado_grado = mysqli_query($conexion, $query_grado);
                $grado = mysqli_fetch_assoc($resultado_grado);
                $nombre_grado = $grado['nombre_grado'];
            ?>
            <option value="<?php echo $id_asignatura; ?>" <?php if (in_array($id_asignatura, $asignaturas)): ?>selected<?php endif; ?>>
                <?php echo $nombre_asignatura; ?> (<?php echo $nombre_grado; ?>)
            </option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" name="submit" value="Guardar cambios">
    </form>
</body>

</html>


<!-- Inicializamos los selectores de Select2 -->
<script>
$(document).ready(function() {
  $("#grados").select2();
  $("#asignaturas").select2();
});

</script>

</body>
</html>