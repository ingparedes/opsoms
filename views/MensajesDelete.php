<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmensajesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmensajesdelete = currentForm = new ew.Form("fmensajesdelete", "delete");
    loadjs.done("fmensajesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.mensajes) ew.vars.tables.mensajes = <?= JsonEncode(GetClientVar("tables", "mensajes")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmensajesdelete" id="fmensajesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes">
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
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <th class="<?= $Page->id_inyect->headerCellClass() ?>"><span id="elh_mensajes_id_inyect" class="mensajes_id_inyect"><?= $Page->id_inyect->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th class="<?= $Page->titulo->headerCellClass() ?>"><span id="elh_mensajes_titulo" class="mensajes_titulo"><?= $Page->titulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <th class="<?= $Page->mensaje->headerCellClass() ?>"><span id="elh_mensajes_mensaje" class="mensajes_mensaje"><?= $Page->mensaje->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
        <th class="<?= $Page->fechareal_start->headerCellClass() ?>"><span id="elh_mensajes_fechareal_start" class="mensajes_fechareal_start"><?= $Page->fechareal_start->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
        <th class="<?= $Page->fechasim_start->headerCellClass() ?>"><span id="elh_mensajes_fechasim_start" class="mensajes_fechasim_start"><?= $Page->fechasim_start->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
        <th class="<?= $Page->id_actor->headerCellClass() ?>"><span id="elh_mensajes_id_actor" class="mensajes_id_actor"><?= $Page->id_actor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
        <th class="<?= $Page->para->headerCellClass() ?>"><span id="elh_mensajes_para" class="mensajes_para"><?= $Page->para->caption() ?></span></th>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
        <th class="<?= $Page->adjunto->headerCellClass() ?>"><span id="elh_mensajes_adjunto" class="mensajes_adjunto"><?= $Page->adjunto->caption() ?></span></th>
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
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <td <?= $Page->id_inyect->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_id_inyect" class="mensajes_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <td <?= $Page->titulo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_titulo" class="mensajes_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?php if (!EmptyString($Page->titulo->TooltipValue) && $Page->titulo->linkAttributes() != "") { ?>
<a<?= $Page->titulo->linkAttributes() ?>><?= $Page->titulo->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->titulo->getViewValue() ?>
<?php } ?>
<span id="tt_mensajes_x_titulo" class="d-none">
<?= $Page->titulo->TooltipValue ?>
</span></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <td <?= $Page->mensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_mensaje" class="mensajes_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
        <td <?= $Page->fechareal_start->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_fechareal_start" class="mensajes_fechareal_start">
<span<?= $Page->fechareal_start->viewAttributes() ?>>
<?= $Page->fechareal_start->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
        <td <?= $Page->fechasim_start->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_fechasim_start" class="mensajes_fechasim_start">
<span<?= $Page->fechasim_start->viewAttributes() ?>>
<?= $Page->fechasim_start->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
        <td <?= $Page->id_actor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_id_actor" class="mensajes_id_actor">
<span<?= $Page->id_actor->viewAttributes() ?>>
<?= $Page->id_actor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
        <td <?= $Page->para->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_para" class="mensajes_para">
<span<?= $Page->para->viewAttributes() ?>>
<?= $Page->para->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
        <td <?= $Page->adjunto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_adjunto" class="mensajes_adjunto">
<span<?= $Page->adjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->adjunto, $Page->adjunto->getViewValue(), false) ?>
</span>
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
