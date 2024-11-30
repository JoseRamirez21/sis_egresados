<?php
include "../../modelo/conexion.php";
$id_carrera = $_POST["cod2"];
$sql = $conexion->query(" select * from estudiante where carrera=$id_carrera ");
while ($datos = $sql->fetch_object()) { ?>
   <option value="<?= $datos->id ?>"><?= $datos->nombre . " " . $datos->apellido_paterno . " " . $datos->apellido_materno ?></option>
<?php }


?>