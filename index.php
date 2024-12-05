<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./public/estilos/estilos.css">
    <link rel="stylesheet" href="./public/estilos/estilos_consulta.css">

    <link rel="icon" href="./public/inicio/img/logo_naza.png">
    <title>Consulta Historial de Egresado</title>
</head>

<body>
    <!--fondo de pantalla-->
  <div class="wrapper">


<a href="./vista/login/login.php"" class="acceso">INICIAR SESION</a>
<?php
    include "modelo/conexion.php";
    include "controlador/busquedas/controlador_buscar_historial_egresado_index.php";
    ?>
    <div class="container">
        <h1>HISTORIAL EGRESADO<br>REALICE UNA CONSULTA</h1><br>
        <img src="public/img-inicio/logo_naza.png" width="500px" height="120px"> <br><br>
        <p class=" aviso">INGRESE EL DNI DEL EGRESADO</p>
        <form action="">
            <input required type="number" placeholder="Ingrese el DNI del egresado..." name="txtdni">
            <div class="botones">
                <button type="submit" class="consulta" href="">BUSCAR HISTORIAL</button>
            </div>
           
        </form>
    </div>

</body>

</html>