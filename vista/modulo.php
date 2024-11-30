<?php
session_start();
if (empty($_SESSION['id']) or ($_SESSION['tipo'] == "egresado")) {
   header('location:menu_coordinador.php');
}

?>

<style>
   ul li:nth-child(2) .activos {
      background: rgb(0, 0, 0) !important;
   }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary pb-2">LISTA DE MÓDULOS REGISTRADOS</h4>

   <a class="btn btn-primary btn-rounded mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i>
      &nbsp;Registrar</a>
   <?php
   include "../modelo/conexion.php";
   include "../controlador/modulo/controlador_registrar_modulo.php";
   include "../controlador/modulo/controlador_modificar_modulo.php";
   include "../controlador/modulo/controlador_eliminar_modulo.php";
   $sql = $conexion->query(" SELECT
   modulo.id_modulo,
   modulo.numero,
   modulo.nombre,
   modulo.carrera,
   carrera.nombre as 'nomCarrera'
   FROM
   modulo
   INNER JOIN carrera ON modulo.carrera = carrera.id_carrera
    ");
   ?>
   <table class="table table-bordered table-hover w-100" id="example">
      <thead>
         <tr>
            <th scope="col">ID</th>
            <th scope="col">CARRERA</th>
            <th scope="col">NUMERO</th>
            <th scope="col">NOMBRE MOD</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
         while ($datos = $sql->fetch_object()) { ?>
            <tr>
               <td>
                  <?= $datos->id_modulo ?>
               </td>
               <td>
                  <?= $datos->nomCarrera ?>
               </td>
               <td>
                  <?= $datos->numero ?>
               </td>
               <td>
                  <?= $datos->nombre ?>
               </td>
               <td>
                  <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#btnmodificar<?= $datos->id_modulo ?>"><i class="fas fa-edit"></i></a>
                  <a href="modulo.php?idEliminarMod=<?= $datos->id_modulo ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
               </td>
            </tr>

            <!-- Modal MODIFICAR CARRERA-->
            <div class="modal fade" id="btnmodificar<?= $datos->id_modulo ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICAR SEMESTRE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input required class="input input__text" name="txtid" value="<?= $datos->id_modulo ?>">
                              </div>
                              <?php
                              $carreras = $conexion->query(" select * from carrera ");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <select name="txtcarrera" class="input input__select">
                                    <option value="">Seleccionar carrera...</option>
                                    <?php
                                    while ($datosCarrera = $carreras->fetch_object()) { ?>
                                       <option <?= $datosCarrera->id_carrera == $datos->carrera ? 'selected' : '' ?> value="<?= $datosCarrera->id_carrera ?>"><?= $datosCarrera->nombre ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Numero" class="input input__text" name="txtnumero" value="<?= $datos->numero ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Nombre modulo" class="input input__text" name="txtnombre" value="<?= $datos->nombre ?>">
                              </div>
                              <div class="text-right p-2">
                                 <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                                 <button type="submit" value="ok" name="btnmodificarM" class="btn btn-primary btn-rounded">Modificar</button>
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
               <h5 class="modal-title w-100" id="exampleModalLabel">REGISTRAR MODULO</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="" method="POST" class="px-3">
                  <div class="row">
                     <?php
                     $carreras = $conexion->query(" select * from carrera ");
                     ?>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <select name="txtcarrera" class="input input__select">
                           <option value="">Seleccionar carrera...</option>
                           <?php
                           while ($datosCarrera = $carreras->fetch_object()) { ?>
                              <option value="<?= $datosCarrera->id_carrera ?>"><?= $datosCarrera->nombre ?></option>
                           <?php }
                           ?>
                        </select>
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Numero" class="input input__text" name="txtnumero">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Nombre modulo" class="input input__text" name="txtnombre">
                     </div>
                     <div class="text-right p-2">
                        <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                        <button type="submit" value="ok" name="btnregistrarMod" class="btn btn-primary btn-rounded">Registrar</button>
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