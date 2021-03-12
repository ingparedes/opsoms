<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fgrupodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fgrupodelete = currentForm = new ew.Form("fgrupodelete", "delete");
    loadjs.done("fgrupodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.grupo) ew.vars.tables.grupo = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fgrupodelete" id="fgrupodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
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
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <th class="<?= $Page->id_grupo->headerCellClass() ?>"><span id="elh_grupo_id_grupo" class="grupo_id_grupo"><?= $Page->id_grupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <th class="<?= $Page->imgen_grupo->headerCellClass() ?>"><span id="elh_grupo_imgen_grupo" class="grupo_imgen_grupo"><?= $Page->imgen_grupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <th class="<?= $Page->nombre_grupo->headerCellClass() ?>"><span id="elh_grupo_nombre_grupo" class="grupo_nombre_grupo"><?= $Page->nombre_grupo->caption() ?></span></th>
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
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <td <?= $Page->id_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_id_grupo" class="grupo_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <td <?= $Page->imgen_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_imgen_grupo" class="grupo_imgen_grupo">
<span>
<?= GetFileViewTag($Page->imgen_grupo, $Page->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <td <?= $Page->nombre_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_grupo_nombre_grupo" class="grupo_nombre_grupo">
<span<?= $Page->nombre_grupo->viewAttributes() ?>>
<?= $Page->nombre_grupo->getViewValue() ?></span>
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
