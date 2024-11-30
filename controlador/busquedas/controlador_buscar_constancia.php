<?php
if (!empty($_GET["txtdni"]) and !empty($_GET["txtcarrera"]) and !empty($_GET["txtmodulo"])) {
   $dni = $_GET["txtdni"];
   $carrera = $_GET["txtcarrera"];
   $modulo = $_GET["txtmodulo"];
   $buscarEstudiante = $conexion->query(" select id from estudiante where dni='$dni' ");
   $id_estudiante = $buscarEstudiante->fetch_object()->id;
   if (!empty($id_estudiante)) {
      $buscarConstancia = $conexion->query(" select * from constancia where id_estudiante=$id_estudiante and id_modulo=$modulo limit 1 ");
      $id_constancia = $buscarConstancia->fetch_object()->id_constancia;
      if (!empty($id_constancia)) {
         header("location:./vista_constancia.php?id=$id_constancia");
      } else {
?>
         <script>
            $(function notificacion() {
               new PNotify({
                  title: "INCORRECTO",
                  type: "error",
                  text: "El estudiante no cuenta con este constancia",
                  styling: "bootstrap3"
               });
            });
         </script>
      <?php
      }
   } else {
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