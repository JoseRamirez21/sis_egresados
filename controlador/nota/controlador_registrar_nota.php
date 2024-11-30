<?php
if (!empty($_POST["btnRegistrarNota"])) {
   if (!empty($_POST["txtestudiante"]) and !empty($_POST["txtunidad"]) and !empty($_POST["txtsemestre"])) {
      $estudiante = $_POST["txtestudiante"];
      $unidad = $_POST["txtunidad"];
      $semestre = $_POST["txtsemestre"];
      $nota = $_POST["txtnota"];
      $puntaje = $_POST["txtpuntaje"];
      $observacion = $_POST["txtobservacion"];
      $carrera=$_POST["txtcarrera"];
      try {
         $registrar = $conexion->query(" insert into nota(estudiante,unidad,semestre,nota,puntaje,observacion) values($estudiante,$unidad,$semestre,$nota,$puntaje,'$observacion') ");
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
                  text: "Se ha registrado correctamente",
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
         window.history.replaceState(null, null, window.location.pathname+"?txtcarrera=<?= $carrera ?>&txtsemestre=<?= $semestre ?>&txtestudiante=<?= $estudiante ?>&btnmodificar=ok");
      }, 0);
   </script>
<?php
}
