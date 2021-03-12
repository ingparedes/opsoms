<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Menucontenedor = &$Page;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="images/icofont/icofont.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        window.addEventListener("load", function() {
            var ruta = $("#btnPaciente").attr('data');
            $("#mydiv")
                .html('<object data="' + ruta + '" width="100%" height="400px" style = "overflow:hidden; border:1px" onload="rezise(this);">');
        });

        function rezise(obj) {
            var height = obj.contentWindow.document.body.scrollHeight;
            obj.height = height + 70;
            //console.log(height, obj.height);
        }
        $(document).ready(function() {

            $("#btnPaciente").click(function() {
                $("button").removeClass("btn-primary");
                $("#btnPaciente").removeClass("btn-outline-primary");
                $("#btnPaciente").addClass("btn-primary");

                var ruta = $("#btnPaciente").attr('data');
                $("#mydiv")
                    .html('<object data="' + ruta + '" width="100%" height="400px" style = "overflow:hidden; border:1px" onload="rezise(this);">');
            });
            $("#btnEvaluacion").click(function() {
                $("button").removeClass("btn-primary");
                $("#btnEvaluacion").removeClass("btn-outline-primary");
                $("#btnEvaluacion").addClass("btn-primary");

                var ruta = $("#btnEvaluacion").attr('data');
                $("#mydiv")
                    .html('<object data="' + ruta + '" width="100%" height="400px" style="overflow:hidden;border:1px" onload="rezise(this);">');
            });
            $("#btnAmbulanciad").click(function() {
                $("button").removeClass("btn-primary");
                $("#btnAmbulanciad").removeClass("btn-outline-primary");
                $("#btnAmbulanciad").addClass("btn-primary");

                var ruta = $("#btnAmbulanciad").attr('data');
                $("#mydiv")
                    .html('<object data="' + ruta + '" width="100%" height="300px" style="overflow:hidden;border:1px" onload="rezise(this);">');
            });
            $("#btnHospital").click(function() {
                $("button").removeClass("btn-primary");
                $("#btnHospital").removeClass("btn-outline-primary");
                $("#btnHospital").addClass("btn-primary");

                var ruta = $("#btnHospital").attr('data');
                $("#mydiv")
                    .html('<object data="' + ruta + '" width="100%" height="300px" style="overflow:hidden;border:1px" onload="rezise(this);">');
            });
            $("#btnSeguimiento").click(function() {
                $("button").removeClass("btn-primary");
                $("#btnSeguimiento").removeClass("btn-outline-primary");
                $("#btnSeguimiento").addClass("btn-primary");

                var ruta = $("#btnSeguimiento").attr('data');
                $("#mydiv")
                    .html('<object data="' + ruta + '" width="100%" height="300px" style="overflow:hidden;border:1px" onload="rezise(this);">');
            });
            $("#btnCerrar").click(function() {
                $("button").removeClass("btn-primary");
                $("#btnCerrar").removeClass("btn-outline-primary");
                $("#btnCerrar").addClass("btn-primary");

                var ruta = $("#btnCerrar").attr('data');
                $("#mydiv")
                    .html('<object data="' + ruta + '" width="100%" height="300px" style="overflow:hidden;border:1px" onload="rezise(this);">');
            });
        });
    </script>
</head>

<body>

    <div class="modal-container">




        <!-- BOTONES -->
        <!-- <div class="row"> 
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">

             <form class="form-inline"> 
            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                <button class="btn btn-primary" type="button" id="btnPaciente" data="GrupoAdd?showdetail=&showmaster=escenario&fk_id_escenario=40">
                <span class="cil-group"></span><br>Grupos </button>

                <button class="btn btn-outline-primary" type="button" id="btnEvaluacion" data="">
                <span class="cil-user-plus"></span><br>SubGrupos</button><br>
                </button>

                <button class="btn btn-outline-primary" type="button" id="btnAmbulanciad" data="">
                <span class="cil-laptop"></span><br>Tareas</button><br>
                </button>

                <button class="btn btn-outline-primary" type="button" id="btnHospital" data="">
                <span class="cil-paper-plane"></span><br>Mensaje</button><br>
                </button>
 <img class="papa" src="images/icon/people.svg"  width="24" height="24">
                    </form> 
            </div>


        </nav>-->
        <?php $id = $_GET['idGrupo']; ?>
        <div class="card w-75">
            <div class="card-header">

                <button class="btn btn-primary" type="button" id="btnPaciente" data="GrupoAdd?showdetail=&showmaster=escenario&fk_id_escenario=<?php echo $id ?>">
                    <span class="cil-group btn-icon mr-2"></span> <br>&nbspGrupos&nbsp
                </button>

                <button class="btn btn-primary" type="button" id="btnEvaluacion" data="SubgrupoAdd">
                    <span class="cil-user-plus btn-icon mr-2"></span><br>Subgrupos
                </button>

                <button class="btn btn-primary" type="button" id="btnAmbulanciad" data="TareasAdd">
                    <span class="cil-laptop btn-icon mr-2"></span> <br>&nbspTareas&nbsp
                </button>

                <button class="btn btn-primary" type="button" id="btnAmbulanciad" data="">
                    <span class="cil-paper-plane "></span> <br>Mensajes
                </button>
            </div>


            <div id="mydiv" class="card-body"></div>
            


        </div>

    </div>



</body>

</html>

<?= GetDebugMessage() ?>
