<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/estilos/estilos.css">
    <link rel="stylesheet" href="../public/estilos/estilos_consulta.css">
    <link rel="icon" href="../public/inicio/img/logo_tecno.png">
    <title>Consulta Boleta Notas</title>
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


    <div class="container">
        <h1>BOLETA DE NOTAS<br>REALICE UNA CONSULTA</h1><br>
        <img src="../public/img-inicio/logo_tecno.png" width="500px" height="120px" alt=""> <br><br>
        <p class=" aviso">INGRESE EL DNI DEL EGRESADO</p>
        <form action="vista_boleta_nota.php" method="get">
            <input type=" number" placeholder="Ingrese el DNI del egresado..." name="txtdni" id="val">
            <select required name="txtsemestre" class="input input__select" id="listaSemestre">
                <option value="">No exiten semestres...</option>
            </select>
            <div id="listaDatos" hidden></div>
            <div class="botones">
                <button type="submit" class="consulta" href="">BUSCAR BOLETA</button>
            </div>
            <div class="botones">
                <a class="consulta" href="menu_coordinador.php">VOLVER</a>
            </div>
        </form>
    </div>


    <script type="text/javascript">
        $('#val').keyup(function() {
            recargarListaSem();
            buscarDatosEstudiante();
        });
        $('#val').blur(function() {
            recargarListaSem();
            buscarDatosEstudiante();
        });
    </script>
    <script type="text/javascript">
        function recargarListaSem() {
            $.ajax({
                type: "POST",
                url: "ajax/listaSemestre.php",
                data: "cod2=" + $('#val').val(),
                success: function(q) {
                    $('#listaSemestre').html(q);
                }
            });
        }

        function buscarDatosEstudiante() {
            $.ajax({
                type: "POST",
                url: "ajax/listaDatos.php",
                data: "cod3=" + $('#val').val(),
                success: function(q) {
                    $('#listaDatos').html(q);
                }
            });
        }
    </script>
</body>

</html>