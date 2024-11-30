<?php
session_start();
if (empty($_SESSION['id']) or ($_SESSION['tipo'] == "egresado")) {
   header('location:menu_coordinador.php');
}

?>

<style>
   ul li:nth-child(6) .activos {
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
   // include "../controlador/semestre/controlador_registrar_semestre.php";
   // include "../controlador/semestre/controlador_modificar_semestre.php";
   // include "../controlador/semestre/controlador_eliminar_semestre.php";
   $carrera = $conexion->query(" select * from carrera ");
   $semestre = $conexion->query(" select * from semestre ");
   ?>
   <form action="nota_detalle.php" method="get" class="px-3">
      <div class="row">

         <div class="fl-flex-label mb-4 px-2 col-12">
            <input type="number" name="txtdni" class="input input__select" id="val" placeholder="Ingrese el DNI del estudiante">
         </div>

         <div class="fl-flex-label mb-4 px-2 col-12">
            <select name="txtcarrera" class="input input__select" id="listarCarrera">
               <option value="">Seleccionar Carrera...</option>
            </select>
         </div>

         <div class="fl-flex-label mb-4 px-2 col-12">
            <select name="txtestudiante" class="input input__select" id="listaEstudiantes">
               <option value="">No existen estudiantes</option>
            </select>
         </div>

         <div class="fl-flex-label mb-4 px-2 col-12">
            <select name="txtsemestre" class="input input__select">
               <option value="">Seleccionar Semestre...</option>
               <?php
               while ($datosSemestre = $semestre->fetch_object()) { ?>
                  <option value="<?= $datosSemestre->id_semestre ?>"><?= $datosSemestre->semestre . " " . $datosSemestre->año ?></option>
               <?php }
               ?>
            </select>

         </div>

         <div class="text-right p-2">
            <button type="submit" value="ok" name="btnmodificar" class="btn btn-primary btn-rounded">Buscar Notas</button>
         </div>
      </div>
   </form>

</div>
</div>
<!-- fin del contenido principal -->
<script type="text/javascript">
   $('#val').keyup(function() {
      recargarLista();
      recargarListaCarrera();
   });

   $('#val').blur(function() {
      recargarLista();
      recargarListaCarrera();
   });



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

   function recargarListaCarrera() {
      $.ajax({
         type: "POST",
         url: "ajax/listaCarrera.php",
         data: "cod=" + $('#val').val(),
         success: function(q) {
            $('#listarCarrera').html(q);
         }
      });
   }
</script>

<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>