<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SubgrupoDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubgrupodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fsubgrupodelete = currentForm = new ew.Form("fsubgrupodelete", "delete");
    loadjs.done("fsubgrupodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.subgrupo) ew.vars.tables.subgrupo = <?= JsonEncode(GetClientVar("tables", "subgrupo")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsubgrupodelete" id="fsubgrupodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subgrupo">
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
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
        <th class="<?= $Page->id_subgrupo->headerCellClass() ?>"><span id="elh_subgrupo_id_subgrupo" class="subgrupo_id_subgrupo"><?= $Page->id_subgrupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <th class="<?= $Page->imagen_subgrupo->headerCellClass() ?>"><span id="elh_subgrupo_imagen_subgrupo" class="subgrupo_imagen_subgrupo"><?= $Page->imagen_subgrupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <th class="<?= $Page->nombre_subgrupo->headerCellClass() ?>"><span id="elh_subgrupo_nombre_subgrupo" class="subgrupo_nombre_subgrupo"><?= $Page->nombre_subgrupo->caption() ?></span></th>
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
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
        <td <?= $Page->id_subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subgrupo_id_subgrupo" class="subgrupo_id_subgrupo">
<span<?= $Page->id_subgrupo->viewAttributes() ?>>
<?= $Page->id_subgrupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <td <?= $Page->imagen_subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subgrupo_imagen_subgrupo" class="subgrupo_imagen_subgrupo">
<span>
<?= GetFileViewTag($Page->imagen_subgrupo, $Page->imagen_subgrupo->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <td <?= $Page->nombre_subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_subgrupo_nombre_subgrupo" class="subgrupo_nombre_subgrupo">
<span<?= $Page->nombre_subgrupo->viewAttributes() ?>>
<?= $Page->nombre_subgrupo->getViewValue() ?></span>
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
