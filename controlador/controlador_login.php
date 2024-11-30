<?php
session_start();
if (!empty($_POST['btningresar'])) {
   if (!empty($_POST['txtusuario']) and !empty($_POST['txtpassword']) and !empty($_POST['txttipo'])) {
      $usuario = $_POST['txtusuario'];
      $clave = md5($_POST['txtpassword']);
      $tipo = $_POST['txttipo'];
      if ($tipo == "administrador") {
         $consulta = $conexion->query(" select * from usuario where usuario='$usuario' "
            . "and clave='$clave' ");
      } else {
         if ($tipo == "egresado") {
            $consulta = $conexion->query(" select * from estudiante where usuario='$usuario' "
               . "and clave='$clave' ");
         }
      }

      if ($datos = $consulta->fetch_object()) {
         $_SESSION['user'] = $datos->usuario;
         if ($tipo == "administrador") {
            $_SESSION['id'] = $datos->id_usuario;
         } else {
            if ($tipo == "egresado") {
               $_SESSION['id'] = $datos->id;
            }
         }
         $_SESSION['nombre'] = $datos->nombre;
         $_SESSION['ape_paterno'] = $datos->ape_paterno;
         $_SESSION['ape_materno'] = $datos->ape_materno;
         $_SESSION['tipo'] = $tipo;

         header('location:../menu_coordinador.php');
      } else {
         echo '<div style="padding:15px;color:red">Usuario o contraseña incorrecta</div>';
      }
   } else {
      echo '<div style="padding:15px;color:red">Campos vacíos</div>';
   }
}
