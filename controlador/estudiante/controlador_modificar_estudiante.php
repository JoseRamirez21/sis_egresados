<?php
if (!empty($_POST["btnmodificarE"])) {
   if (!empty($_POST["txtcarrera"]) and !empty($_POST["txtdni"]) and !empty($_POST["txtnombre"]) and !empty($_POST["txtapepat"]) and !empty($_POST["txtapemat"]) and !empty($_POST["txtusuario"])) {
      $id = $_POST["txtid"];
      $carrera = $_POST["txtcarrera"];
      $dni = $_POST["txtdni"];
      $nombre = $_POST["txtnombre"];
      $apepat = $_POST["txtapepat"];
      $apemat = $_POST["txtapemat"];
      $fechainicio = $_POST["txtfechainicio"];
      $fechafinal = $_POST["txtfechafinal"];
      $titulo = $_POST["txttitulo"];
      $trabajo = $_POST["txttrabajo"];
      $ruc = $_POST["txtruc"];
      $ubicacion = $_POST["txtubicacion"];
      $telefono = $_POST["txttelefono"];
      $usuario = $_POST["txtusuario"];
      $estado = $_POST["txtestado"];
      $correo = $_POST["txtcorreo"];

      $verificarNombre = $conexion->query(" select count(*) as 'total' from estudiante where dni='$dni' and carrera=$carrera and usuario='$usuario' and id!=$id");
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
            $modificar = $conexion->query(" update estudiante set dni='$dni', nombre='$nombre',apellido_paterno='$apepat',apellido_materno='$apemat',carrera=$carrera,
            fecha_inicio='$fechainicio',fecha_final='$fechafinal',titulo='$titulo',trabajo_actual='$trabajo',ruc='$ruc',ubicacion='$ubicacion',telefono='$telefono',
            usuario='$usuario', estado='$estado', correo='$correo' where id=$id ");
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



/* --------------------------- MODIFICAR CONTRASEÑA ---------------------------------- */
if (!empty($_POST["btnCambiarClave"])) {
   if (!empty($_POST["txtclave"])) {
      $id = $_POST["txtid"];
      $clave = md5($_POST["txtclave"]);
      try {
         $modificar = $conexion->query(" update estudiante set clave='$clave' where id=$id ");
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



/* --------------------------- MODIFICAR FOTO ESTUDIANTE ---------------------------------- */
if (!empty($_POST["btnmodificarFotoE"])) {
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
         $modificar = $conexion->query(" update estudiante set foto='$foto' where id=$id ");
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
               location.href = "estudiante.php";
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
if (!empty($_POST["btneliminarFotoE"])) {
   $id = $_POST["txtid"];
   try {
      $modificar = $conexion->query(" update estudiante set foto='' where id=$id ");
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
