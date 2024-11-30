<?php
if (!empty($_POST["btnregistrarE"])) {
   if (!empty($_POST["txtcarrera"]) and !empty($_POST["txtdni"]) and !empty($_POST["txtnombre"]) and !empty($_POST["txtapepat"]) and !empty($_POST["txtapemat"]) and !empty($_POST["txtusuario"]) and !empty($_POST["txtclave"])) {
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
      $clave = md5($_POST["txtclave"]);
      try {
         $foto = addslashes(file_get_contents($_FILES['txtfoto']['tmp_name']));
      } catch (\Throwable $th) {
         $foto = "";
      }

      $verificarNombre = $conexion->query(" select count(*) as 'total' from estudiante where dni='$dni' and carrera=$carrera and usuario='$usuario' ");
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
            $registrar = $conexion->query(" insert into estudiante(dni,nombre,apellido_paterno,apellido_materno,carrera,fecha_inicio,fecha_final,titulo,trabajo_actual,ruc,ubicacion,telefono,usuario,clave,foto,estado,correo) 
            values('$dni','$nombre','$apepat','$apemat',$carrera,'$fechainicio','$fechafinal','$titulo','$trabajo','$ruc','$ubicacion','$telefono','$usuario','$clave','$foto','$estado','$correo') ");
         } catch (\Throwable $th) {
            $registrar = false;
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
