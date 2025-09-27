<?php 
  include("header.php"); 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Formulario de Asignaturas</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style>
		.drag-area {
			border: 2px dashed #ccc;
			border-radius: 5px;
			padding: 20px;
			text-align: center;
			cursor: pointer;
			color: #aaa;
			transition: border-color 0.3s ease;
		}
		.drag-area.dragging {
			border-color: #007bff;
		}
		.drag-area img {
			max-width: 100%;
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<form class="panel-form" action="guardar_asignatura.php" method="post" enctype="multipart/form-data">
					<h1 class="text-center mb-4">Formulario de Asignaturas</h1>
					<div class="mb-3">
						<label for="nombre_asignatura" class="form-label">Nombre de la asignatura:</label>
						<input type="text" id="nombre_asignatura" name="nombre_asignatura" class="form-control">
					</div>

					<div class="mb-3">
						<label for="id_grado" class="form-label">Grado:</label>
						<select id="id_grado" name="id_grado" class="form-select">
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
						</select>
					</div>

					<div class="mb-3 drag-area" id="drag-area">
						<p><i class="fas fa-cloud-upload-alt fa-2x"></i><br>Arrastra y suelta una imagen aquí o haz clic para seleccionar</p>
						<input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;">
						<img id="preview" src="#" alt="Vista previa" style="display: none;">
					</div>

					<div class="text-center">
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		const dragArea = document.getElementById('drag-area');
		const inputFile = document.getElementById('imagen');
		const preview = document.getElementById('preview');

		dragArea.addEventListener('click', () => {
			inputFile.click();
		});

		inputFile.addEventListener('change', (event) => {
			const file = event.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = () => {
					preview.src = reader.result;
					preview.style.display = 'block';
				};
				reader.readAsDataURL(file);
			}
		});

		dragArea.addEventListener('dragover', (event) => {
			event.preventDefault();
			dragArea.classList.add('dragging');
		});

		dragArea.addEventListener('dragleave', () => {
			dragArea.classList.remove('dragging');
		});

		dragArea.addEventListener('drop', (event) => {
			event.preventDefault();
			dragArea.classList.remove('dragging');

			const file = event.dataTransfer.files[0];
			if (file) {
				inputFile.files = event.dataTransfer.files;
				const reader = new FileReader();
				reader.onload = () => {
					preview.src = reader.result;
					preview.style.display = 'block';
				};
				reader.readAsDataURL(file);
			}
		});
	</script>
</body>
</html>
