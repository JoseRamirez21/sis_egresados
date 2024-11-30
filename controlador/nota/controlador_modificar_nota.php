<?php
if (!empty($_POST["btnModificarNota"])) {
   if (!empty($_POST["txtidnota"]) and !empty($_POST["txtnota"])) {
      $idnota = $_POST["txtidnota"];
      $estudiante = $_POST["txtestudiante"];
      $nota = $_POST["txtnota"];
      $semestre = $_POST["txtsemestre"];
      $nota = $_POST["txtnota"];
      $puntaje = $_POST["txtpuntaje"];
      $observacion = $_POST["txtobservacion"];
      $carrera = $_POST["txtcarrera"];
      try {
         $registrar = $conexion->query(" update nota set nota=$nota,puntaje=$puntaje,observacion='$observacion' where id_nota=$idnota ");
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
         window.history.replaceState(null, null, window.location.pathname + "?txtcarrera=<?= $carrera ?>&txtsemestre=<?= $semestre ?>&txtestudiante=<?= $estudiante ?>&btnmodificar=ok");
      }, 0);
   </script>
<?php
}
