<?php
include"header.php";
?>


<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
</head>
<body>
    <br><br>
    <form class="panel-form " method="POST" action="guardar_contraseña.php">
    <h2>Cambiar Contraseña</h2>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required><br><br>
        
        <label for="nuevaContrasena">Nueva Contraseña:</label>
        <input type="password" name="nuevaContrasena" required><br><br>

        <input type="submit" value="Cambiar Contraseña">
    </form>
</body>
</html>
