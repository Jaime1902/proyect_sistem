<?php include "header.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Asignaturas por grado</title>
</head>
<body>
	<h1>Asignaturas del grado <?php echo $_GET['id_grado']; ?></h1>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre de la asignatura</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// Conexión a la base de datos
				include "../../conexion.php";

				// Comprobar la conexión
				if ($conexion->connect_errno) {
					echo 'Error en la conexión: ' . $conexion->connect_error;
					exit();
				}

				// Obtener las asignaturas correspondientes al grado seleccionado
				$query = "SELECT id_asignatura, nombre_asignatura FROM asignaturas WHERE id_grado = " . $_GET['id_grado'];
				$result = $conexion->query($query);

				// Mostrar las asignaturas en una tabla
				while ($row = $result->fetch_assoc()) {
					echo '<tr>';
					echo '<td>' . $row['id_asignatura'] . '</td>';
					echo '<td><a href="evaluar.php?id_asignatura=' . $row['id_asignatura'] . '&id_grado=' . $_GET['id_grado'] . '">' . $row['nombre_asignatura'] . '</a></td>';
					echo '</tr>';
				}

				// Liberar memoria y cerrar la conexión a la base de datos
				$result->free();
				$conexion->close();
			?>
		</tbody>
	</table>
</body>
</html>
