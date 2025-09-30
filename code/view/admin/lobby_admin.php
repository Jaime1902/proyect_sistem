<?php 
  include("header.php"); 
  ?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Nueva Cuenta</title>
</head>
<body>
    <br><br>
    <form class="panel-form " method="POST" action="guardar_cuenta.php">
    <h2>Crear Nueva Cuenta</h2>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required><br><br>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br><br>

        <label for="rol">Rol:</label>
        <select name="rol" required>
            <option value="administrador">Administrador</option>
            <option value="secretaria">Secretaria</option>
        </select><br><br>

        <input type="submit" value="Guardar Cuenta">
    </form>
</body>
</html>
