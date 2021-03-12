<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ParticipantesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fparticipantesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fparticipantesdelete = currentForm = new ew.Form("fparticipantesdelete", "delete");
    loadjs.done("fparticipantesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.participantes) ew.vars.tables.participantes = <?= JsonEncode(GetClientVar("tables", "participantes")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fparticipantesdelete" id="fparticipantesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="participantes">
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
<?php if ($Page->id_participantes->Visible) { // id_participantes ?>
        <th class="<?= $Page->id_participantes->headerCellClass() ?>"><span id="elh_participantes_id_participantes" class="participantes_id_participantes"><?= $Page->id_participantes->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <th class="<?= $Page->nombres->headerCellClass() ?>"><span id="elh_participantes_nombres" class="participantes_nombres"><?= $Page->nombres->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <th class="<?= $Page->apellidos->headerCellClass() ?>"><span id="elh_participantes_apellidos" class="participantes_apellidos"><?= $Page->apellidos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
        <th class="<?= $Page->_login->headerCellClass() ?>"><span id="elh_participantes__login" class="participantes__login"><?= $Page->_login->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><span id="elh_participantes__password" class="participantes__password"><?= $Page->_password->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_participantes__email" class="participantes__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <th class="<?= $Page->grupo->headerCellClass() ?>"><span id="elh_participantes_grupo" class="participantes_grupo"><?= $Page->grupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <th class="<?= $Page->subgrupo->headerCellClass() ?>"><span id="elh_participantes_subgrupo" class="participantes_subgrupo"><?= $Page->subgrupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imagen_participante->Visible) { // imagen_participante ?>
        <th class="<?= $Page->imagen_participante->headerCellClass() ?>"><span id="elh_participantes_imagen_participante" class="participantes_imagen_participante"><?= $Page->imagen_participante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <th class="<?= $Page->id_escenario->headerCellClass() ?>"><span id="elh_participantes_id_escenario" class="participantes_id_escenario"><?= $Page->id_escenario->caption() ?></span></th>
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
<?php if ($Page->id_participantes->Visible) { // id_participantes ?>
        <td <?= $Page->id_participantes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_id_participantes" class="participantes_id_participantes">
<span<?= $Page->id_participantes->viewAttributes() ?>>
<?= $Page->id_participantes->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <td <?= $Page->nombres->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_nombres" class="participantes_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <td <?= $Page->apellidos->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_apellidos" class="participantes_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
        <td <?= $Page->_login->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes__login" class="participantes__login">
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <td <?= $Page->_password->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes__password" class="participantes__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td <?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes__email" class="participantes__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <td <?= $Page->grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_grupo" class="participantes_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <td <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_subgrupo" class="participantes_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imagen_participante->Visible) { // imagen_participante ?>
        <td <?= $Page->imagen_participante->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_imagen_participante" class="participantes_imagen_participante">
<span<?= $Page->imagen_participante->viewAttributes() ?>>
<?= $Page->imagen_participante->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <td <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_id_escenario" class="participantes_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
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
