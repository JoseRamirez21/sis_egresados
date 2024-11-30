<?php
if (!empty($_POST["btnmodificarA"])) {
   if (!empty($_POST["txtid"]) and  !empty($_POST["txtdni"]) and !empty($_POST["txtnombre"]) and !empty($_POST["txtusuario"])) {
      $id = $_POST["txtid"];
      $dni = $_POST["txtdni"];
      $nombre = $_POST["txtnombre"];
      $apepat = $_POST["txtapepat"];
      $apemat = $_POST["txtapemat"];
      $correo = $_POST["txtcorreo"];
      $usuario = $_POST["txtusuario"];

      $verificarNombre = $conexion->query(" select count(*) as 'total' from usuario where dni='$dni' and usuario='$usuario' and id_usuario!=$id ");
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
            $registrar = $conexion->query(" update usuario set dni='$dni',nombre='$nombre',ape_paterno='$apepat',ape_materno='$apemat',correo='$correo',usuario='$usuario' where id_usuario=$id ");
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
                     text: "Se ha modificado correctamente",
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
                     text: "Error al modificar",
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




/* --------------------------- MODIFICAR CONTRASEÑA ---------------------------------- */
if (!empty($_POST["btnCambiarClaveA"])) {
   if (!empty($_POST["txtclave"])) {
      $id = $_POST["txtid"];
      $clave = md5($_POST["txtclave"]);
      try {
         $modificar = $conexion->query(" update usuario set clave='$clave' where id_usuario=$id ");
      } catch (\Throwable $th) {
         $modificar = 0;
      }
      if ($modificar == true) {
   ?>
         <script>
            $(function notificacion() {
               new PNotify({
                  title: "CORRECTO",
                  type: "success",
                  text: "Se ha modificado correctamente",
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
                  text: "Error al modificar",
                  styling: "bootstrap3"
               });
            });
         </script>
      <?php
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
