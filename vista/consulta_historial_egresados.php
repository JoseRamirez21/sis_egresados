<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/estilos/estilos.css">
    <link rel="stylesheet" href="../public/estilos/estilos_consulta.css">
    <link rel="icon" href="../public/inicio/img/logo_tecno.png">
    <title>Consulta Historial Egresado</title>
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

<body>
<!--fondo de pantalla-->
  <div class="wrapper">

    


    <?php
    include "../modelo/conexion.php";
    include "../controlador/busquedas/controlador_buscar_historial_egresado.php";
    ?>
    <div class="container">
        <h1>HISTORIAL EGRESADO<br>REALICE UNA CONSULTA</h1><br>
        <img src="../public/img-inicio/logo_tecno.png" width="500px" height="120px"> <br><br>
        <p class=" aviso">INGRESE EL DNI DEL EGRESADO</p>
        <form action="">
            <input required type="number" placeholder="Ingrese el DNI del egresado..." name="txtdni">
            <div class="botones">
                <button type="submit" class="consulta" href="menu_coordinador.php">BUSCAR HISTORIAL</button>
            </div>
            <div class="botones">
                <a class="consulta" href="menu_coordinador.php">VOLVER</a>
            </div>
        </form>
    </div>


</body>

</html>