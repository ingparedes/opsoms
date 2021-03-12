<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EscenarioView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fescenarioview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fescenarioview = currentForm = new ew.Form("fescenarioview", "view");
    loadjs.done("fescenarioview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.escenario) ew.vars.tables.escenario = <?= JsonEncode(GetClientVar("tables", "escenario")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fescenarioview" id="fescenarioview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="escenario">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <tr id="r_id_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_id_escenario"><template id="tpc_escenario_id_escenario"><?= $Page->id_escenario->caption() ?></template></span></td>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<template id="tpx_escenario_id_escenario"><span id="el_escenario_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
    <tr id="r_icon_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_icon_escenario"><template id="tpc_escenario_icon_escenario"><?= $Page->icon_escenario->caption() ?></template></span></td>
        <td data-name="icon_escenario" <?= $Page->icon_escenario->cellAttributes() ?>>
<template id="tpx_escenario_icon_escenario" class="escenarioview">
<?php
$idm = CurrentPage()->icon_escenario->CurrentValue;
echo "<img width='25px' src='$idm'>";
?>
</template>
<template id="tpx_escenario_icon_escenario"><span id="el_escenario_icon_escenario">
<span><slot name="tpx_escenario_icon_escenario"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
    <tr id="r_fechacreacion_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechacreacion_escenario"><template id="tpc_escenario_fechacreacion_escenario"><?= $Page->fechacreacion_escenario->caption() ?></template></span></td>
        <td data-name="fechacreacion_escenario" <?= $Page->fechacreacion_escenario->cellAttributes() ?>>
<template id="tpx_escenario_fechacreacion_escenario"><span id="el_escenario_fechacreacion_escenario">
<span<?= $Page->fechacreacion_escenario->viewAttributes() ?>>
<?= $Page->fechacreacion_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
    <tr id="r_nombre_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_nombre_escenario"><template id="tpc_escenario_nombre_escenario"><?= $Page->nombre_escenario->caption() ?></template></span></td>
        <td data-name="nombre_escenario" <?= $Page->nombre_escenario->cellAttributes() ?>>
<template id="tpx_escenario_nombre_escenario"><span id="el_escenario_nombre_escenario">
<span<?= $Page->nombre_escenario->viewAttributes() ?>>
<?= $Page->nombre_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_evento->Visible) { // tipo_evento ?>
    <tr id="r_tipo_evento">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_tipo_evento"><template id="tpc_escenario_tipo_evento"><?= $Page->tipo_evento->caption() ?></template></span></td>
        <td data-name="tipo_evento" <?= $Page->tipo_evento->cellAttributes() ?>>
<template id="tpx_escenario_tipo_evento"><span id="el_escenario_tipo_evento">
<span<?= $Page->tipo_evento->viewAttributes() ?>>
<?= $Page->tipo_evento->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
    <tr id="r_incidente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_incidente"><template id="tpc_escenario_incidente"><?= $Page->incidente->caption() ?></template></span></td>
        <td data-name="incidente" <?= $Page->incidente->cellAttributes() ?>>
<template id="tpx_escenario_incidente"><span id="el_escenario_incidente">
<span<?= $Page->incidente->viewAttributes() ?>>
<?= $Page->incidente->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
    <tr id="r_pais_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_pais_escenario"><template id="tpc_escenario_pais_escenario"><?= $Page->pais_escenario->caption() ?></template></span></td>
        <td data-name="pais_escenario" <?= $Page->pais_escenario->cellAttributes() ?>>
<template id="tpx_escenario_pais_escenario"><span id="el_escenario_pais_escenario">
<span<?= $Page->pais_escenario->viewAttributes() ?>>
<?= $Page->pais_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->zonahora_escenario->Visible) { // zonahora_escenario ?>
    <tr id="r_zonahora_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_zonahora_escenario"><template id="tpc_escenario_zonahora_escenario"><?= $Page->zonahora_escenario->caption() ?></template></span></td>
        <td data-name="zonahora_escenario" <?= $Page->zonahora_escenario->cellAttributes() ?>>
<template id="tpx_escenario_zonahora_escenario"><span id="el_escenario_zonahora_escenario">
<span<?= $Page->zonahora_escenario->viewAttributes() ?>>
<?= $Page->zonahora_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_escenario->Visible) { // descripcion_escenario ?>
    <tr id="r_descripcion_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_descripcion_escenario"><template id="tpc_escenario_descripcion_escenario"><?= $Page->descripcion_escenario->caption() ?></template></span></td>
        <td data-name="descripcion_escenario" <?= $Page->descripcion_escenario->cellAttributes() ?>>
<template id="tpx_escenario_descripcion_escenario"><span id="el_escenario_descripcion_escenario">
<span<?= $Page->descripcion_escenario->viewAttributes() ?>>
<?= $Page->descripcion_escenario->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
    <tr id="r_fechaini_simulado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechaini_simulado"><template id="tpc_escenario_fechaini_simulado"><?= $Page->fechaini_simulado->caption() ?></template></span></td>
        <td data-name="fechaini_simulado" <?= $Page->fechaini_simulado->cellAttributes() ?>>
<template id="tpx_escenario_fechaini_simulado"><span id="el_escenario_fechaini_simulado">
<span<?= $Page->fechaini_simulado->viewAttributes() ?>>
<?= $Page->fechaini_simulado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechafin_simulado->Visible) { // fechafin_simulado ?>
    <tr id="r_fechafin_simulado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechafin_simulado"><template id="tpc_escenario_fechafin_simulado"><?= $Page->fechafin_simulado->caption() ?></template></span></td>
        <td data-name="fechafin_simulado" <?= $Page->fechafin_simulado->cellAttributes() ?>>
<template id="tpx_escenario_fechafin_simulado"><span id="el_escenario_fechafin_simulado">
<span<?= $Page->fechafin_simulado->viewAttributes() ?>>
<?= $Page->fechafin_simulado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
    <tr id="r_fechaini_real">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechaini_real"><template id="tpc_escenario_fechaini_real"><?= $Page->fechaini_real->caption() ?></template></span></td>
        <td data-name="fechaini_real" <?= $Page->fechaini_real->cellAttributes() ?>>
<template id="tpx_escenario_fechaini_real"><span id="el_escenario_fechaini_real">
<span<?= $Page->fechaini_real->viewAttributes() ?>>
<?= $Page->fechaini_real->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechafinal_real->Visible) { // fechafinal_real ?>
    <tr id="r_fechafinal_real">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_fechafinal_real"><template id="tpc_escenario_fechafinal_real"><?= $Page->fechafinal_real->caption() ?></template></span></td>
        <td data-name="fechafinal_real" <?= $Page->fechafinal_real->cellAttributes() ?>>
<template id="tpx_escenario_fechafinal_real"><span id="el_escenario_fechafinal_real">
<span<?= $Page->fechafinal_real->viewAttributes() ?>>
<?= $Page->fechafinal_real->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->image_escenario->Visible) { // image_escenario ?>
    <tr id="r_image_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_image_escenario"><template id="tpc_escenario_image_escenario"><?= $Page->image_escenario->caption() ?></template></span></td>
        <td data-name="image_escenario" <?= $Page->image_escenario->cellAttributes() ?>>
<template id="tpx_escenario_image_escenario"><span id="el_escenario_image_escenario">
<span>
<?= GetFileViewTag($Page->image_escenario, $Page->image_escenario->getViewValue(), false) ?>
</span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_estado"><template id="tpc_escenario_estado"><?= $Page->estado->caption() ?></template></span></td>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<template id="tpx_escenario_estado"><span id="el_escenario_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->entrar->Visible) { // entrar ?>
    <tr id="r_entrar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_escenario_entrar"><template id="tpc_escenario_entrar"><?= $Page->entrar->caption() ?></template></span></td>
        <td data-name="entrar" <?= $Page->entrar->cellAttributes() ?>>
<template id="tpx_escenario_entrar" class="escenarioview">
<div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->entrar->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"GrupoList?showmaster=escenario&fk_id_escenario=$id&showdetail=\" data-original-title=\"Grupo\"><i class=\"fa fa-user-plus\"data-caption=\"Grupo\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"TareasList?showmaster=escenario&fk_id_escenario=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
</template>
<template id="tpx_escenario_entrar"><span id="el_escenario_entrar">
<span<?= $Page->entrar->viewAttributes() ?>><slot name="tpx_escenario_entrar"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_escenarioview" class="ew-custom-template"></div>
<template id="tpm_escenarioview">
<div id="ct_EscenarioView">
    <table>
    <tr>
    <td style="text-align:center">
        <h2><slot class="ew-slot" name="tpx_escenario_nombre_escenario"></slot></h2>
    <h2><slot class="ew-slot" name="tpx_escenario_tipo_evento"></slot> - <slot class="ew-slot" name="tpx_escenario_incidente"></slot> </h2>
    <h2> País <slot class="ew-slot" name="tpx_escenario_pais_escenario"></slot></h2>
    <h2> Fecha: <slot class="ew-slot" name="tpx_escenario_fechaini_real"></slot> | <slot class="ew-slot" name="tpx_escenario_fechafinal_real"></slot></h2>
    <slot class="ew-slot" name="tpx_escenario_icon_escenario"></slot>
    </tr>
    </td>
    </table>
<hr>
    <h3>Descripcíon</h3>
     <slot class="ew-slot" name="tpx_escenario_descripcion_escenario"></slot>
 <hr>
 <h3>Grupos</h2>
 <hr>
  <h3>Participantes</h3>
  <hr>
  <h3>Concluciones</h3>
</div>
</template>
<?php
    if (in_array("grupo", explode(",", $Page->getCurrentDetailTable())) && $grupo->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("grupo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GrupoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("tareas", explode(",", $Page->getCurrentDetailTable())) && $tareas->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("tareas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "TareasGrid.php" ?>
<?php } ?>
</form>
<script>
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_escenarioview", "tpm_escenarioview", "escenarioview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
