<?php
include "../../modelo/conexion.php";
$id_carrera = $_POST["cod2"];
$sql = $conexion->query(" select * from modulo where carrera=$id_carrera ");
while ($datos = $sql->fetch_object()) { ?>
   <option value="<?= $datos->id_modulo ?>"><?= $datos->numero . " " . $datos->nombre ?></option>
<?php }


?>