<!-- calificaciones.php -->
<?php include "header.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Calificaciones</title>
</head>
<body>
	<h1>Calificaciones</h1>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre del grado</th>
				<th>Acciones</th>
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

				// Obtener todos los grados
				$query = "SELECT * FROM grados";

				if ($result = $conexion->query($query)) {
					// Imprimir los resultados en una tabla
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . $row['id_grado'] . "</td>";
						echo "<td><a href='asignaturas.php?id_grado=" . $row['id_grado'] . "'>" . $row['nombre_grado'] . "</a></td>";
						echo "<td>Acciones</td>";
						echo "</tr>";
					}
					$result->free();
				} else {
					echo 'Error en la consulta: ' . $conexion->error;
				}

				// Cerrar la conexión
				$conexion->close();
			?>
		</tbody>
	</table>
</body>
</html>
