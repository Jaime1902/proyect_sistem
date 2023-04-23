<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="login-container">
      <div class="login-form">
        <div class="login-header">
          <img src="img\logo\logo.png" alt="Logo del colegio">
          <h2>Iniciar sesión</h2>
        </div>
        <form action="login.php" method="post">
          <div class="form-group">
            <input type="text" id="username" name="username" required>
            <label for="username">Usuario:</label>
          </div>
          <br>
          <div class="form-group">
            <input type="password" id="password" name="password" required>
            <label for="password">Contraseña:</label>
          </div>
          <div class="form-group">
            <button type="submit">Ingresar</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
