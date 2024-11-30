<?php
error_reporting(0);
session_start();
if (empty($_SESSION['id']) or ($_SESSION['tipo'] == "egresado")) {
   header('location:menu_coordinador.php');
}

?>

<style>
   ul li:nth-child(8) .activos {
      background: rgb(0, 0, 0) !important;
   }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary pb-2">LISTA DE CERTIFICADOS REGISTRADAS</h4>

   <a class="btn btn-primary btn-rounded mb-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i>
      &nbsp;Registrar</a>
   <?php
   include "../modelo/conexion.php";
   include "../controlador/certificado/controlador_registrar_certificado.php";
   include "../controlador/certificado/controlador_modificar_certificado.php";
   include "../controlador/certificado/controlador_eliminar_certificado.php";
   $sql = $conexion->query(" SELECT
   certificado.id_certificado,
   certificado.id_estudiante,
   certificado.id_modulo,
   certificado.anio,
   certificado.imagen,
   estudiante.dni,
   estudiante.nombre,
   estudiante.apellido_paterno,
   estudiante.apellido_materno,
   carrera.id_carrera,
   modulo.nombre as 'nomMod',
   modulo.numero as 'numMod'
   FROM
   certificado
   INNER JOIN estudiante ON certificado.id_estudiante = estudiante.id
   INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera
   INNER JOIN modulo ON modulo.carrera = carrera.id_carrera AND certificado.id_modulo = modulo.id_modulo
   
    ");
   ?>
   <table class="table table-bordered table-hover w-100" id="example">
      <thead>
         <tr>
            <th scope="col">ID</th>
            <th scope="col">DNI</th>
            <th scope="col">ESTUDIANTE</th>
            <th scope="col">MODULO</th>
            <th scope="col">AÑO</th>
            <th scope="col">IMAGEN</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
         while ($datos = $sql->fetch_object()) { ?>
            <tr>
               <td>
                  <?= $datos->id_certificado ?>
               </td>
               <td>
                  <?= $datos->dni ?>
               </td>
               <td>
                  <?= $datos->nombre . " " . $datos->apellido_paterno . " " . $datos->apellido_materno ?>
               </td>
               <td>
                  <?= $datos->numMod . " " . $datos->nomMod ?>
               </td>
               <td>
                  <?= $datos->anio ?>
               </td>
               <td>
                  <img data-toggle="modal" data-target="#btnmodificarFoto<?= $datos->id_certificado ?>" style="width: 100px" src="data:image/jpg;base64,<?= base64_encode($datos->imagen) ?>" />
               </td>
               <td>
                  <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#btnmodificar<?= $datos->id_certificado ?>"><i class="fas fa-edit"></i></a>
                  <a href="certificado.php?idEliminarCer=<?= $datos->id_certificado ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
               </td>
            </tr>

            <!-- Modal MODIFICAR CERTIFICADO-->
            <div class="modal fade" id="btnmodificar<?= $datos->id_certificado ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICAR CERTIFICADO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input required class="input input__text" name="txtid" value="<?= $datos->id_certificado ?>">
                              </div>
                              <?php
                              $carrera = $conexion->query(" select * from carrera");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <label for="">Carrera</label>
                                 <select name="txtcarrera" class="input input__select" id="val">
                                    <option value="">Seleccionar carrera...</option>
                                    <?php
                                    while ($datosCarrera = $carrera->fetch_object()) { ?>
                                       <option <?= $datosCarrera->id_carrera == $datos->id_carrera ? 'selected' : '' ?> value="<?= $datosCarrera->id_carrera ?>"><?= $datosCarrera->nombre ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>

                              <?php
                              $estudiante = $conexion->query(" select * from estudiante");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <label for="">Estudiante</label>
                                 <select required name="txtestudiante" class="input input__select" id="listaEstudiantes">
                                    <option value="">No existen estudiantes</option>
                                    <?php
                                    while ($datosEstudiante = $estudiante->fetch_object()) { ?>
                                       <option <?= $datosEstudiante->id == $datos->id_estudiante ? 'selected' : '' ?> value="<?= $datosEstudiante->id ?>"><?= $datosEstudiante->nombre . " " . $datosEstudiante->apellido_paterno . " " . $datosEstudiante->apellido_materno ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>

                              <?php
                              $modulo = $conexion->query(" select * from modulo");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <label for="">Modulo</label>
                                 <select required name="txtmodulo" class="input input__select" id="listaModulo">
                                    <option value="">No existen modulos</option>
                                    <?php
                                    while ($datosModulo = $modulo->fetch_object()) { ?>
                                       <option <?= $datosModulo->id_modulo == $datos->id_modulo ? 'selected' : '' ?> value="<?= $datosModulo->id_modulo ?>"><?= $datosModulo->numero . " " . $datosModulo->nombre ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>

                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Año" class="input input__text" name="txtanio" value="<?= $datos->anio ?>">
                              </div>

                              <div class="text-right p-2">
                                 <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                                 <button type="submit" value="ok" name="btnmodificarCer" class="btn btn-primary btn-rounded">Modificar</button>
                              </div>
                           </div>
                        </form>
                     </div>

                  </div>
               </div>
            </div>

            <!-- Modal MODIFICAR FOTO-->
            <div class="modal fade" id="btnmodificarFoto<?= $datos->id_certificado ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICAR FOTO</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3" enctype="multipart/form-data">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id_certificado ?>">
                              </div>
                              <div class="m-auto text-center">
                                 <img width="300px" src="data:image/jpg;base64,<?= base64_encode($datos->imagen) ?>" />
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="file" class="input input__text" name="txtfoto">
                              </div>
                              <div class="text-right p-2">
                                 <button type="submit" value="ok" name="btneliminarFotoCer" class="btn btn-danger btn-rounded">Eliminar Foto</button>
                                 <button type="submit" value="ok" name="btnmodificarFotoCer" class="btn btn-primary btn-rounded">Modificar Foto</button>
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



   <!-- Modal REGISTRAR CERTIFICADO-->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title w-100" id="exampleModalLabel">REGISTRAR CERTIFICADO</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="" method="POST" class="px-3" enctype="multipart/form-data">
                  <div class="row">
                     <?php
                     $carrera2 = $conexion->query(" select * from carrera");
                     ?>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <label for="">Carrera</label>
                        <select name="txtcarrera" class="input input__select" id="val2">
                           <option value="">Seleccionar carrera...</option>
                           <?php
                           while ($datosCarrera2 = $carrera2->fetch_object()) { ?>
                              <option value="<?= $datosCarrera2->id_carrera ?>"><?= $datosCarrera2->nombre ?></option>
                           <?php }
                           ?>
                        </select>
                     </div>

                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <label for="">Estudiante</label>
                        <select required name="txtestudiante" class="input input__select" id="listaEstudiantes2">
                           <option value="">No existen estudiantes</option>
                        </select>
                     </div>

                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <label for="">Modulo</label>
                        <select required name="txtmodulo" class="input input__select" id="listaModulo2">
                           <option value="">No existen modulos</option>
                        </select>
                     </div>

                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Año" class="input input__text" name="txtanio">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <label for="">Imagen del certificado</label>
                        <input required type="file" class="input input__text" name="txtimagen">
                     </div>

                     <div class="text-right p-2">
                        <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                        <button type="submit" value="ok" name="btnregistrarCer" class="btn btn-primary btn-rounded">Registrar</button>
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
<!-- fin del contenido principal -->
<script type="text/javascript">
   $('#val').change(function() {
      recargarLista();
      recargarListaMod();
   });
   $('#val2').change(function() {
      recargarLista2();
      recargarListaMod2();
   });
</script>
<script type="text/javascript">
   function recargarLista() {
      $.ajax({
         type: "POST",
         url: "ajax/listaEstudiantes.php",
         data: "cod=" + $('#val').val(),
         success: function(q) {
            $('#listaEstudiantes').html(q);
         }
      });
   }
</script>

<script type="text/javascript">
   function recargarListaMod() {
      $.ajax({
         type: "POST",
         url: "ajax/listaModulo.php",
         data: "cod=" + $('#val').val(),
         success: function(q) {
            $('#listaModulo').html(q);
         }
      });
   }
</script>


<script type="text/javascript">
   function recargarLista2() {
      $.ajax({
         type: "POST",
         url: "ajax/listaEstudiantes2.php",
         data: "cod2=" + $('#val2').val(),
         success: function(q) {
            $('#listaEstudiantes2').html(q);
         }
      });
   }
</script>

<script type="text/javascript">
   function recargarListaMod2() {
      $.ajax({
         type: "POST",
         url: "ajax/listaModulo2.php",
         data: "cod2=" + $('#val2').val(),
         success: function(q) {
            $('#listaModulo2').html(q);
         }
      });
   }
</script>

<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>