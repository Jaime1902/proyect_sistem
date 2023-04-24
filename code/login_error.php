
<?php
session_start();
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <div class="login-header">
        <img src="img\logo\logo.png" alt="Logo del colegio">
        <h1>Iniciar sesión</h1>
        <?php if(isset($_SESSION['login_error'])) { ?>
  <div class="login-error">
    <p><?php echo $_SESSION['login_error']; ?></p>
  </div>
  <?php unset($_SESSION['login_error']); } ?>
  <br><br>

     </div>
      <form action="login.php" method="post">
        <div class="input-field">
          <input type="text" id="username" name="username" placeholder=" " />
          <label for="username">Usuario:</label>
        </div>
        <br>
        <div class="input-field">
          <input type="password" id="password" name="password" placeholder=" "  class="form-control"/>
          <label for="password">Contraseña:</label>
          <span id="show-password" class="show-password"></span>
        </div>
        <button type="submit">Ingresar</button>
  </body>
  <script src="script.js"></script>
</html>
