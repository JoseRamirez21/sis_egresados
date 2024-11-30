<?php
if (!empty($_POST["btnregistrar"])) {
   if (!empty($_POST["txtnombre"]) and !empty($_POST["txtcarrera"]) and !empty($_POST["txtcredito"])) {
      $nombre = $_POST["txtnombre"];
      $carrera = $_POST["txtcarrera"];
      $credito = $_POST["txtcredito"];
      $semestre = $_POST["txtsemestre"];
      $verificarNombre = $conexion->query(" select count(*) as 'total' from unidades where carrera=$carrera and nombre='$nombre' and credito='$credito' ");
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
            $registrar = $conexion->query(" insert into unidades(carrera,nombre,credito,semestre) values($carrera,'$nombre','$credito',$semestre) ");
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
