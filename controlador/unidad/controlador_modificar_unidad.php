<?php
if (!empty($_POST["btnmodificar"])) {
   if (!empty($_POST["txtnombre"]) and !empty($_POST["txtcarrera"]) and !empty($_POST["txtcredito"])) {
      $nombre = $_POST["txtnombre"];
      $carrera = $_POST["txtcarrera"];
      $credito = $_POST["txtcredito"];
      $semestre = $_POST["txtsemestre"];
      $id = $_POST["txtid"];
      $verificarNombre = $conexion->query(" select count(*) as 'total' from unidades where carrera=$carrera and nombre='$nombre' and credito='$credito' and id_unidades!=$id");
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
            $modificar = $conexion->query(" update unidades set carrera=$carrera, nombre='$nombre', credito='$credito', semestre=$semestre where id_unidades=$id ");
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
