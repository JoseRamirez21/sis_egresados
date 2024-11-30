<?php
include "../../modelo/conexion.php";
$dni = $_POST["cod3"];
$sql = $conexion->query(" SELECT * from estudiante where dni='$dni' ");

while ($datos = $sql->fetch_object()) { ?>
   <input type="text" value="<?= $datos->id ?>" name="txtid">
   <input type="text" value="<?= $datos->carrera ?>" name="txtcarrera">
<?php }


?>