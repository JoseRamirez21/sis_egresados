<?php
session_start();
if (empty($_SESSION['id']) or ($_SESSION['tipo'] == "egresado")) {
   header('location:menu_coordinador.php');
}

?>

<style>
   ul li:nth-child(4) .activos {
      background: rgb(0, 0, 0) !important;
   }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary pb-2">LISTA DE UNIDADES DIDÁCTICAS</h4>

   <a class="btn btn-primary btn-rounded mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i>
      &nbsp;Registrar</a>
   <?php
   include "../modelo/conexion.php";
   include "../controlador/unidad/controlador_registrar_unidad.php";
   include "../controlador/unidad/controlador_modificar_unidad.php";
   include "../controlador/unidad/controlador_eliminar_unidad.php";
   $sql = $conexion->query(" SELECT
   unidades.id_unidades,
   unidades.carrera,
   unidades.nombre,
   unidades.credito,
   carrera.nombre AS carreraNom,
   semestre.semestre,
   semestre.`año`,
   unidades.semestre as 'id_semestre'
   FROM
   unidades
   INNER JOIN carrera ON unidades.carrera = carrera.id_carrera
   INNER JOIN semestre ON unidades.semestre = semestre.id_semestre
   
    ");
   ?>
   <table class="table table-bordered table-hover w-100" id="example">
      <thead>
         <tr>
            <th scope="col">ID</th>
            <th scope="col">CARRERA</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">CREDITO</th>
            <th scope="col">SEMESTRE</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
         while ($datos = $sql->fetch_object()) { ?>
            <tr>
               <td><?= $datos->id_unidades ?></td>
               <td><?= $datos->carreraNom ?></td>
               <td><?= $datos->nombre ?></td>
               <td><?= $datos->credito ?></td>
               <td><?= $datos->semestre . " " . $datos->año ?></td>
               <td>
                  <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#btnmodificar<?= $datos->id_unidades ?>"><i class="fas fa-edit"></i></a>
                  <a href="unidades.php?idEliminar=<?= $datos->id_unidades ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
               </td>
            </tr>

            <!-- Modal MODIFICAR CARRERA-->
            <div class="modal fade" id="btnmodificar<?= $datos->id_unidades ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICAR CARRERA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id_unidades ?>">
                              </div>
                              <?php
                              $carreras2 = $conexion->query(" select * from carrera ");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <select name="txtcarrera" class="input input__select">
                                    <?php
                                    while ($datosCarrera = $carreras2->fetch_object()) { ?>
                                       <option <?= $datos->carrera == $datosCarrera->id_carrera ? 'selected' : '' ?> value="<?= $datosCarrera->id_carrera ?>"><?= $datosCarrera->nombre ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Nombre de la unidad" class="input input__text" name="txtnombre" value="<?= $datos->nombre ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Credito de la unidad" class="input input__text" name="txtcredito" value="<?= $datos->credito ?>">
                              </div>

                              <?php
                              $semestre2 = $conexion->query(" select * from semestre ");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <select name="txtsemestre" class="input input__select">
                                    <?php
                                    while ($datosSemestre = $semestre2->fetch_object()) { ?>
                                       <option <?= $datos->id_semestre == $datosSemestre->id_semestre ? 'selected' : '' ?> value="<?= $datosSemestre->id_semestre ?>"><?= $datosSemestre->semestre . " " . $datosSemestre->año ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>

                              <div class="text-right p-2">
                                 <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                                 <button type="submit" value="ok" name="btnmodificar" class="btn btn-primary btn-rounded">Modificar</button>
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
               <h5 class="modal-title w-100" id="exampleModalLabel">REGISTRAR UNIDADES DIDÁCTICAS</h5>
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
                        <input required type="text" placeholder="Nombre de la unidad" class="input input__text" name="txtnombre">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Credito de la unidad" class="input input__text" name="txtcredito">
                     </div>

                     <?php
                     $semestres = $conexion->query(" select * from semestre ");
                     ?>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <select name="txtsemestre" class="input input__select">
                           <option value="">Seleccionar semestre...</option>
                           <?php
                           while ($datosSemestre = $semestres->fetch_object()) { ?>
                              <option value="<?= $datosSemestre->id_semestre ?>"><?= $datosSemestre->semestre . " " . $datosSemestre->año ?></option>
                           <?php }
                           ?>
                        </select>
                     </div>

                     <div class="text-right p-2">
                        <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                        <button type="submit" value="ok" name="btnregistrar" class="btn btn-primary btn-rounded">Registrar</button>
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