<?php

namespace PHPMaker2021\simexamerica;

// Page object
$IncidenteView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fincidenteview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fincidenteview = currentForm = new ew.Form("fincidenteview", "view");
    loadjs.done("fincidenteview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.incidente) ew.vars.tables.incidente = <?= JsonEncode(GetClientVar("tables", "incidente")) ?>;
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
<form name="fincidenteview" id="fincidenteview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="incidente">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_incidente->Visible) { // id_incidente ?>
    <tr id="r_id_incidente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_incidente_id_incidente"><?= $Page->id_incidente->caption() ?></span></td>
        <td data-name="id_incidente" <?= $Page->id_incidente->cellAttributes() ?>>
<span id="el_incidente_id_incidente">
<span<?= $Page->id_incidente->viewAttributes() ?>>
<?= $Page->id_incidente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_tipo->Visible) { // id_tipo ?>
    <tr id="r_id_tipo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_incidente_id_tipo"><?= $Page->id_tipo->caption() ?></span></td>
        <td data-name="id_tipo" <?= $Page->id_tipo->cellAttributes() ?>>
<span id="el_incidente_id_tipo">
<span<?= $Page->id_tipo->viewAttributes() ?>>
<?= $Page->id_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->incidente_es->Visible) { // incidente_es ?>
    <tr id="r_incidente_es">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_incidente_incidente_es"><?= $Page->incidente_es->caption() ?></span></td>
        <td data-name="incidente_es" <?= $Page->incidente_es->cellAttributes() ?>>
<span id="el_incidente_incidente_es">
<span<?= $Page->incidente_es->viewAttributes() ?>>
<?= $Page->incidente_es->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->incidente_en->Visible) { // incidente_en ?>
    <tr id="r_incidente_en">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_incidente_incidente_en"><?= $Page->incidente_en->caption() ?></span></td>
        <td data-name="incidente_en" <?= $Page->incidente_en->cellAttributes() ?>>
<span id="el_incidente_incidente_en">
<span<?= $Page->incidente_en->viewAttributes() ?>>
<?= $Page->incidente_en->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->icono->Visible) { // icono ?>
    <tr id="r_icono">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_incidente_icono"><?= $Page->icono->caption() ?></span></td>
        <td data-name="icono" <?= $Page->icono->cellAttributes() ?>>
<span id="el_incidente_icono">
<span<?= $Page->icono->viewAttributes() ?>>
<?= $Page->icono->getViewValue() ?></span>
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
