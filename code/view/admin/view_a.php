<?php
include '../../conexion.php';
include("header.php");

if (isset($_POST['buscar'])) {
	$valor = $_POST['buscar'];
	$sql = "SELECT a.id_alumno, a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado 
			FROM alumnos a 
			INNER JOIN grados g ON a.id_grado = g.id_grado 
			WHERE a.id_alumno = ? OR a.nombre LIKE ? OR a.fecha_nacimiento = ? OR a.apellidos LIKE ?
			ORDER BY a.apellidos, a.nombre";
	$stmt = $conexion->prepare($sql);
	$valor_like = "%" . $valor . "%";
	$stmt->bind_param("ssss", $valor, $valor_like, $valor, $valor_like);
	$stmt->execute();
  } else {
	// Consulta a la base de datos para obtener los datos de los alumnos
	$sql = "SELECT a.id_alumno, a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado 
			FROM alumnos a 
			INNER JOIN grados g ON a.id_grado = g.id_grado 
			ORDER BY a.apellidos, a.nombre";
	$stmt = $conexion->prepare($sql);
	$stmt->execute();
  }
  $resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Lista de alumnos</title>
</head>
<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}
		
		.search-form {
			position: absolute;
			top: 50px;
			right: 20px;
		}

		header {
			background-color: #333;
			color: #fff;
			padding: 10px;
			text-align: center;
		}

		h1 {
			margin-top: 0;
		}

		form {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			margin: 20px;
		}

		input[type="text"] {
			padding: 10px;
			font-size: 16px;
			border-radius: 5px 0 0 5px;
			border: none;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
		}

		button[type="submit"] {
			padding: 10px;
			font-size: 16px;
			background-color: #333;
			color: #fff;
			border-radius: 0 5px 5px 0;
			border: none;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
			cursor: pointer;
		}

		table {
			border-collapse: collapse;
			width: 100%;
			margin: 20px;
		}

		th, td {
			padding: 10px;
			border: 1px solid #ddd;
			text-align: left;
		}

		th {
			background-color: #333;
			color: #fff;
		}

		td a {
			color: #333;
			text-decoration: none;
			background-color: #ddd;
			padding: 5px 10px;
			border-radius: 5px;
		}

		td a:hover {
			background-color: #333;
			color: #fff;
		}

	</style>
<body>
	<h1>Lista de alumnos</h1>
	<form method="post" class="search-form">
		<input type="text" name="buscar" placeholder="Buscar por ID, nombre, fecha de nacimiento o apellido">
		<button type="submit">Buscar</button>
	</form>
	<table>
		<tr>
			<th>Nombre completo</th>
			<th>Fecha de nacimiento</th>
			<th>Grado</th>
			<th>Acciones</th>
		</tr>
		<?php while ($fila = $resultado->fetch_assoc()) { ?>
			<tr>
				<td><?php echo $fila['nombre'] . ' ' . $fila['apellidos']; ?></td>
				<td><?php echo $fila['fecha_nacimiento']; ?></td>
				<td><?php echo $fila['nombre_grado']; ?></td>
				<td>
					<a href="editar_alumno.php?id=<?php echo $fila['id_alumno']; ?>">Editar</a> | 
					<a href="ver_alumno.php?id=<?php echo $fila['id_alumno']; ?>">Ver</a>
				</td>
			</tr>
		<?php } ?>
	</table>
</body>
</html>
