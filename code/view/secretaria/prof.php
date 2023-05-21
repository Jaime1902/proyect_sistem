<?php 
  include("header.php"); 
  ?>

<!DOCTYPE html>
<html>

<head>
    <title>Agregar profesor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
</head>

<body>
    <br><br>
    
    <form class="panel-form"  action="agregar_profesor.php" method="POST">
    <h1>Agregar profesor</h1>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" id="correo_electronico" name="correo_electronico" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>

        <label for="grado">Grado:</label>
        <select id="grado" name="grado[]" multiple="multiple">
            <?php
            include "../../conexion.php";
            $consulta_grados = "SELECT * FROM grados";
            $resultado_grados = mysqli_query($conexion, $consulta_grados);
            while ($fila_grados = mysqli_fetch_assoc($resultado_grados)) {
                echo "<option value='" . $fila_grados['id_grado'] . "'>" . $fila_grados['nombre_grado'] . "</option>";
            }
            mysqli_close($conexion);
            ?>
        </select><br>

        <label for="asignatura">Asignatura:</label>
        <select id="asignatura" name="asignatura[]" multiple="multiple">
            <option value="">Seleccione un grado primero</option>
        </select><br>

        <label for="certificaciones">Certificaciones:</label>
        <textarea id="certificaciones" name="certificaciones"></textarea><br>

        <label for="carrera_universitaria">Carrera universitaria:</label>
        <input type="text" id="carrera_universitaria" name="carrera_universitaria"><br>


        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username"><br>

        <label for="password">Contraseña:</label>
        <input type="text" id="password" name="password"><br>
        
        <input type="hidden" name="role" value="profesor">

        <input type="submit" value="Agregar profesor">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#grado').select2({
            placeholder: "Seleccione uno o varios grados",
            allowClear: true
        });
        $(document).ready(function() {
        $('#asignatura').select2({
        allowClear: true
       });
       });

        $('#grado').on('change', function() {
            var id_grado = $(this).val();
            if (id_grado != '') {
                $.ajax({
                    url: 'obtener_asignaturas.php',
                    type: 'POST',
                    data: {grado: id_grado},
                    success: function(data) {
                        $('#asignatura').html(data);
                    }
                });
            } else {
                $('#asignatura').html("<option value=''>Seleccione un grado primero</option>");
            }
        });
    });
</script>
