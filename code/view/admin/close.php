<?php
// Iniciar sesión
session_start();

// Destruir sesión
session_destroy();

// Redirigir a la página de inicio de sesión
header("location: ../../index.php");
exit;

// Comprueba si la variable de sesión existe
if (isset($_SESSION['last_activity'])) {
    // Comprueba si ha pasado más de 5 minutos desde que se estableció la sesión
    if (time() - $_SESSION['last_activity'] > 300) {
        // Destruye la sesión
        session_unset();
        session_destroy();
        // Redirige al usuario a la página de inicio
        header('Location: index.php');
        exit;
    }
    // Actualiza la variable de sesión con el tiempo actual
    $_SESSION['last_activity'] = time();
} else {
    // Si la variable de sesión no existe, redirige al usuario a la página de inicio
    header('Location: index.php');
    exit;
}

?>
