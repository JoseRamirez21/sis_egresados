<?php
if (!empty($_GET["txtdni"])) {
   $dni = $_GET["txtdni"];
   $buscarEstudiante = $conexion->query(" SELECT id FROM estudiante WHERE dni='$dni' LIMIT 1 ");
   $id_estudiante = $buscarEstudiante->fetch_object()->id;
   if (!empty($id_estudiante)) {
      //header("location:./fpdf/pruebaV.php?id=$id_estudiante"); ?>
   <script>
      window.open("./vista/fpdf/Resultado_historial_index.php?id=<?= $id_estudiante ?>", "_blank")
   </script>
   <?php } else {
   ?>
      <script>
         $(function notificacion() {
            new PNotify({
               title: "INCORRECTO",
               type: "error",
               text: "El estudiante no existe",
               styling: "bootstrap3"
            });
         });
      </script>
<?php
   }
} ?>
<script>
   setTimeout(() => {
      window.history.replaceState(null, null, window.location.pathname);
   }, 0);
</script>