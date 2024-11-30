<?php
include "../../modelo/conexion.php";
$dni = $_POST["cod2"];
$sql = $conexion->query(" SELECT semestre.semestre,semestre.id_semestre,estudiante.dni,semestre.`año`
FROM semestre INNER JOIN nota ON nota.semestre = semestre.id_semestre
INNER JOIN estudiante ON nota.estudiante = estudiante.id
where dni='$dni' GROUP BY id_semestre ");

while ($datos = $sql->fetch_object()) { ?>
   <option value="<?= $datos->id_semestre ?>"><?= $datos->semestre . " " . $datos->año ?></option>
<?php }


?>