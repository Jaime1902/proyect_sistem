<?php
include '../../conexion.php';

include("header.php"); 


// Consulta a la base de datos para obtener los datos de los alumnos
$sql = "SELECT a.id_alumno, a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado 
        FROM alumnos a 
        INNER JOIN grados g ON a.id_grado = g.id_grado 
        ORDER BY a.apellidos, a.nombre";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Lista de alumnos</title>
</head>
<body>
	<h1>Lista de alumnos</h1>
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
