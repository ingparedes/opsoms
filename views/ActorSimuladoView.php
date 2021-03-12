<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ActorSimuladoView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var factor_simuladoview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    factor_simuladoview = currentForm = new ew.Form("factor_simuladoview", "view");
    loadjs.done("factor_simuladoview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.actor_simulado) ew.vars.tables.actor_simulado = <?= JsonEncode(GetClientVar("tables", "actor_simulado")) ?>;
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
<form name="factor_simuladoview" id="factor_simuladoview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="actor_simulado">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_actor->Visible) { // id_actor ?>
    <tr id="r_id_actor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_actor_simulado_id_actor"><?= $Page->id_actor->caption() ?></span></td>
        <td data-name="id_actor" <?= $Page->id_actor->cellAttributes() ?>>
<span id="el_actor_simulado_id_actor">
<span<?= $Page->id_actor->viewAttributes() ?>>
<?= $Page->id_actor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_actor->Visible) { // nombre_actor ?>
    <tr id="r_nombre_actor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_actor_simulado_nombre_actor"><?= $Page->nombre_actor->caption() ?></span></td>
        <td data-name="nombre_actor" <?= $Page->nombre_actor->cellAttributes() ?>>
<span id="el_actor_simulado_nombre_actor">
<span<?= $Page->nombre_actor->viewAttributes() ?>>
<?= $Page->nombre_actor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
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
