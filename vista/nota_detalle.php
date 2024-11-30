<?php
session_start();
if (empty($_SESSION['id']) or ($_SESSION['tipo'] == "egresado")) {
   header('location:menu_coordinador.php');
}

?>

<style>
   ul li:nth-child(5) .activos {
      background: rgb(0, 0, 0) !important;
   }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

   <h4 class="text-center text-secondary pb-2">NOTAS DEL ESTUDIANTE</h4>


   <?php
   include "../modelo/conexion.php";
   include "../controlador/nota/controlador_registrar_nota.php";
   include "../controlador/nota/controlador_modificar_nota.php";
   $carrera = $_GET["txtcarrera"];
   $semestre = $_GET["txtsemestre"];
   $estudiante = $_GET["txtestudiante"];

   $sql2 = $conexion->query("select nombre from carrera where id_carrera=$carrera");
   $sql4 = $conexion->query("select id_semestre,semestre,año from semestre where id_semestre=$semestre");
   $sql6 = $conexion->query("select * from estudiante where id=$estudiante");
   $sql = $conexion->query("select * from unidades where carrera=$carrera and semestre=$semestre ");
   $sql3 = $conexion->query(" SELECT
   nota.id_nota,nota.estudiante,nota.unidad,nota.puntaje,nota.observacion,nota.semestre,nota.nota,estudiante.dni,estudiante.nombre,estudiante.apellido_paterno,
   estudiante.apellido_materno,semestre.semestre AS nom_semestre,semestre.`año`,unidades.nombre AS nomUnidad,unidades.carrera,unidades.credito
   FROM nota INNER JOIN estudiante ON nota.estudiante = estudiante.id
   INNER JOIN semestre ON nota.semestre = semestre.id_semestre
   INNER JOIN unidades ON nota.unidad = unidades.id_unidades
   WHERE unidades.carrera=$carrera and unidades.semestre=$semestre and nota.semestre=$semestre and nota.estudiante=$estudiante ");

   $sinNota = $conexion->query(" SELECT
   unidades.nombre,
   unidades.id_unidades,
   unidades.credito
   FROM
   unidades
   WHERE carrera=$carrera
   and unidades.semestre=$semestre
   and id_unidades not in(SELECT nota.unidad from nota where nota.estudiante=$estudiante and nota.semestre=$semestre) ");



   $datosEstudiante = $sql6->fetch_object();
   $datosSemestre = $sql4->fetch_object();
   $datosCarrera = $sql2->fetch_object();
   ?>


   <table class="table table-bordered table-hover w-100">
      <tbody>
         <tr>
            <th class="bg-light">ESTUDIANTE</th>
            <td><?= $datosEstudiante->nombre . " " .  $datosEstudiante->apellido_paterno . " " . $datosEstudiante->apellido_materno ?></td>
            <th class="bg-light">SEMESTRE</th>
            <td><?= $datosSemestre->semestre ?></td>
         </tr>
         <tr>
            <th class="bg-light">CARRERA</th>
            <td><?= $datosCarrera->nombre ?></td>
            <th class="bg-light">AÑO</th>
            <td><?= $datosSemestre->año ?></td>
         </tr>

      </tbody>
   </table>
   <br>

   <table class="table table-bordered table-hover w-100">
      <thead>
         <tr>
            <th scope="col">UNIDAD DIDÁCT</th>
            <th scope="col">CREDITO</th>
            <th scope="col">NOTA</th>
            <th scope="col">PUNTAJE</th>
            <th scope="col">OBSERVACIÓN</th>
         </tr>
      </thead>
      <tbody id="datos">
         <?php
         while ($datosNota = $sql3->fetch_object()) { ?>

            <tr>
               <td style="width: 500px;"><?= $datosNota->nomUnidad ?></td>
               <td style="width: 100px"><?= $datosNota->credito ?></td>

               <th style="width: 100px"><?= $datosNota->nota ?></th>
               <td style="width: 100px"><?= $datosNota->puntaje ?></td>
               <td><?= $datosNota->observacion ?></td>
               <td style="width: 100px;"><a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modinota<?= $datosNota->id_nota ?>" href=""><i class="fas fa-edit"></i></a></td>

               <!-- Modal modificar nota-->
               <div class="modal fade" id="modinota<?= $datosNota->id_nota ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICA LAS NOTAS AQUI</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form method="POST" action="">
                              <div hidden>
                                 <label class="text-primary font-weight-bold px-2">ID NOTA</label>
                                 <input type="number" class="input input__text mb-4" name="txtidnota" value="<?= $datosNota->id_nota ?>">
                                 <label class="text-primary font-weight-bold px-2">ID ESTUDIANTE</label>
                                 <input type="number" class="input input__text mb-3" name="txtestudiante" value="<?= $estudiante ?>">
                                 <label class="text-primary font-weight-bold px-2">ID SEMESTRE</label>
                                 <input type="number" class="input input__text mb-3" name="txtsemestre" value="<?= $semestre ?>">
                                 <label class="text-primary font-weight-bold px-2">CARRERA</label>
                                 <input type="number" class="input input__text mb-3" name="txtcarrera" value="<?= $_GET["txtcarrera"] ?>">
                              </div>

                              <label class="text-primary font-weight-bold px-2">NOTA</label>
                              <input required type="number" class="input input__text mb-4" placeholder="Nota" name="txtnota" value="<?= $datosNota->nota ?>">
                              <label class="text-primary font-weight-bold px-2">PUNTAJE</label>
                              <input required type="number" class="input input__text mb-4" placeholder="Puntaje" name="txtpuntaje" value="<?= $datosNota->puntaje ?>">
                              <label class="text-primary font-weight-bold px-2">OBSERVACION</label>
                              <input required type="text" class="input input__text mb-4" placeholder="Observación" name="txtobservacion" value="<?= $datosNota->observacion ?>">
                              <div class="text-right">
                                 <button type="submit" name="btnModificarNota" value="ok" class="btn btn-primary">Modificar Nota</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </tr>
         <?php }
         ?>

      </tbody>
   </table>

   <br><br>

   <table class="table table-bordered table-hover w-100">
      <thead>
         <tr>
            <th scope="col">UNIDAD DIDÁCT</th>
            <th scope="col">CREDITO</th>
            <th scope="col">NOTA</th>
            <th scope="col">PUNTAJE</th>
            <th scope="col">OBSERVACIÓN</th>
            <th scope="col"></th>
         </tr>
      </thead>
      <tbody id="datos">
         <?php
         while ($datosSinNota = $sinNota->fetch_object()) { ?>

            <tr>
               <td style="width: 500px;"><?= $datosSinNota->nombre ?></td>
               <td style="width: 100px"><?= $datosSinNota->credito ?></td>

               <th style="width: 100px"></th>
               <td style="width: 100px"></td>
               <td></td>
               <td style="width: 100px;"><a class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal<?= $datosSinNota->id_unidades ?>" href=""><i class="fas fa-plus"></i></a></td>

               <!-- Modal registrar nota-->
               <div class="modal fade" id="exampleModal<?= $datosSinNota->id_unidades ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title w-100" id="exampleModalLabel">REGISTRA LAS NOTAS AQUI</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form method="POST" action="">
                              <div class="alert alert-info alert-dismissible">
                                 OJO: si la nota ya existe, Ya no es necesario registrar otra, Solo modifícalo
                                 <button type="button" class="btn-close" style="margin-top: -8px!important" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                              <div hidden>
                                 <label class="text-primary font-weight-bold px-2">ID ESTUDIANTE</label>
                                 <input type="number" class="input input__text mb-3" name="txtestudiante" value="<?= $estudiante ?>">
                                 <label class="text-primary font-weight-bold px-2">ID UNIDAD</label>
                                 <input required type="number" class="input input__text mb-3" name="txtunidad" value="<?= $datosSinNota->id_unidades ?>">
                                 <label class="text-primary font-weight-bold px-2">ID SEMESTRE</label>
                                 <input type="number" class="input input__text mb-3" name="txtsemestre" value="<?= $semestre ?>">
                                 <label class="text-primary font-weight-bold px-2">CARRERA</label>
                                 <input type="number" class="input input__text mb-3" name="txtcarrera" value="<?= $_GET["txtcarrera"] ?>">
                              </div>

                              <label class="text-primary font-weight-bold px-2">NOTA</label>
                              <input required type="number" class="input input__text mb-3" placeholder="Nota" name="txtnota">
                              <label class="text-primary font-weight-bold px-2">PUNTAJE</label>
                              <input required type="number" class="input input__text mb-3" placeholder="Puntaje" name="txtpuntaje">
                              <label class="text-primary font-weight-bold px-2">OBSERVACION</label>
                              <input required type="text" class="input input__text mb-3" placeholder="Observación" name="txtobservacion">
                              <div class="text-right">
                                 <button type="submit" name="btnRegistrarNota" value="ok" class="btn btn-primary">Agregar Nota</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </tr>
         <?php }
         ?>

      </tbody>
   </table>


</div>
</div>
<!-- fin del contenido principal -->
<script type="text/javascript">
   $('#val').change(function() {
      recargarLista();
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

<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>