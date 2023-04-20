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
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" placeholder="Ingrese su nombre de usuario">
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña">
          </div>
          <div class="form-group">
            <button type="submit">Ingresar</button>
          </div>
          <div class="error-message">
          <label>Error al Iniciar sesion</label>
        </div>
        </form>
      </div>
    </div>
  </body>
</html>
               
