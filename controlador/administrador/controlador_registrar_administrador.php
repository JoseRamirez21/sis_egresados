<?php
if (!empty($_POST["btnregistrarA"])) {
   if (!empty($_POST["txtdni"]) and !empty($_POST["txtnombre"]) and !empty($_POST["txtusuario"]) and !empty($_POST["txtclave"])) {
      $dni = $_POST["txtdni"];
      $nombre = $_POST["txtnombre"];
      $apepat = $_POST["txtapepat"];
      $apemat = $_POST["txtapemat"];
      $correo = $_POST["txtcorreo"];
      $usuario = $_POST["txtusuario"];
      $clave = md5($_POST["txtclave"]);

      $verificarNombre = $conexion->query(" select count(*) as 'total' from usuario where dni='$dni' and usuario='$usuario' and clave='$clave' ");
      $total = $verificarNombre->fetch_object()->total;
      if ($total > 0) { ?>
         <script>
            $(function notificacion() {
               new PNotify({
                  title: "INCORRECTO",
                  type: "error",
                  text: "El registro ya existe",
                  styling: "bootstrap3"
               });
            });
         </script>
         <?php
      } else {
         try {
            $registrar = $conexion->query(" insert into usuario(dni,nombre,ape_paterno,ape_materno,correo,usuario,clave) 
            values('$dni','$nombre','$apepat','$apemat','$correo','$usuario','$clave') ");
         } catch (\Throwable $th) {
            $registrar = false;
         }
         if ($registrar == true) {
         ?>
            <script>
               $(function notificacion() {
                  new PNotify({
                     title: "CORRECTO",
                     type: "success",
                     text: "Se ha registrador correctamente",
                     styling: "bootstrap3"
                  });
               });
            </script>
         <?php
         } else {
         ?>
            <script>
               $(function notificacion() {
                  new PNotify({
                     title: "INCORRECTO",
                     type: "error",
                     text: "Error al registrar",
                     styling: "bootstrap3"
                  });
               });
            </script>
      <?php
         }
      }
   } else { ?>
      <script>
         $(function notificacion() {
            new PNotify({
               title: "INCORRECTO",
               type: "error",
               text: "Los campos estan vacíos",
               styling: "bootstrap3"
            });
         });
      </script>
   <?php } ?>


   <script>
      setTimeout(() => {
         window.history.replaceState(null, null, window.location.pathname);
      }, 0);
   </script>
<?php
}
