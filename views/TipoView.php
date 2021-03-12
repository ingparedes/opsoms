<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TipoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftipoview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ftipoview = currentForm = new ew.Form("ftipoview", "view");
    loadjs.done("ftipoview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.tipo) ew.vars.tables.tipo = <?= JsonEncode(GetClientVar("tables", "tipo")) ?>;
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
<form name="ftipoview" id="ftipoview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tipo">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id_tipo->Visible) { // id_tipo ?>
    <tr id="r_id_tipo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_id_tipo"><template id="tpc_tipo_id_tipo"><?= $Page->id_tipo->caption() ?></template></span></td>
        <td data-name="id_tipo" <?= $Page->id_tipo->cellAttributes() ?>>
<template id="tpx_tipo_id_tipo"><span id="el_tipo_id_tipo">
<span<?= $Page->id_tipo->viewAttributes() ?>>
<?= $Page->id_tipo->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_es->Visible) { // tipo_es ?>
    <tr id="r_tipo_es">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_tipo_es"><template id="tpc_tipo_tipo_es"><?= $Page->tipo_es->caption() ?></template></span></td>
        <td data-name="tipo_es" <?= $Page->tipo_es->cellAttributes() ?>>
<template id="tpx_tipo_tipo_es"><span id="el_tipo_tipo_es">
<span<?= $Page->tipo_es->viewAttributes() ?>>
<?= $Page->tipo_es->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_en->Visible) { // tipo_en ?>
    <tr id="r_tipo_en">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tipo_tipo_en"><template id="tpc_tipo_tipo_en"><?= $Page->tipo_en->caption() ?></template></span></td>
        <td data-name="tipo_en" <?= $Page->tipo_en->cellAttributes() ?>>
<template id="tpx_tipo_tipo_en"><span id="el_tipo_tipo_en">
<span<?= $Page->tipo_en->viewAttributes() ?>>
<?= $Page->tipo_en->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_tipoview" class="ew-custom-template"></div>
<template id="tpm_tipoview">
<div id="ct_TipoView"><fieldset>
<legend>Titulo</legend>
<h2>Ejercicio de Simulación de Respuesta a <slot class="ew-slot" name="tpx_tipo_evento"></slot></h2>
<h2>Pais<slot class="ew-slot" name="tpx_pais_escenario"></slot></h2>
<h3>Fecha <slot class="ew-slot" name="tpx_fechaini_real"></slot> | <slot class="ew-slot" name="tpx_fechafinal_real"></slot>  </h3>
<legend>Descripcion</legend>
<slot class="ew-slot" name="tpx_descripcion_escenario"></slot>
<legend>Grupos</legend>
<legend>Participantes</legend>
<legend>Concluciones</legend>
</fieldset>
</div>
</template>
</form>
<script>
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_tipoview", "tpm_tipoview", "tipoview", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
