<?php 
  include("header.php"); 
  ?>


<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Mensualidades</title>
    <style>
    #resultado_busqueda {
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        z-index: 100;
    }

    #resultado_busqueda ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #resultado_busqueda li {
        padding: 5px;
        cursor: pointer;
    }

    #resultado_busqueda li:hover {
        background-color: #f2f2f2;
    }

    .disabled {
        pointer-events: none;
        opacity: 100;
    }
    
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Agregar evento de teclado al campo de búsqueda de alumnos
        $("#id_alumno").on("keyup", function() {
            var input = $(this).val();
            if (input.length > 0) {
                // Realizar búsqueda de alumnos que coincidan con el texto ingresado
                $.ajax({
                    type: "POST",
                    url: "buscar_alumnos.php",
                    data: {
                        input: input
                    },
                    success: function(response) {
                        $("#resultado_busqueda").html(response).show();
                    }
                });
            } else {
                $("#resultado_busqueda").hide();
            }
        });

        // Manejar la selección de un alumno de la lista de resultados
        $(document).on("click", "#resultado_busqueda li", function() {
            var alumno_id = $(this).data("alumno-id");
            var alumno_nombre = $(this).text();
            $("#id_alumno").val(alumno_nombre);
            $("#id_alumno_id").val(alumno_id);
            $("#resultado_busqueda").hide();
        });
        $(document).on("click", "#ver_mensualidades", function() {
    var id_alumno = $("#id_alumno_id").val();
    var url = $(this).attr("href");
    $.ajax({
        type: "POST",
        url: url,
        data: {id_alumno: id_alumno},
        success: function(response) {
            $("#mensualidades_container").html(response);
        }
    });
    return false; // Evita la redirección a la URL del enlace
});

    });
    </script>
</head>

<body>
    <h1>Formulario de Mensualidades</h1>
    <form action="guardar_mensualidad.php" method="post">
        <label for="id_alumno">Alumno:</label><br>
        <input type="text" id="id_alumno" name="id_alumno" autocomplete="off"><br>
        <div id="resultado_busqueda" style="display: none;"></div>
        <input type="hidden" id="id_alumno_id" name="id_alumno_id">


        <label for="fecha_pago">Fecha de pago:</label><br>
        <input type="date" id="fecha_pago" name="fecha_pago"><br>

        <label for="monto">Monto:</label><br>
        <input type="number" id="monto" name="monto" step="0.01"><br>

        <input type="submit" value="Guardar">
        <a id="ver_mensualidades" href="obtener_mensualidad.php?id_alumno=">Ver mensualidades</a>
        <div id="mensualidades_container"></div>


    </form>


</body>

</html>