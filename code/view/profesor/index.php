<?php
// Iniciar sesión
session_start();

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_profesor'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del profesor desde la sesión
$id_profesor = $_SESSION['id_profesor'];

// Realizar la conexión a la base de datos (asegúrate de reemplazar los valores con los correctos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos del profesor de la base de datos utilizando una consulta preparada
$stmt = $conn->prepare("SELECT nombre, apellido, correo_electronico, telefono, carrera_universitaria FROM profesores WHERE id_profesor = ?");
$stmt->bind_param("i", $id_profesor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El profesor fue encontrado, obtener los datos y mostrarlos
    $row = $result->fetch_assoc();
    $nombre = htmlentities($row['nombre']);
    $apellido = htmlentities($row['apellido']);
    $correo = htmlentities($row['correo_electronico']);
    $telefono = htmlentities($row['telefono']);
    $carrera_universitaria = htmlentities($row['carrera_universitaria']);
} else {
    // El profesor no fue encontrado, puedes mostrar un mensaje de error o redireccionar a otra página
    echo "Profesor no encontrado.";
    exit;
}

// Incluir el archivo header.php que contiene la estructura del encabezado de la página
include('header.php');
?>

<!-- Aquí va el contenido específico de la página index.php -->
<style>
	.table-bordered {
		border-collapse: separate;
		border: 1px solid #ddd;
		border-radius: 6px;
	}

	.table-bordered th,
	.table-bordered td {
		border: none;
	}

	.table-bordered thead th {
		border-bottom: 1px solid #ddd;
        text-align: center;
	}

	.table-bordered tbody > tr:first-child th,
	.table-bordered tbody > tr:first-child td {
		border-top: none;
	}

	.table-bordered tbody > tr:last-child th,
	.table-bordered tbody > tr:last-child td {
		border-bottom: none;
	}

	.table-bordered tbody > tr > th:first-child,
	.table-bordered tbody > tr > td:first-child {
		border-left: none;
	}

	.table-bordered tbody > tr > th:last-child,
	.table-bordered tbody > tr > td:last-child {
		border-right: none;
	}
</style>

<div class="container">
	<h1>Bienvenido al sistema, <?php echo $nombre . ' ' . $apellido; ?>!</h1>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th>Correo electrónico:</th>
				<td><?php echo $correo; ?></td>
			</tr>
			<tr>
				<th>Teléfono:</th>
				<td><?php echo $telefono; ?></td>
			</tr>
			<tr>
				<th>Carrera universitaria:</th>
				<td><?php echo $carrera_universitaria; ?></td>
			</tr>
		</tbody>
	</table>
</div>


<?php
// Aquí va el resto del contenido de la página index.php

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();

// Incluir el archivo footer.php que contiene la estructura del pie de página
include('footer.php');
?>