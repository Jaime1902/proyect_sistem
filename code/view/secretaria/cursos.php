<?php 
  include("header.php"); 
  ?>

<!DOCTYPE html>
<html>
<head>
	<title>Formulario de Asignaturas</title>
</head>
<body>
	<br><br>
	
	<form class="panel-form" action="guardar_asignatura.php" method="post">
	<h1>Formulario de Asignaturas</h1>
		<label for="nombre_asignatura">Nombre de la asignatura:</label><br>
		<input type="text" id="nombre_asignatura" name="nombre_asignatura"><br>

		<label for="id_grado">Grado:</label><br>
		<select id="id_grado" name="id_grado">
			<option value="">Seleccione un grado</option>
			<?php
			// Conexión a la base de datos
			include"../../conexion.php";

			// Verificación de conexión
			if (mysqli_connect_errno()) {
				echo "Error al conectarse a MySQL: " . mysqli_connect_error();
				exit();
			}

			// Consulta de grados disponibles
			$query = "SELECT id_grado, nombre_grado FROM grados";
			$resultado = mysqli_query($conexion, $query);

			// Creación de las opciones para el select
			while ($fila = mysqli_fetch_array($resultado)) {
				echo "<option value='" . $fila['id_grado'] . "'>" . $fila['nombre_grado'] . "</option>";
			}

			// Cierre de la conexión a la base de datos
			mysqli_close($conexion);
			?>
		</select><br>

		<input type="submit" value="Guardar">
	</form>
</body>
</html>
