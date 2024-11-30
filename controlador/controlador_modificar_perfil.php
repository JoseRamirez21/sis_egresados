<?php

if (!empty($_POST["btnmodificarPerfil"])) {
    if (!empty($_POST["txtid"]) and !empty($_POST["txtdni"]) and !empty($_POST["txtusuario"])) {
        $id = $_POST["txtid"];
        $dni = $_POST["txtdni"];
        $nombre = $_POST["txtnombre"];
        $apellidopat = $_POST["txtapellidopat"];
        $apellidomat = $_POST["txtapellidomat"];
        $usuario = $_POST["txtusuario"];
        $correo = $_POST["txtcorreo"];
        $sql = $conexion->query(" update usuario set dni='$dni', nombre='$nombre', ape_paterno='$apellidopat', ape_materno='$apellidomat', correo='$correo', usuario='$usuario' where id_usuario=$id ");
        if ($sql == true) { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "CORRECTO",
                        type: "success",
                        text: "Datos modificados correctamente",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "INCORRECTO",
                        type: "error",
                        text: "Error al modificar los datos",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php }
    } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "Los campos estan vacíos",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php } ?>

    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>

<?php }

?>