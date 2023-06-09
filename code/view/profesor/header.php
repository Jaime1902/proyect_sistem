<?php
 date_default_timezone_set('America/Managua');
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'profesor')) {
  header("location: ../../index.php");
  exit;
}

// Verificar si ha pasado más de 5 minutos desde la última acción del usuario
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 360)) {
  // Destruir la sesión
  session_unset();
  session_destroy();
  header("location: ../../index.php");
  exit;
}

// Actualizar el tiempo de última actividad de la sesión
$_SESSION['last_activity'] = time();

?>
<!DOCTYPE html>
<html>
<head>
	<title>profesor</title>
	<!-- Importar los estilos de Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<script>
    // Función para recargar la página después de cierto tiempo de inactividad
    function reloadAfterInactivity() {
        setTimeout(function() {
            location.reload();
        }, <?php echo (360 - (time() - $_SESSION['last_activity'])) * 1000; ?>);
    }

    // Llamar la función de recarga automática en la carga de la página
    window.onload = function() {
        reloadAfterInactivity();
    };
</script>
<style>
	.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 60px;
    padding: 0 20px;
    background-color: #d32f2f;
    color: #fff;
}

.dashboard-brand {
    font-size: 24px;
    font-weight: bold;
    margin: 0;

}

.dashboard-navbar {
    display: flex;
    align-items: center;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    height: 60px;
    padding: 0 20px;
}

.dashboard-navbar ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.dashboard-navbar ul li {
    display: inline-block;
    margin-right: 15px;
}

.dashboard-navbar ul li a {
    color: #0e0e0e;
    text-decoration: none;
    font-size: 18px;
}

.dashboard-navbar ul li a:hover {
    color: #e64c4c;
    text-decoration: underline;
}


</style>
<body>
	<header class="dashboard-header">
		<div class="container">
			<h1 class="dashboard-brand">Colegio Cristano Prebiteriano</h1>
		</div>
	</header>

	<nav class="dashboard-navbar">
		<div class="container">
			<ul>
				<li><a href="index.php">Inicio</a></li>
				<li><a href="view_grado.php">Calificar Notas</a></li>
				<li><a href="close.php">cerrar sesion</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<main>
			<!-- Contenido del panel de control -->
		</main>
	</div>

	<!-- Importar los scripts de Bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
