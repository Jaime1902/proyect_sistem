<?php
    // Conexión a la base de datos
    include "../../conexion.php";
    include"header.php";

    // Obtener el ID de la asignatura a editar
    $id_asignatura = $_GET['id'];

    // Obtener los datos de la asignatura
    $query = "SELECT * FROM asignaturas WHERE id_asignatura = $id_asignatura";
    $result = $conexion->query($query);
    $row = $result->fetch_assoc();

    // Si se envió el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_asignatura = $_POST['nombre_asignatura'];

        // Actualizar la asignatura en la base de datos
        $query = "UPDATE asignaturas SET nombre_asignatura = '$nombre_asignatura' WHERE id_asignatura = $id_asignatura";
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

    <form class="panel-form" method="POST">
    <h1>Editar asignatura</h1>
        <div>
            <label for="nombre_asignatura">Nombre:</label>
            <input type="text" id="nombre_asignatura" name="nombre_asignatura" value="<?php echo $row['nombre_asignatura']; ?>" required>
        </div>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>