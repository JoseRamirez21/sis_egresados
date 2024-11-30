<?php
if (!empty($_POST["btnregistrarMod"])) {
   if (!empty($_POST["txtcarrera"]) and !empty($_POST["txtnumero"]) and !empty($_POST["txtnombre"])) {
      $carrera = $_POST["txtcarrera"];
      $numero = $_POST["txtnumero"];
      $nombre = $_POST["txtnombre"];
      $verificarNombre = $conexion->query(" select count(*) as 'total' from modulo where numero='$numero' and nombre='$nombre' and carrera=$carrera ");
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
            $registrar = $conexion->query(" insert into modulo(numero,nombre,carrera) values('$numero','$nombre',$carrera) ");
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
