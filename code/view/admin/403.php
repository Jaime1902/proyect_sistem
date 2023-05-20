<?php
 date_default_timezone_set('America/Managua');
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'administrador')) {
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Error</title>
    <style>
    body {
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .error-container {
        text-align: center;
    }

    .error-image {
        max-width: 400px;
        margin-bottom: 20px;
    }

    .error-heading {
        font-size: 36px;
        color: #333;
        margin-bottom: 10px;
    }

    .error-message {
        font-size: 18px;
        color: #666;
        margin-bottom: 20px;
    }

    .error-button {
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        border-radius: 4px;
    }

    .error-button:hover {
        background-color: #555;
    }
    </style>
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

<body>
    <div class="error-container">
        <img class="error-image" src="../../img/logo/navegador.png" alt="Error Image">
        <h1 class="error-heading">¡Ups! Algo salió mal.</h1>
        <br>
        <?php if(isset($_SESSION['error'])) { ?>
        <!-- Si hay un error en el inicio de sesión, se muestra el mensaje de error -->
        <div class="error">
            <p><?php echo $_SESSION['error']; ?></p>
        </div>
        <?php unset($_SESSION['error']); } ?>
        <br>
        <a class="error-button" href="index.php">Volver a la página principal</a>
    </div>
</body>

</html>