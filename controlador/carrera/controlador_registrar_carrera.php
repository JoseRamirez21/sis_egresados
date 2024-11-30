<?php
if (!empty($_POST["btnregistrar"])) {
   if (!empty($_POST["txtnombre"])) {
      $nombre = $_POST["txtnombre"];
      $verificarNombre = $conexion->query(" select count(*) as 'total' from carrera where nombre='$nombre' ");
      $total = $verificarNombre->fetch_object()->total;
      if ($total > 0) { ?>
         <script>
            $(function notificacion() {
               new PNotify({
                  title: "INCORRECTO",
                  type: "error",
                  text: "El nombre <?= $nombre ?> ya existe",
                  styling: "bootstrap3"
               });
            });
         </script>
         <?php
      } else {
         try {
            $registrar = $conexion->query(" insert into carrera(nombre) values('$nombre') ");
         } catch (\Throwable $th) {
            $registrar = 0;
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
