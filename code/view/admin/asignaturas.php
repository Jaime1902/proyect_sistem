<?php include "header.php";?>
<!DOCTYPE html>
<html>
<head>
	<title>Asignaturas por grado</title>
	<style>
		#content {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			justify-content: center;
		}

		.module-asignatura {
			padding: 20px;
			border-radius: 5px;
			margin: 10px;
			text-align: center;
			background-color: #2196f3;
			flex: 1 0 20%;
		}

		.module-asignatura a {
			color: #fff;
			text-decoration: none;
			font-size: 24px;
			display: flex;
			justify-content: center;
		}
	</style>
</head>
<body>
<?php
		// Conexión a la base de datos
		include "../../conexion.php";

		// Comprobar la conexión
		if ($conexion->connect_errno) {
			echo 'Error en la conexión: ' . $conexion->connect_error;
			exit();
		}

		// Obtener el nombre del grado correspondiente al ID
		$id_grado = $_GET['id_grado'];
		$query_grado = "SELECT nombre_grado FROM grados WHERE id_grado = $id_grado";
		$result_grado = $conexion->query($query_grado);
		$row_grado = $result_grado->fetch_assoc();
		$nombre_grado = $row_grado['nombre_grado'];
	?>

	<h1>Asignaturas de <?php echo $nombre_grado; ?></h1>


	<div id="content">
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
				echo '<div class="module-asignatura">';
				echo '<a href="evaluar.php?id_asignatura=' . $row['id_asignatura'] . '&id_grado=' . $_GET['id_grado'] . '">' . $row['nombre_asignatura'] . '</a>';
				echo '</div>';
			}

			// Liberar memoria y cerrar la conexión a la base de datos
			$result->free();
			$conexion->close();
		?>
	</div>
</body>
</html>
