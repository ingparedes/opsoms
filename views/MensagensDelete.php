<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensagensDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmensagensdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmensagensdelete = currentForm = new ew.Form("fmensagensdelete", "delete");
    loadjs.done("fmensagensdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.mensagens) ew.vars.tables.mensagens = <?= JsonEncode(GetClientVar("tables", "mensagens")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmensagensdelete" id="fmensagensdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensagens">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_mensagens_id" class="mensagens_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_de->Visible) { // id_de ?>
        <th class="<?= $Page->id_de->headerCellClass() ?>"><span id="elh_mensagens_id_de" class="mensagens_id_de"><?= $Page->id_de->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_para->Visible) { // id_para ?>
        <th class="<?= $Page->id_para->headerCellClass() ?>"><span id="elh_mensagens_id_para" class="mensagens_id_para"><?= $Page->id_para->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mensagem->Visible) { // mensagem ?>
        <th class="<?= $Page->mensagem->headerCellClass() ?>"><span id="elh_mensagens_mensagem" class="mensagens_mensagem"><?= $Page->mensagem->caption() ?></span></th>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <th class="<?= $Page->time->headerCellClass() ?>"><span id="elh_mensagens_time" class="mensagens_time"><?= $Page->time->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lido->Visible) { // lido ?>
        <th class="<?= $Page->lido->headerCellClass() ?>"><span id="elh_mensagens_lido" class="mensagens_lido"><?= $Page->lido->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensagens_id" class="mensagens_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_de->Visible) { // id_de ?>
        <td <?= $Page->id_de->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensagens_id_de" class="mensagens_id_de">
<span<?= $Page->id_de->viewAttributes() ?>>
<?= $Page->id_de->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_para->Visible) { // id_para ?>
        <td <?= $Page->id_para->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensagens_id_para" class="mensagens_id_para">
<span<?= $Page->id_para->viewAttributes() ?>>
<?= $Page->id_para->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mensagem->Visible) { // mensagem ?>
        <td <?= $Page->mensagem->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensagens_mensagem" class="mensagens_mensagem">
<span<?= $Page->mensagem->viewAttributes() ?>>
<?= $Page->mensagem->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
        <td <?= $Page->time->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensagens_time" class="mensagens_time">
<span<?= $Page->time->viewAttributes() ?>>
<?= $Page->time->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lido->Visible) { // lido ?>
        <td <?= $Page->lido->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensagens_lido" class="mensagens_lido">
<span<?= $Page->lido->viewAttributes() ?>>
<?= $Page->lido->getViewValue() ?></span>
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
