<?php
if (!empty($_GET["idEliminarA"])) {
   $id = $_GET["idEliminarA"];
   try {
      $eliminar = $conexion->query(" delete from usuario where id_usuario=$id ");
   } catch (\Throwable $th) {
      $eliminar = 0;
   }
   if ($eliminar == true) {
?>
      <script>
         $(function notificacion() {
            new PNotify({
               title: "CORRECTO",
               type: "success",
               text: "Se ha eliminado correctamente",
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
               text: "Error al eliminar",
               styling: "bootstrap3"
            });
         });
      </script>
   <?php
   } ?>
   <script>
      setTimeout(() => {
         window.history.replaceState(null, null, window.location.pathname);
      }, 0);
   </script>
<?php } ?>