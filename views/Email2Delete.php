<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Email2Delete = &$Page;
?>
<script>
var currentForm, currentPageID;
var femail2delete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    femail2delete = currentForm = new ew.Form("femail2delete", "delete");
    loadjs.done("femail2delete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.email2) ew.vars.tables.email2 = <?= JsonEncode(GetClientVar("tables", "email2")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="femail2delete" id="femail2delete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="email2">
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
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
        <th class="<?= $Page->sender_userid->headerCellClass() ?>"><span id="elh_email2_sender_userid" class="email2_sender_userid"><?= $Page->sender_userid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
        <th class="<?= $Page->copy_sender->headerCellClass() ?>"><span id="elh_email2_copy_sender" class="email2_copy_sender"><?= $Page->copy_sender->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
        <th class="<?= $Page->sujeto->headerCellClass() ?>"><span id="elh_email2_sujeto" class="email2_sujeto"><?= $Page->sujeto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <th class="<?= $Page->mensaje->headerCellClass() ?>"><span id="elh_email2_mensaje" class="email2_mensaje"><?= $Page->mensaje->caption() ?></span></th>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
        <th class="<?= $Page->archivo->headerCellClass() ?>"><span id="elh_email2_archivo" class="email2_archivo"><?= $Page->archivo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
        <th class="<?= $Page->tiempo->headerCellClass() ?>"><span id="elh_email2_tiempo" class="email2_tiempo"><?= $Page->tiempo->caption() ?></span></th>
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
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
        <td <?= $Page->sender_userid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_email2_sender_userid" class="email2_sender_userid">
<span<?= $Page->sender_userid->viewAttributes() ?>>
<?= $Page->sender_userid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
        <td <?= $Page->copy_sender->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_email2_copy_sender" class="email2_copy_sender">
<span<?= $Page->copy_sender->viewAttributes() ?>>
<?= $Page->copy_sender->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
        <td <?= $Page->sujeto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_email2_sujeto" class="email2_sujeto">
<span<?= $Page->sujeto->viewAttributes() ?>>
<?= $Page->sujeto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <td <?= $Page->mensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_email2_mensaje" class="email2_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
        <td <?= $Page->archivo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_email2_archivo" class="email2_archivo">
<span<?= $Page->archivo->viewAttributes() ?>><?php
$arcx = CurrentPage()->archivo->CurrentValue;
if ($arcx != '') { 
echo "<a href='/simexamerica/Inicio' ><i class='cil-paperclip'></i></a>";
}
?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
        <td <?= $Page->tiempo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_email2_tiempo" class="email2_tiempo">
<span<?= $Page->tiempo->viewAttributes() ?>>
<?= $Page->tiempo->getViewValue() ?></span>
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
