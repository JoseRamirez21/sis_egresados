<?php
if (!empty($_POST["btnmodificarM"])) {
   if (!empty($_POST["txtid"])  and !empty($_POST["txtcarrera"]) and !empty($_POST["txtnumero"]) and !empty($_POST["txtnombre"])) {
      $id = $_POST["txtid"];
      $carrera = $_POST["txtcarrera"];
      $numero = $_POST["txtnumero"];
      $nombre = $_POST["txtnombre"];
      $verificarNombre = $conexion->query("select count(*) as 'total' from modulo where numero='$numero' and nombre='$nombre' and carrera=$carrera and id_modulo!=$id");
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
            $modificar = $conexion->query(" update modulo set numero='$numero', nombre='$nombre', carrera=$carrera where id_modulo=$id ");
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
