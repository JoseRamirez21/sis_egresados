<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/estilos/estilos_consulta.css">
    <link rel="stylesheet" href="../public/estilos/estilos.css">
    <link rel="icon" href="../public/inicio/img/logo_tecno.png">
    <title>Consulta Constancia Practicas</title>
    <!-- pNotify -->
    <link href="../public/pnotify/css/pnotify.css" rel="stylesheet" />
    <link href="../public/pnotify/css/pnotify.buttons.css" rel="stylesheet" />
    <link href="../public/pnotify/css/custom.min.css" rel="stylesheet" />

    <!-- pnotify -->
    <script src="../public/pnotify/js/jquery.min.js">
    </script>
    <script src="../public/pnotify/js/pnotify.js">
    </script>
    <script src="../public/pnotify/js/pnotify.buttons.js">
    </script>
</head>

<body>

    <!--fondo de pantalla-->
  <div class="wrapper">


    <?php
    include "../modelo/conexion.php";
    include "../controlador/busquedas/controlador_buscar_constancia.php";
    ?>
    <div class="container">
        <?php
        $carrera2 = $conexion->query(" select * from carrera");
        ?>
        <h1>CONSTANCIA PRACTICAS<br>REALICE UNA CONSULTA</h1>
        <img src="../public/img-inicio/logo_tecno.png" width="500px" height="120px alt=""> <br>
    <p class=" aviso">INGRESE EL DNI DEL EGRESADO</p>
        <form action="">
            <input type="number" placeholder="Ingrese el DNI del egresado..." name="txtdni">
            <select name="txtcarrera" class="input input__select" id="val">
                <option value="">Seleccionar carrera...</option>
                <?php
                while ($datosCarrera2 = $carrera2->fetch_object()) { ?>
                    <option value="<?= $datosCarrera2->id_carrera ?>"><?= $datosCarrera2->nombre ?></option>
                <?php }
                ?>
            </select>
            <select required name="txtmodulo" class="input input__select" id="listaModulo">
                <option value="">No exiten modulos...</option>
            </select>
            <div class="botones">
                <button type="submit" class="consulta" href="">BUSCAR CERTIFICADO</button>
            </div>
            <div class="botones">
                <a class="consulta" href="menu_coordinador.php">VOLVER</a>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $('#val').change(function() {
            recargarListaMod();
        });
    </script>
    <script type="text/javascript">
        function recargarListaMod() {
            $.ajax({
                type: "POST",
                url: "ajax/listaModulo.php",
                data: "cod=" + $('#val').val(),
                success: function(q) {
                    $('#listaModulo').html(q);
                }
            });
        }
    </script>
</body>

</html>