<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PaisgmtDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpaisgmtdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpaisgmtdelete = currentForm = new ew.Form("fpaisgmtdelete", "delete");
    loadjs.done("fpaisgmtdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.paisgmt) ew.vars.tables.paisgmt = <?= JsonEncode(GetClientVar("tables", "paisgmt")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpaisgmtdelete" id="fpaisgmtdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="paisgmt">
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
<?php if ($Page->id_zone->Visible) { // id_zone ?>
        <th class="<?= $Page->id_zone->headerCellClass() ?>"><span id="elh_paisgmt_id_zone" class="paisgmt_id_zone"><?= $Page->id_zone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th class="<?= $Page->codpais->headerCellClass() ?>"><span id="elh_paisgmt_codpais" class="paisgmt_codpais"><?= $Page->codpais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nompais->Visible) { // nompais ?>
        <th class="<?= $Page->nompais->headerCellClass() ?>"><span id="elh_paisgmt_nompais" class="paisgmt_nompais"><?= $Page->nompais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->timezone->Visible) { // timezone ?>
        <th class="<?= $Page->timezone->headerCellClass() ?>"><span id="elh_paisgmt_timezone" class="paisgmt_timezone"><?= $Page->timezone->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gmt->Visible) { // gmt ?>
        <th class="<?= $Page->gmt->headerCellClass() ?>"><span id="elh_paisgmt_gmt" class="paisgmt_gmt"><?= $Page->gmt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codiso3->Visible) { // codiso3 ?>
        <th class="<?= $Page->codiso3->headerCellClass() ?>"><span id="elh_paisgmt_codiso3" class="paisgmt_codiso3"><?= $Page->codiso3->caption() ?></span></th>
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
<?php if ($Page->id_zone->Visible) { // id_zone ?>
        <td <?= $Page->id_zone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_id_zone" class="paisgmt_id_zone">
<span<?= $Page->id_zone->viewAttributes() ?>>
<?= $Page->id_zone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <td <?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_codpais" class="paisgmt_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nompais->Visible) { // nompais ?>
        <td <?= $Page->nompais->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_nompais" class="paisgmt_nompais">
<span<?= $Page->nompais->viewAttributes() ?>>
<?= $Page->nompais->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->timezone->Visible) { // timezone ?>
        <td <?= $Page->timezone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_timezone" class="paisgmt_timezone">
<span<?= $Page->timezone->viewAttributes() ?>>
<?= $Page->timezone->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gmt->Visible) { // gmt ?>
        <td <?= $Page->gmt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_gmt" class="paisgmt_gmt">
<span<?= $Page->gmt->viewAttributes() ?>>
<?= $Page->gmt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codiso3->Visible) { // codiso3 ?>
        <td <?= $Page->codiso3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_codiso3" class="paisgmt_codiso3">
<span<?= $Page->codiso3->viewAttributes() ?>>
<?= $Page->codiso3->getViewValue() ?></span>
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
