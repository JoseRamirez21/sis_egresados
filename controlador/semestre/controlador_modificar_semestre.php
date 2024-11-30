<?php
if (!empty($_POST["btnmodificar"])) {
   if (!empty($_POST["txtsemestre"]) and !empty($_POST["txtanio"])) {
      $semestre = $_POST["txtsemestre"];
      $anio = $_POST["txtanio"];
      $id = $_POST["txtid"];
      $verificarNombre = $conexion->query("select count(*) as 'total' from semestre where semestre='$semestre' and año='$anio' and id_semestre!=$id");
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
            $modificar = $conexion->query(" update semestre set semestre='$semestre', año='$anio' where id_semestre=$id ");
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
