<?php
session_start();
if (empty($_SESSION['id'])) {
   header('location:login/login.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../public/estilos/coordinador.css">
   <link rel="stylesheet" href="../public/estilos/estilo_coordinador.css">
   <link rel="icon" href="../public/inicio/img/logo_naza.png">
   <title>Menu Coordinador</title>
</head>

<body>
   <!--Hey! This is the original version
of Simple CSS Waves-->

   <div class="header">



      <!--Waves Container-->
      <div>

      
         <?php
         if ($_SESSION['tipo'] == "administrador") { ?>
            <div class="enlaces">
               <a href="inicio.php" id="admin">INGRESAR AL ADMINISTRADOR</a></h4>
               <a href="../controlador/controlador_cerrar_sesion.php" id="salir">SALIR</a></h4>
            </div>
         <?php } else { ?>
            <div class="enlaces">
               <a href="../controlador/controlador_cerrar_sesion.php" id="salir">SALIR</a></h4>
            </div>
         <?php
         }
         ?>

         <h1>BIENVENIDO <br> SISTEMA DE EGRESADOS</h1>

         <ul class="card-list">
            <li class="card">
               <a class="card-image" href="consulta_boleta_notas.php">
                  <img src="../public/img-inicio/boleta_notas.png">
               </a>
               <a class="card-description" href="consulta_boleta_notas.php">
                  <h2>BOLETA DE NOTAS</h2>
                  <p>Realice una consulta</p>
               </a>
            </li>

            <li class="card">
               <a class="card-image" href="consulta_certificado_modular.php">
                  <img src="../public/img-inicio/certificado_modular.png" alt="icono certificado modular">
               </a>
               <a class="card-description" href="consulta_certificado_modular.php">
                  <h2>CERTIFICADO MODULAR</h2>
                  <p>Realice una consulta</p>
               </a>
            </li>

            <li class="card">
               <a class="card-image" href="consulta_constancia_practicas.php">
                  <img src="../public/img-inicio/constancia_practicas.png" alt="icono constancia practicas" />
               </a>
               <a class="card-description" href="consulta_constancia_practicas.php">
                  <h2>CONSTACIA PRACTICAS</h2>
                  <p>Realice una consulta</p>
               </a>
            </li>

            <li class="card">
               <a class="card-image" href="consulta_historial_egresados.php">
                  <img src="../public/img-inicio/historial_egresado.png" alt="Icono historial egresado" />
               </a>
               <a class="card-description" href="consulta_historial_egresados.php">
                  <h2>HISTORIAL EGRESADO</h2>
                  <p>Realice una consulta</p>
               </a>
            </li>

         </ul><br>
         <img src="../public/img-inicio/logo_naza.png" width="650px" height="150px" alt=""><br><br><br>
      </div>
      <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
         <defs>
            <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
         </defs>
         <g class="parallax">



            <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
            <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
            <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
         </g>
      </svg>
   </div>
   <!--Waves end-->

   </div>
   <!--Header ends-->

   <!--Content starts-->

   <!--Content ends-->

</body>

</html>