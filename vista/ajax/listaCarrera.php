<?php
include "../../modelo/conexion.php";
$dni = $_POST["cod"];
$sql = $conexion->query(" SELECT
estudiante.dni,
carrera.nombre,
carrera.id_carrera
FROM
estudiante
INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera
where dni='$dni' ");
while ($datos = $sql->fetch_object()) { ?>
   <option value="<?= $datos->id_carrera ?>"><?= $datos->nombre ?></option>
<?php }

if (strlen($dni) <= 7) { ?>
   <option value="">Seleccionar Carrera...</option>
<?php }


?>