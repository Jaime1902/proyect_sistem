<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Configuración básica de la página -->
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <!-- Enlace al archivo de estilos CSS -->
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- Contenedor principal de la página -->
    <div class="container">
      <!-- Encabezado del formulario de inicio de sesión -->
      <div class="login-header">
        <!-- Logo del colegio -->
        <img src="../img/logo/logo.png" alt="Logo del colegio">
        <!-- Título del formulario de inicio de sesión -->
        <h1>Iniciar sesión</h1>
     </div>

      <!-- Formulario de inicio de sesión -->
      <form action="login.php" method="post">
        <!-- Campo de entrada del nombre de usuario -->
        <div class="input-field">
          <input type="text" id="username" name="username" placeholder=" " />
          <label for="username">Usuario:</label>
        </div>

        <!-- Campo de entrada de la contraseña -->
        <br>
        <div class="input-field">
          <input type="password" id="password" name="password" placeholder=" "  class="form-control"/>
          <label for="password">Contraseña:</label>
          <!-- Botón para mostrar/ocultar la contraseña -->
          <span id="show-password" class="show-password"></span>
        </div>

        <!-- Botón para enviar el formulario de inicio de sesión -->
        <button type="submit">Ingresar</button>
      </form>
  </body>

  <!-- Enlace al archivo de scripts JavaScript -->
  <script src="script.js"></script>
</html>
