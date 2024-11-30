<?php
if (!empty($_POST["btnmodificar"])) {
   if (!empty($_POST["txtnombre"]) and !empty($_POST["txtid"])) {
      $nombre = $_POST["txtnombre"];
      $id = $_POST["txtid"];
      $verificarNombre = $conexion->query(" select count(*) as 'total' from carrera where nombre='$nombre' and id_carrera!=$id");
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
            $modificar = $conexion->query(" update carrera set nombre='$nombre' where id_carrera=$id ");
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
