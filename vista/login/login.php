<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link rel="stylesheet" href="css/bootstrap.css">
   <link rel="icon" href="../../public/inicio/img/logo_tecno.png">
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
   <!-- <link rel="stylesheet" href="css/all.min.css"> -->
   <!-- <link rel="stylesheet" href="css/fontawesome.min.css"> -->

   <title>Inicio de sesión</title>
   <style>
      .tipo {
         padding: 20px 15px;
         width: 100%;
         border: none;
         border-bottom: solid #d9d9d9 2.5px;
         outline: none;
         color: #343434;
         margin-bottom: 5px;
      }

      .tipo:focus {
         border-bottom: solid #004a8d 2.5px;
      }
   </style>
</head>

<body style="background: #F7F7F7 ;">

   <img class="wave" src="img/wave.png.jpeg">
   <div class="container">
      <div class="img">

      </div>
      <div class="login-content">
         <form method="POST" action="">
            <img src="../../public/img-inicio/logo_tecno.png">
            <h2 class="title">BIENVENIDO</h2>
            <?php
            include "../../modelo/conexion.php";
            include "../../controlador/controlador_login.php";
            ?>
            <div class="input-div one">
               <div class="i">
                  <i class="fas fa-user"></i>
               </div>
               <div class="div">
                  <h5>Usuario</h5>
                  <input id="usuario" type="text" class="input" name="txtusuario" title="ingrese su nombre de usuario" autocomplete="usuario" value="">
               </div>
            </div>
            <div class="input-div pass">
               <div class="i">
                  <i class="fas fa-lock"></i>
               </div>
               <div class="div">
                  <h5>Contraseña</h5>
                  <input type="password" id="input" class="input" name="txtpassword" title="ingrese su clave para ingresar" autocomplete="current-password">
               </div>
            </div>
            <div class="view">
               <div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
            </div>
            <div>
               <div class="div">
                  <select name="txttipo" class="tipo" style="background: #F7F7F7;">
                     <option value="">Seleccionar...</option>
                     <option value="administrador">Administrador</option>
                     <option value="egresado">Egresado</option>
                  </select>
               </div>
            </div>


            <div class="text-center">
               <a class="font-italic isai5" href="">Olvidé mi contraseña</a>
            </div>
            <input name="btningresar" class="btn" title="click para ingresar" type="submit" value="INICIAR SESION">
         </form>
      </div>
   </div>
   <script src="js/fontawesome.js"></script>
   <script src="js/main.js"></script>
   <script src="js/main2.js"></script>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/bootstrap.bundle.js"></script>

</body>

</html>