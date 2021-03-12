<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ActorSimuladoDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var factor_simuladodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    factor_simuladodelete = currentForm = new ew.Form("factor_simuladodelete", "delete");
    loadjs.done("factor_simuladodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.actor_simulado) ew.vars.tables.actor_simulado = <?= JsonEncode(GetClientVar("tables", "actor_simulado")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="factor_simuladodelete" id="factor_simuladodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="actor_simulado">
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
<?php if ($Page->id_actor->Visible) { // id_actor ?>
        <th class="<?= $Page->id_actor->headerCellClass() ?>"><span id="elh_actor_simulado_id_actor" class="actor_simulado_id_actor"><?= $Page->id_actor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_actor->Visible) { // nombre_actor ?>
        <th class="<?= $Page->nombre_actor->headerCellClass() ?>"><span id="elh_actor_simulado_nombre_actor" class="actor_simulado_nombre_actor"><?= $Page->nombre_actor->caption() ?></span></th>
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
<?php if ($Page->id_actor->Visible) { // id_actor ?>
        <td <?= $Page->id_actor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_actor_simulado_id_actor" class="actor_simulado_id_actor">
<span<?= $Page->id_actor->viewAttributes() ?>>
<?= $Page->id_actor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_actor->Visible) { // nombre_actor ?>
        <td <?= $Page->nombre_actor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_actor_simulado_nombre_actor" class="actor_simulado_nombre_actor">
<span<?= $Page->nombre_actor->viewAttributes() ?>>
<?= $Page->nombre_actor->getViewValue() ?></span>
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
