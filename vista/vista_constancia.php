<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/estilos/estilos.css">
    <link rel="icon" href="../public/inicio/img/logo_naza.png">
    <title>Consulta Certificado Modular</title>
    <script src="../public/pnotify/js/jquery.min.js">
    </script>
</head>

<body>
    <?php
    include "../modelo/conexion.php";
    $id = $_GET["id"];
    $consulta = $conexion->query(" SELECT
    constancia.id_constancia,
    constancia.id_estudiante,
    constancia.anio,
    constancia.imagen,
    modulo.nombre as 'nomMod',
    modulo.numero,
    carrera.nombre,
    constancia.id_modulo
    FROM
    constancia
    INNER JOIN modulo ON constancia.id_modulo = modulo.id_modulo
    INNER JOIN carrera ON modulo.carrera = carrera.id_carrera
    where id_constancia=$id
    limit 1 ");
    ?>

    <div class="img-container">
        <?php
        while ($datos = $consulta->fetch_object()) { ?>
            <h1 class="titulo">VISTA PREVIA DE LA CONSTANCIA</h1><br>
            <h2><span>CARRERA:</span> <?= $datos->nombre ?></h2><br>
            <h2><span>MODULO:</span> <?= $datos->numero . " " . $datos->nomMod ?></h2>
            <img src="data:image/jpg;base64,<?= base64_encode($datos->imagen) ?>" />
        <?php }
        ?>
        <br><br>
        <a class="consulta" href="menu_coordinador.php">VOLVER</a>
    </div>



</body>

</html>