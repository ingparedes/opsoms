<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Grupos = &$Page;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <title>Usuarios -> Grupos</title>
</head>

<body>

    <?php
    require_once('Config.php');

    ?>
    <div class="container">
        <div class="alert alert-primary alert-dismissible fade show" role="alert" id="alerta">
            Asignación Correcta!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row">

            <div class="col-md-4">
                <?php
                $sql = "SELECT * FROM userlevels WHERE userlevelid > 1 ORDER BY userlevelname;";
                $result  = mysqli_query($con, $sql);

                ?>

                <select class="form-control" onchange="busqueda_us()" id="cmbUser">
                    <option value="0" selected>Seleccione Participante... </option>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['userlevelid']; ?>"><?php echo $row['userlevelname']; ?> </option>

                    <?php } ?>
                </select>

                <br>
                <h5>Usuarios</h5>
                <div class="row sortable" id="usuarios"></div>

            </div>

            <div class="col-md-6">
                <?php
                $sql = "SELECT * FROM grupo ORDER BY nombre_grupo;";
                $result  = mysqli_query($con, $sql);
                ?>
                <select class="form-control" onchange="busqueda_sg()" id="cmbGrupo">
                    <option value="0" selected>Seleccione Grupo... </option>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo $row['id_grupo']; ?>"><?php echo $row['nombre_grupo']; ?> </option>

                    <?php } ?>
                </select>
                <br>
                <h5>GRUPOS</h5>
                <div id="grupos"></div>
            </div>
        </div>
    </div>
    </div>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>

    <script type="text/javascript" charset="utf-8" src="assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="assets/js/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#alerta").hide();
            const grupos = document.getElementById('grupos');
            const usuarios = document.getElementById('usuarios');

            usuarios.addEventListener('dragstart', e => {
                e.dataTransfer.setData('id', e.target.id);

            });

            grupos.addEventListener('dragover', e => {
                e.preventDefault();
                //e.target.classList.add('hover');
            });
            grupos.addEventListener('dragleave', e => {
                //e.target.classList.remove('hover');

            });

            grupos.addEventListener('drop', e => {
                //e.target.classList.remove('hover');
                const user = e.dataTransfer.getData('id');
                const grupo = e.target.id;
                if (document.getElementById("cmbGrupo").style.display == 'none') {
                    guardarPosiciones(user, grupo, 'excongrupo');
                    //console.log(e.target.id);
                } else {
                    guardarPosiciones(user, grupo, 'otro');
                }

            });

            function guardarPosiciones(us, gr, tipo) {
                if (tipo == 'otro') {
                    var grupo = document.getElementById("cmbGrupo").value;
                    var datos = {
                        usuario: us,
                        grupo: grupo,
                        subgrupo: gr
                    };
                    console.log('con subgrupo');
                } else {
                    var datos = {
                        usuario: us,
                        grupo: gr
                    };
                    console.log('sin subgrupo');
                }

                $.ajax({
                    url: 'Valida.php?accion=guarda',
                    method: 'POST',
                    dataType: 'text',
                    data: datos,
                    success: function(response) {
                        console.log(response);
                        // lanzar notificación
                        //$("#alerta").show();
                        $('#alerta').fadeIn();
                        setTimeout(function() {
                            $("#alerta").fadeOut();
                        }, 2000);
                    }
                });
            }
        });
    </script>

</body>

</html>

<?= GetDebugMessage() ?>
