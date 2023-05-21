<?php
include("header.php");
include "../../conexion.php";

// Obtener la página actual
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Establecer el número de resultados por página y el desplazamiento
$resultados_por_pagina = 10;
$desplazamiento = ($pagina - 1) * $resultados_por_pagina;

// Obtener la información de los grados con límite y desplazamiento
$consulta = "SELECT * FROM grados";

// Verificar si se ha enviado una consulta de búsqueda
if (isset($_GET['buscar'])) {
  $busqueda = mysqli_real_escape_string($conexion, $_GET['buscar']);
  // Agregar la condición de búsqueda a la consulta
  $consulta .= " WHERE nombre_grado LIKE '%$busqueda%'";
}

$consulta .= " LIMIT $desplazamiento, $resultados_por_pagina";

$resultado = mysqli_query($conexion, $consulta);

// Obtener el número total de resultados para la paginación
$total_resultados = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM grados"));

// Calcular el número total de páginas
$total_paginas = ceil($total_resultados / $resultados_por_pagina);
?>

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

th,
td {
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
.delete-link {
		color: red;
	}

    .pagination {
		margin-top: 20px;
		display: flex;
		justify-content: center;
	}
	
	.pagination a {
		display: inline-block;
		padding: 10px;
		margin: 0 5px;
		background-color: #555;
		color: #fff;
		text-align: center;
		text-decoration: none;
		border-radius: 5px;
	}
	
	.pagination a:hover {
		background-color: #333;
	}
	
	.pagination .active {
		background-color: #333;
	}
</style>
<div class="search-form">
  <form action="" method="GET">
    <input type="text" name="buscar" placeholder="Buscar por nombre">
    <button type="submit">Buscar</button>
  </form>
</div>
<table>
  <tr>
  <th>Id</th>
    <th>Nombre Grado</th>
    <th>Acciones</th>
  </tr>
  <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
    <tr>
       <td><?php echo $fila['id_grado']; ?></td>
      <td><?php echo $fila['nombre_grado']; ?></td>
      <td>
      <a href="editar_grado.php?id=<?php echo $fila['id_grado']; ?>">Editar</a> |
        <a href="eliminar_grado.php?id=<?php echo $fila['id_grado']; ?>" class="delete-link" onclick="return confirm('¿Estás seguro de que deseas eliminar este grado?')">Eliminar</a>
      </td>
    </tr>
    
  <?php } ?>
</table>

<!-- Paginación -->
<div class="pagination">
  <?php if ($pagina > 1) { ?>
    <a href="?pagina=<?php echo ($pagina - 1); ?>">Anterior</a>
  <?php } ?>
  <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
    <a href="?pagina=<?php echo $i; ?>" <?php if ($i === $pagina) echo 'class="active"'; ?>><?php echo $i; ?></a>
  <?php } ?>
  <?php if ($pagina < $total_paginas) { ?>
    <a href="?pagina=<?php echo ($pagina + 1); ?>">Siguiente</a>
  <?php } ?>
</div>

<?php mysqli_close($conexion); ?>
