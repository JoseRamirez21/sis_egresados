<?php
if (!empty($_POST["btnregistrarCer"])) {
   if (!empty($_POST["txtestudiante"]) and !empty($_POST["txtmodulo"])) {
      $estudiante = $_POST["txtestudiante"];
      $modulo = $_POST["txtmodulo"];
      $anio = $_POST["txtanio"];
      $imagen = addslashes(file_get_contents($_FILES['txtimagen']['tmp_name']));

      $verificarNombre = $conexion->query(" select count(*) as 'total' from certificado where id_estudiante=$estudiante and id_modulo=$modulo and anio='$anio' ");
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
            $registrar = $conexion->query(" insert into certificado(id_estudiante,id_modulo,anio,imagen) values($estudiante,$modulo,'$anio','$imagen') ");
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
