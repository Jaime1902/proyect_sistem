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

<body>
    <div class="error-container">
        <img class="error-image" src="path/to/error-image.png" alt="Error Image">
        <h1 class="error-heading">¡Ups! Algo salió mal.</h1>
        <p class="error-message">Lo sentimos, ocurrió un error inesperado.</p>
        <p class="error-message">Por favor, inténtalo de nuevo más tarde.</p>
        <a class="error-button" href="index.php">Volver a la página principal</a>
    </div>
</body>

</html>
