<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensagensView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmensagensview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmensagensview = currentForm = new ew.Form("fmensagensview", "view");
    loadjs.done("fmensagensview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.mensagens) ew.vars.tables.mensagens = <?= JsonEncode(GetClientVar("tables", "mensagens")) ?>;
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
<form name="fmensagensview" id="fmensagensview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensagens">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensagens_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_mensagens_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_de->Visible) { // id_de ?>
    <tr id="r_id_de">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensagens_id_de"><?= $Page->id_de->caption() ?></span></td>
        <td data-name="id_de" <?= $Page->id_de->cellAttributes() ?>>
<span id="el_mensagens_id_de">
<span<?= $Page->id_de->viewAttributes() ?>>
<?= $Page->id_de->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_para->Visible) { // id_para ?>
    <tr id="r_id_para">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensagens_id_para"><?= $Page->id_para->caption() ?></span></td>
        <td data-name="id_para" <?= $Page->id_para->cellAttributes() ?>>
<span id="el_mensagens_id_para">
<span<?= $Page->id_para->viewAttributes() ?>>
<?= $Page->id_para->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mensagem->Visible) { // mensagem ?>
    <tr id="r_mensagem">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensagens_mensagem"><?= $Page->mensagem->caption() ?></span></td>
        <td data-name="mensagem" <?= $Page->mensagem->cellAttributes() ?>>
<span id="el_mensagens_mensagem">
<span<?= $Page->mensagem->viewAttributes() ?>>
<?= $Page->mensagem->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
    <tr id="r_time">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensagens_time"><?= $Page->time->caption() ?></span></td>
        <td data-name="time" <?= $Page->time->cellAttributes() ?>>
<span id="el_mensagens_time">
<span<?= $Page->time->viewAttributes() ?>>
<?= $Page->time->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lido->Visible) { // lido ?>
    <tr id="r_lido">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensagens_lido"><?= $Page->lido->caption() ?></span></td>
        <td data-name="lido" <?= $Page->lido->cellAttributes() ?>>
<span id="el_mensagens_lido">
<span<?= $Page->lido->viewAttributes() ?>>
<?= $Page->lido->getViewValue() ?></span>
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
