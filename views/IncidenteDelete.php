<?php

namespace PHPMaker2021\simexamerica;

// Page object
$IncidenteDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fincidentedelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fincidentedelete = currentForm = new ew.Form("fincidentedelete", "delete");
    loadjs.done("fincidentedelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.incidente) ew.vars.tables.incidente = <?= JsonEncode(GetClientVar("tables", "incidente")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fincidentedelete" id="fincidentedelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="incidente">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id_incidente->Visible) { // id_incidente ?>
        <th class="<?= $Page->id_incidente->headerCellClass() ?>"><span id="elh_incidente_id_incidente" class="incidente_id_incidente"><?= $Page->id_incidente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_tipo->Visible) { // id_tipo ?>
        <th class="<?= $Page->id_tipo->headerCellClass() ?>"><span id="elh_incidente_id_tipo" class="incidente_id_tipo"><?= $Page->id_tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->incidente_es->Visible) { // incidente_es ?>
        <th class="<?= $Page->incidente_es->headerCellClass() ?>"><span id="elh_incidente_incidente_es" class="incidente_incidente_es"><?= $Page->incidente_es->caption() ?></span></th>
<?php } ?>
<?php if ($Page->incidente_en->Visible) { // incidente_en ?>
        <th class="<?= $Page->incidente_en->headerCellClass() ?>"><span id="elh_incidente_incidente_en" class="incidente_incidente_en"><?= $Page->incidente_en->caption() ?></span></th>
<?php } ?>
<?php if ($Page->icono->Visible) { // icono ?>
        <th class="<?= $Page->icono->headerCellClass() ?>"><span id="elh_incidente_icono" class="incidente_icono"><?= $Page->icono->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id_incidente->Visible) { // id_incidente ?>
        <td <?= $Page->id_incidente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_incidente_id_incidente" class="incidente_id_incidente">
<span<?= $Page->id_incidente->viewAttributes() ?>>
<?= $Page->id_incidente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_tipo->Visible) { // id_tipo ?>
        <td <?= $Page->id_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_incidente_id_tipo" class="incidente_id_tipo">
<span<?= $Page->id_tipo->viewAttributes() ?>>
<?= $Page->id_tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->incidente_es->Visible) { // incidente_es ?>
        <td <?= $Page->incidente_es->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_incidente_incidente_es" class="incidente_incidente_es">
<span<?= $Page->incidente_es->viewAttributes() ?>>
<?= $Page->incidente_es->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->incidente_en->Visible) { // incidente_en ?>
        <td <?= $Page->incidente_en->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_incidente_incidente_en" class="incidente_incidente_en">
<span<?= $Page->incidente_en->viewAttributes() ?>>
<?= $Page->incidente_en->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->icono->Visible) { // icono ?>
        <td <?= $Page->icono->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_incidente_icono" class="incidente_icono">
<span<?= $Page->icono->viewAttributes() ?>>
<?= $Page->icono->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
