<?php
if (!empty($_POST["btnmodificarCer"])) {
   if (!empty($_POST["txtid"]) and !empty($_POST["txtestudiante"]) and !empty($_POST["txtmodulo"])) {
      $id = $_POST["txtid"];
      $estudiante = $_POST["txtestudiante"];
      $modulo = $_POST["txtmodulo"];
      $anio = $_POST["txtanio"];


      $verificarNombre = $conexion->query(" select count(*) as 'total' from constancia where id_estudiante=$estudiante and id_modulo=$modulo and anio='$anio' and id_constancia!=$id");
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
            $modificar = $conexion->query(" update constancia set id_estudiante=$estudiante, id_modulo=$modulo, anio='$anio' where id_constancia=$id ");
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



/* --------------------------- MODIFICAR FOTO constancia ---------------------------------- */
if (!empty($_POST["btnmodificarFotoCer"])) {
   $id = $_POST["txtid"];
   try {
      $foto = addslashes(file_get_contents($_FILES['txtfoto']['tmp_name']));
   } catch (\Throwable $th) {
      $foto = "";
   }
   if ($foto == "") {
   ?>
      <script>
         $(function notificacion() {
            new PNotify({
               title: "INCORRECTO",
               type: "error",
               text: "Seleccione una imagen",
               styling: "bootstrap3"
            });
         });
      </script>
      <?php
   } else {
      try {
         $modificar = $conexion->query(" update constancia set imagen='$foto' where id_constancia=$id ");
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

            setTimeout(() => {
               location.href = "constancia.php";
            }, 1500);
         </script>
   <?php
      }
   }
   ?>


   <script>
      setTimeout(() => {
         window.history.replaceState(null, null, window.location.pathname);
      }, 0);
   </script>
   <?php
}


/* --------------------------- ELIMINAR FOTO ESTUDIANTE ---------------------------------- */
if (!empty($_POST["btneliminarFotoCer"])) {
   $id = $_POST["txtid"];
   try {
      $modificar = $conexion->query(" update constancia set imagen='' where id_constancia=$id ");
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
   ?>


   <script>
      setTimeout(() => {
         window.history.replaceState(null, null, window.location.pathname);
      }, 0);
   </script>
<?php
}
