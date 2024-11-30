<?php
error_reporting(0);
session_start();
if (empty($_SESSION['id']) or ($_SESSION['tipo'] == "egresado")) {
   header('location:menu_coordinador.php');
}

?>

<style>
   ul li:nth-child(7) .activos {
      background: rgb(0, 0, 0) !important;
   }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary pb-2">LISTA DE ADMINISTRATIVOS REGISTRADOS</h4>

   <a class="btn btn-primary btn-rounded mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i>
      &nbsp;Registrar</a>
   <?php


   ?>
   <table class="table table-bordered table-hover w-100" id="example">
      <thead>
         <tr>
            <th scope="col">ID</th>
            <th scope="col">DNI</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">APE-PAT</th>
            <th scope="col">APE-MAT</th>
            <th scope="col">CORREO</th>
            <th scope="col">USUARIO</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
         include "../modelo/conexion.php";
         include "../controlador/administrador/controlador_registrar_administrador.php";
         include "../controlador/administrador/controlador_modificar_administrador.php";
         include "../controlador/administrador/controlador_eliminar_administrador.php";
         $sql2 = $conexion->query(" SELECT * from usuario  
          ");
         while ($datos = $sql2->fetch_object()) { ?>
            <tr>
               <td><?= $datos->id_usuario ?></td>
               <td><?= $datos->dni ?></td>
               <td><?= $datos->nombre ?></td>
               <td><?= $datos->ape_paterno ?></td>
               <td><?= $datos->ape_materno ?></td>
               <td><?= $datos->correo ?></td>
               <td><?= $datos->usuario ?></td>
               <td>
                  <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#btncambiarClave<?= $datos->id_usuario ?>"><i class="fas fa-eye"></i></a>
                  <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#btnmodificar<?= $datos->id_usuario ?>"><i class="fas fa-edit"></i></a>
                  <a href="administrador.php?idEliminarA=<?= $datos->id_usuario ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
               </td>
            </tr>

            <!-- Modal MODIFICAR ADMINISTRADOR-->
            <div class="modal fade" id="btnmodificar<?= $datos->id_usuario ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICAR ADMINISTRADOR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id_usuario ?>">
                              </div>

                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="DNI del administrador" class="input input__text" name="txtdni" value="<?= $datos->dni ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Nombre del administrador" class="input input__text" name="txtnombre" value="<?= $datos->nombre ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Apellido paterno" class="input input__text" name="txtapepat" value="<?= $datos->ape_paterno ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Apellido materno" class="input input__text" name="txtapemat" value="<?= $datos->ape_materno ?>">
                              </div>

                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Correo" class="input input__text" name="txtcorreo" value="<?= $datos->correo ?>">
                              </div>

                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Nombre de usuario" class="input input__text" name="txtusuario" value="<?= $datos->usuario ?>">
                              </div>

                              <div class="text-right p-2">
                                 <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                                 <button type="submit" value="ok" name="btnmodificarA" class="btn btn-primary btn-rounded">Modificar</button>
                              </div>
                           </div>
                        </form>
                     </div>

                  </div>
               </div>
            </div>

            <!-- Modal CAMBIAR CONTRASEÑA -->
            <div class="modal fade" id="btncambiarClave<?= $datos->id_usuario ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">CAMBIAR CONTRASEÑA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id_usuario ?>">
                              </div>

                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="password" class="input input__text" name="txtclave" placeholder="Ingresa la nueva contraseña">
                              </div>
                              <div class="text-right p-2">
                                 <button type="submit" value="ok" name="btnCambiarClaveA" class="btn btn-primary btn-rounded">Modificar Contraseña</button>
                              </div>
                           </div>
                        </form>
                     </div>

                  </div>
               </div>
            </div>
         <?php }
         ?>

      </tbody>
   </table>



   <!-- Modal REGISTRAR CARRERA-->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title w-100" id="exampleModalLabel">REGISTRAR ADMINISTRADOR</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form method="post" class="px-3" enctype="multipart/form-data">
                  <div class="row">
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="DNI del administrador" class="input input__text" name="txtdni">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Nombre del administrador" class="input input__text" name="txtnombre">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Apellido paterno" class="input input__text" name="txtapepat">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Apellido materno" class="input input__text" name="txtapemat">
                     </div>

                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Correo" class="input input__text" name="txtcorreo">
                     </div>

                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Nombre de usuario" class="input input__text" name="txtusuario">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="password" placeholder="Contraseña" class="input input__text" name="txtclave">
                     </div>

                     <div class="text-right p-2">
                        <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                        <button type="submit" value="ok" name="btnregistrarA" class="btn btn-primary btn-rounded">Registrar</button>
                     </div>
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>

</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>