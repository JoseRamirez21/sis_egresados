<?php
if (!empty($_GET["txtdni"]) and !empty($_GET["txtsemestre"])) {

    $dni = $_GET["txtdni"];
    $id_semestre = $_GET["txtsemestre"];
    $id_estudiante = $_GET["txtid"];
    $id_carrera = $_GET["txtcarrera"];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/estilos/estilos.css">
        <link rel="icon" href="../public/inicio/img/logo_tecno.png">
        <title>Consulta Certificado Modular</title>
        </script>
        <style>
            * {
                margin: 0;
                padding: 10px;
                box-sizing: border-box;
            }

            .container2 {
                width: 100%;
            }

            body {
                font-size: 17px;
                font-weight: 100;
            }

            .logo {
                width: 200px;
            }

            .mine {
                width: 300px;
            }

            .div__logo {
                display: flex;
                justify-content: space-between;
            }

            h1 {
                text-align: center;
                font-size: 1.5rem;
            }

            .titulo {
                text-align: center;
                font-size: 1.2rem;
            }

            .tabla1 {
                width: 90%;
                margin: auto;
                text-align: center;
            }
            .tr {
                background: rgb(0,74,141);
            }

            th,td{
                background-color: rgb(232,234,245);
            }

            .linea1{
                background: rgb(0,74,141);
            }
            
            .linea2{
                background: rgb(0,74,141);
            }

            .th1 {
                background: rgb(0,74,141);
            }

             .th1 {
                background: rgb(0,74,141);
            }


            .tr1:nth-child(odd),
            .trdatos {
                background: rgb(232, 234, 245);
            }

            .final {
                font-weight: bold;
                background: rgb(232, 234, 245);
            }

            th,
            tr,
            td {
                border: solid rgb(211, 211, 211) 1px;
            }

            @media screen and (max-width:760px) {
                .tabla1 {
                    width: 100%;
                }

                body {
                    padding: 0;
                    font-size: 15px;
                }
            }

        </style>
        <script src="../public/chart/chart.js"></script>
    </head>

    <body>

        <a target="_blank" style="background: green;color: white; text-decoration:none  "  href="fpdf/Resultado_nota_pdf.php?txtdni=<?= $dni ?>&txtsemestre=<?= $id_semestre ?>&txtid=<?= $id_estudiante ?>&txtcarrera=<?= $id_carrera ?>">Descargar PDF</a>
        <a style="background: red;color: white; text-decoration:none" href="menu_coordinador.php">Salir</a>
        <div class="container2">
            <div class="div__logo">
                <img src="../public/img-inicio/mine.jpg" class="mine" alt="">
                <img src="../public/img-inicio/logo.jpg" class="logo" alt="">
            </div>
            <h1>INSTITUTO DE EDUCACION SUPERIOR TECNOLOGICO PÚBLICO "HUANTA"</h1>
            <h2 class="titulo">BOLETA DE INFORMACION DE RENDIMIENTO ACADÉMICO</h2>
            <?php
            include "../modelo/conexion.php";
            $carrera = $conexion->query(" SELECT estudiante.nombre,apellido_paterno,apellido_materno,estudiante.id,dni,carrera.id_carrera,carrera.nombre as 'nomCarrera' FROM estudiante INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera where dni='$dni' ");

            $semestre = $conexion->query(" select * from semestre where id_semestre=$id_semestre ");

            $datosSemestre = $semestre->fetch_object();
            $datosCarrera = $carrera->fetch_object();


            $sql3 = $conexion->query(" SELECT
            nota.id_nota,nota.estudiante,nota.unidad,nota.puntaje,nota.observacion,nota.semestre,nota.nota,estudiante.dni,estudiante.nombre,estudiante.apellido_paterno,
            estudiante.apellido_materno,semestre.semestre AS nom_semestre,semestre.`año`,unidades.nombre AS nomUnidad,unidades.carrera,unidades.credito
            FROM nota INNER JOIN estudiante ON nota.estudiante = estudiante.id
            INNER JOIN semestre ON nota.semestre = semestre.id_semestre
            INNER JOIN unidades ON nota.unidad = unidades.id_unidades
            WHERE unidades.carrera=$id_carrera and unidades.semestre=$id_semestre and nota.semestre=$id_semestre and nota.estudiante=$id_estudiante ");

            $sinNota = $conexion->query(" SELECT
            unidades.nombre,
            unidades.id_unidades,
            unidades.credito
            FROM
            unidades
            WHERE carrera=$id_carrera
            and unidades.semestre=$id_semestre
            and id_unidades not in(SELECT nota.unidad from nota where nota.estudiante=$id_estudiante and nota.semestre=$id_semestre ) ");

            ?>
            <table class="tabla1">
                <tr class="tr1">
                    <th class="th1" rowspan="2">Programa de estudios</th>
                    <th rowspan="2"><?= $datosCarrera->nomCarrera ?></th>

                    <th class="th1">Periodo Academico</th>
                    <th><?= $datosSemestre->año ?></th>

                </tr>

                <tr>
                    <th class="th1">Semestre Academico</th>
                    <th><?= $datosSemestre->semestre ?></th>
                </tr>
            </table>
            <table class="tabla1">
                <tr class="th1">
                    <th class="linea2">N° de Matricula</th>
                    <th class="linea2">APELLIDOS Y NOMBRES <br> (Por orden alfabetico)<br></th>
                </tr>
                <tr class="trdatos">
                    <th><?= $datosCarrera->dni ?></th>
                    <th><?= $datosCarrera->apellido_paterno . " " . $datosCarrera->apellido_materno . ", " . $datosCarrera->nombre  ?></th>
                </tr>
            </table>

            <table class="tabla1">
                <thead>
                    <tr>
                        <th class="linea1" scope="col">UNIDAD DIDÁCT</th>
                        <th class="linea1" scope="col">CREDITO</th>
                        <th class="linea1" scope="col">NOTA</th>
                        <th class="linea1" scope="col">PUNTAJE</th>
                        <th class="linea1" scope="col">OBSERVACIÓN</th>
                    </tr>
                </thead>
                <tbody id="datos">
                    <?php
                    while ($datosNota = $sql3->fetch_object()) { ?>

                        <tr>
                            <td style="width: 500px;text-align: left;"><?= $datosNota->nomUnidad ?></td>
                            <td style="width: 100px"><?= $datosNota->credito ?></td>

                            <th style="width: 100px"><?= $datosNota->nota ?></th>
                            <td style="width: 100px"><?= $datosNota->puntaje ?></td>
                            <td style="text-align: left;"><?= $datosNota->observacion ?></td>
                        </tr>
                    <?php }
                    ?>

                </tbody>
            </table>

            <br><br>

            <table class="tabla1">
                <thead>
                    <tr>
                        <th scope="col">UNIDAD DIDÁCT</th>
                        <th scope="col">CREDITO</th>
                        <th scope="col">NOTA</th>
                        <th scope="col">PUNTAJE</th>
                        <th scope="col">OBSERVACIÓN</th>
                    </tr>
                </thead>
                <tbody id="datos">
                    <?php
                    while ($datosSinNota = $sinNota->fetch_object()) { ?>

                        <tr>
                            <td style="width: 500px;text-align: left;"><?= $datosSinNota->nombre ?></td>
                            <td style="width: 100px"><?= $datosSinNota->credito ?></td>
                            <th style="width: 100px"></th>
                            <td style="width: 100px"></td>
                            <td></td>
                        </tr>
                    <?php }
                    ?>

                </tbody>
            </table>

            <!-- <h2 class="titulo">REPORTE SEMESTRAL DE CALIFICACIONES</h2> -->


        </div>


        <div class="container3" style="width: 100%;">
            <canvas id="grafica" height="90"></canvas>
        </div>

        <!-- <script>
            <?php
            include "../modelo/conexion.php";
            $unidades = $conexion->query(" SELECT estudiante.id,carrera.id_carrera,unidades.id_unidades,unidades.nombre,unidades.credito FROM estudiante INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera INNER JOIN unidades ON unidades.carrera = carrera.id_carrera where id=$id_estudiante ");
            $unida = $conexion->query("select GROUP_CONCAT(nombre) as 'nombre' from unidades where carrera=$id_carrera ");
            $unidadReporte = $conexion->query("SELECT nota.unidad,nota.nota FROM nota INNER JOIN estudiante ON nota.estudiante = estudiante.id
            INNER JOIN semestre ON nota.semestre = semestre.id_semestre
            where nota.semestre=$id_semestre and nota.estudiante=$id_estudiante");
            $unidad2 = $unida->fetch_object()->nombre;
            $unidad3 = explode(",", $unidad2);
            $datos = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            while ($datosUnidades = $unidades->fetch_object()) {
                while ($datosUnidadReporte = $unidadReporte->fetch_object()) {
                    if ($datosUnidades->id_unidades == $datosUnidadReporte->unidad) {
                        //$data[$key] = $value2->nota;
                    }
                }
            }


            ?>
            uni = <?= $unidad3 ?>
            // Obtener una referencia al elemento canvas del DOM
            const $grafica = document.querySelector("#grafica");
            // Las etiquetas son las que van en el eje X.
            const etiquetas = ["Enero", "Febrero", "Marzo", "Abril"]
            // Podemos tener varios conjuntos de datos. Comencemos con uno
            const datosVentas2020 = {
                label: "REPORTE DE NOTAS POR SEMESTRE",
                data: datos, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 1, // Ancho del borde
            };
            new Chart($grafica, {
                type: 'bar', // Tipo de gráfica
                data: {
                    labels: uni,
                    datasets: [
                        datosVentas2020,
                        // Aquí más datos...
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
        </script> -->
    </body>

    </html>

<?php }
