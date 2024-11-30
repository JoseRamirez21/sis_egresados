<?php
include "../../modelo/conexion.php";
$dni = $_POST["cod"];
$sql = $conexion->query(" select * from estudiante where dni='$dni' ");
while ($datos = $sql->fetch_object()) { ?>
   <option value="<?= $datos->id ?>"><?= $datos->nombre . " " . $datos->apellido_paterno . " " . $datos->apellido_materno ?></option>
<?php }
if (strlen($dni) <= 7) { ?>
   <option value="">Seleccionar estudiantes...</option>
<?php }

?>