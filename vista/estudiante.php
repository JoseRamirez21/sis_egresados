<?php
error_reporting(0);
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

   <h4 class="text-center text-secondary pb-2">LISTA DE ESTUDIANTES REGISTRADOS</h4>

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
            <th scope="col">CARRERA</th>
            <th scope="col">FECHA-INI</th>
            <th scope="col">FECHA-FIN</th>
            <th scope="col">TITULO</th>
            <th scope="col">TRABAJO</th>
            <th scope="col">RUC</th>
            <th scope="col">UBICACION</th>
            <th scope="col">TELEF</th>
            <th scope="col">ESTADO</th>
            <th scope="col">CORREO</th>
            <th scope="col">USUARIO</th>
            <th scope="col">FOTO</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
         include "../modelo/conexion.php";
         include "../controlador/estudiante/controlador_registrar_estudiante.php";
         include "../controlador/estudiante/controlador_modificar_estudiante.php";
         include "../controlador/estudiante/controlador_eliminar_estudiante.php";
         $sql2 = $conexion->query(" SELECT estudiante.id,estudiante.dni,estudiante.carrera,carrera.id_carrera,carrera.nombre AS 'nomCarrera',
         estudiante.nombre,estudiante.apellido_paterno,estudiante.apellido_materno,estudiante.fecha_inicio,estudiante.fecha_final,
         estudiante.titulo,estudiante.trabajo_actual,estudiante.ruc,estudiante.ubicacion,estudiante.telefono,estudiante.foto,estudiante.usuario,
         estudiante.clave,estado,carrera,correo FROM estudiante INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera   
          ");
         while ($datos = $sql2->fetch_object()) { ?>
            <tr>
               <td><?= $datos->id ?></td>
               <td><?= $datos->dni ?></td>
               <td><?= $datos->nombre ?></td>
               <td><?= $datos->apellido_paterno ?></td>
               <td><?= $datos->apellido_materno ?></td>
               <td><?= $datos->nomCarrera ?></td>
               <td><?= $datos->fecha_inicio ?></td>
               <td><?= $datos->fecha_final ?></td>
               <td><?= $datos->titulo ?></td>
               <td><?= $datos->trabajo_actual ?></td>
               <td><?= $datos->ruc ?></td>
               <td><?= $datos->ubicacion ?></td>
               <td><?= $datos->telefono ?></td>
               <td><?= $datos->estado ?></td>
               <td><?= $datos->correo ?></td>
               <td><?= $datos->usuario ?></td>
               <td><img data-toggle="modal" data-target="#btnmodificarFoto<?= $datos->id ?>" width="50px" src="data:image/jpg;base64,<?= base64_encode($datos->foto) ?>" /></td>
               <td>
                  <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#btncambiarClave<?= $datos->id ?>"><i class="fas fa-eye"></i></a>
                  <a href="" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#btnmodificar<?= $datos->id ?>"><i class="fas fa-edit"></i></a>
                  <a href="estudiante.php?idEliminarE=<?= $datos->id ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
               </td>
            </tr>

            <!-- Modal MODIFICAR ESTUDIANTE-->
            <div class="modal fade" id="btnmodificar<?= $datos->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title w-100" id="exampleModalLabel">MODIFICAR ESTUDIANTE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="" method="POST" class="px-3">
                           <div class="row">
                              <div hidden class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id ?>">
                              </div>
                              <?php
                              $carreras = $conexion->query(" select * from carrera ");
                              ?>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <select required name="txtcarrera" class="input input__select">
                                    <option value="">Seleccionar carrera...</option>
                                    <?php
                                    while ($datosCarrera = $carreras->fetch_object()) { ?>
                                       <option <?= $datosCarrera->id_carrera == $datos->carrera ? 'selected' : '' ?> value="<?= $datosCarrera->id_carrera ?>"><?= $datosCarrera->nombre ?></option>
                                    <?php }
                                    ?>
                                 </select>
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="DNI del estudiante" class="input input__text" name="txtdni" value="<?= $datos->dni ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Nombre del estudiante" class="input input__text" name="txtnombre" value="<?= $datos->nombre ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Apellido paterno" class="input input__text" name="txtapepat" value="<?= $datos->apellido_paterno ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Apellido materno" class="input input__text" name="txtapemat" value="<?= $datos->apellido_materno ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <label>Fecha inicio</label>
                                 <input type="date" class="input input__text" name="txtfechainicio" value="<?= $datos->fecha_inicio ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <label>Fecha final</label>
                                 <input type="date" class="input input__text" name="txtfechafinal" value="<?= $datos->fecha_final ?>">
                              </div>
                              <select name="txtestado" class="input input__select">
                                 <option <?= $datos->estado == '' ? 'selected' : '' ?> value="">Seleccionar estado actual...</option>
                                 <option <?= $datos->estado == 'Vivo' ? 'selected' : '' ?> value="Vivo">Vivo</option>
                                 <option <?= $datos->estado == 'Fallecido' ? 'selected' : '' ?> value="Fallecido">Fallecido</option>
                              </select>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" class="input input__text" name="txtcorreo" placeholder="Correo" value="<?= $datos->correo ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Titulo" class="input input__text" name="txttitulo" value="<?= $datos->titulo ?>">
                              </div>
                              <h6 class="text-center text-dark font-weight-bold">Datos del empleo</h6>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Trabajo Actual" class="input input__text" name="txttrabajo" value="<?= $datos->trabajo_actual ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Ruc" class="input input__text" name="txtruc" value="<?= $datos->ruc ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Ubicacion" class="input input__text" name="txtubicacion" value="<?= $datos->ubicacion ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="text" placeholder="Telefono" class="input input__text" name="txttelefono" value="<?= $datos->telefono ?>">
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input required type="text" placeholder="Nombre de usuario" class="input input__text" name="txtusuario" value="<?= $datos->usuario ?>">
                              </div>

                              <div class="text-right p-2">
                                 <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                                 <button type="submit" value="ok" name="btnmodificarE" class="btn btn-primary btn-rounded">Modificar</button>
                              </div>
                           </div>
                        </form>
                     </div>

                  </div>
               </div>
            </div>

            <!-- Modal MODIFICAR FOTO-->
            <div class="modal fade" id="btnmodificarFoto<?= $datos->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id ?>">
                              </div>
                              <div class="m-auto text-center">
                                 <img width="300px" src="data:image/jpg;base64,<?= base64_encode($datos->foto) ?>" />
                              </div>
                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="file" class="input input__text" name="txtfoto">
                              </div>
                              <div class="text-right p-2">
                                 <button type="submit" value="ok" name="btneliminarFotoE" class="btn btn-danger btn-rounded">Eliminar Foto</button>
                                 <button type="submit" value="ok" name="btnmodificarFotoE" class="btn btn-primary btn-rounded">Modificar Foto</button>
                              </div>
                           </div>
                        </form>
                     </div>

                  </div>
               </div>
            </div>

            <!-- Modal CAMBIAR CONTRASEÑA -->
            <div class="modal fade" id="btncambiarClave<?= $datos->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                 <input type="text" class="input input__text" name="txtid" value="<?= $datos->id ?>">
                              </div>

                              <div class="fl-flex-label mb-4 px-2 col-12">
                                 <input type="password" class="input input__text" name="txtclave" placeholder="Ingresa la nueva contraseña">
                              </div>
                              <div class="text-right p-2">
                                 <button type="submit" value="ok" name="btnCambiarClave" class="btn btn-primary btn-rounded">Modificar Contraseña</button>
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
               <h5 class="modal-title w-100" id="exampleModalLabel">REGISTRAR ESTUDIANTE</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form method="post" class="px-3" enctype="multipart/form-data">
                  <div class="row">
                     <?php
                     $carreras = $conexion->query(" select * from carrera ");
                     ?>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <select required name="txtcarrera" class="input input__select">
                           <option value="">Seleccionar carrera...</option>
                           <?php
                           while ($datosCarrera = $carreras->fetch_object()) { ?>
                              <option value="<?= $datosCarrera->id_carrera ?>"><?= $datosCarrera->nombre ?></option>
                           <?php }
                           ?>
                        </select>
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="DNI del estudiante" class="input input__text" name="txtdni">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Nombre del estudiante" class="input input__text" name="txtnombre">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Apellido paterno" class="input input__text" name="txtapepat">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Apellido materno" class="input input__text" name="txtapemat">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <label>Fecha inicio</label>
                        <input type="date" class="input input__text" name="txtfechainicio">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <label>Fecha final</label>
                        <input type="date" class="input input__text" name="txtfechafinal">
                     </div>
                     <select name="txtestado" class="input input__select">
                        <option value="">Seleccionar estado actual...</option>
                        <option value="Vivo">Vivo</option>
                        <option value="Fallecido">Fallecido</option>
                     </select>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" class="input input__text" name="txtcorreo" placeholder="Correo">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Titulo" class="input input__text" name="txttitulo">
                     </div>
                     <h6 class="text-center text-dark font-weight-bold">Datos del empleo</h6>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Trabajo Actual" class="input input__text" name="txttrabajo">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Ruc" class="input input__text" name="txtruc">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Ubicacion" class="input input__text" name="txtubicacion">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="text" placeholder="Telefono" class="input input__text" name="txttelefono">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="text" placeholder="Nombre de usuario" class="input input__text" name="txtusuario">
                     </div>
                     <div class="fl-flex-label mb-4 px-2 col-12">
                        <input required type="password" placeholder="Contraseña" class="input input__text" name="txtclave">
                     </div>
                     <!-- <div class="fl-flex-label mb-4 px-2 col-12">
                        <input type="file" class="input input__text" name="txtfoto">
                     </div> -->


                     <div class="text-right p-2">
                        <a href="" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cerrar</a>
                        <button type="submit" value="ok" name="btnregistrarE" class="btn btn-primary btn-rounded">Registrar</button>
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