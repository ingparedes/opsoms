<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PaisgmtView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpaisgmtview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpaisgmtview = currentForm = new ew.Form("fpaisgmtview", "view");
    loadjs.done("fpaisgmtview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.paisgmt) ew.vars.tables.paisgmt = <?= JsonEncode(GetClientVar("tables", "paisgmt")) ?>;
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
<form name="fpaisgmtview" id="fpaisgmtview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="paisgmt">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_zone->Visible) { // id_zone ?>
    <tr id="r_id_zone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_paisgmt_id_zone"><?= $Page->id_zone->caption() ?></span></td>
        <td data-name="id_zone" <?= $Page->id_zone->cellAttributes() ?>>
<span id="el_paisgmt_id_zone">
<span<?= $Page->id_zone->viewAttributes() ?>>
<?= $Page->id_zone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <tr id="r_codpais">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_paisgmt_codpais"><?= $Page->codpais->caption() ?></span></td>
        <td data-name="codpais" <?= $Page->codpais->cellAttributes() ?>>
<span id="el_paisgmt_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nompais->Visible) { // nompais ?>
    <tr id="r_nompais">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_paisgmt_nompais"><?= $Page->nompais->caption() ?></span></td>
        <td data-name="nompais" <?= $Page->nompais->cellAttributes() ?>>
<span id="el_paisgmt_nompais">
<span<?= $Page->nompais->viewAttributes() ?>>
<?= $Page->nompais->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->timezone->Visible) { // timezone ?>
    <tr id="r_timezone">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_paisgmt_timezone"><?= $Page->timezone->caption() ?></span></td>
        <td data-name="timezone" <?= $Page->timezone->cellAttributes() ?>>
<span id="el_paisgmt_timezone">
<span<?= $Page->timezone->viewAttributes() ?>>
<?= $Page->timezone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gmt->Visible) { // gmt ?>
    <tr id="r_gmt">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_paisgmt_gmt"><?= $Page->gmt->caption() ?></span></td>
        <td data-name="gmt" <?= $Page->gmt->cellAttributes() ?>>
<span id="el_paisgmt_gmt">
<span<?= $Page->gmt->viewAttributes() ?>>
<?= $Page->gmt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codiso3->Visible) { // codiso3 ?>
    <tr id="r_codiso3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_paisgmt_codiso3"><?= $Page->codiso3->caption() ?></span></td>
        <td data-name="codiso3" <?= $Page->codiso3->cellAttributes() ?>>
<span id="el_paisgmt_codiso3">
<span<?= $Page->codiso3->viewAttributes() ?>>
<?= $Page->codiso3->getViewValue() ?></span>
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
