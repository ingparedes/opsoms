<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftareasdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ftareasdelete = currentForm = new ew.Form("ftareasdelete", "delete");
    loadjs.done("ftareasdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.tareas) ew.vars.tables.tareas = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftareasdelete" id="ftareasdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tareas">
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
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
        <th class="<?= $Page->id_tarea->headerCellClass() ?>"><span id="elh_tareas_id_tarea" class="tareas_id_tarea"><?= $Page->id_tarea->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <th class="<?= $Page->id_grupo->headerCellClass() ?>"><span id="elh_tareas_id_grupo" class="tareas_id_grupo"><?= $Page->id_grupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
        <th class="<?= $Page->titulo_tarea->headerCellClass() ?>"><span id="elh_tareas_titulo_tarea" class="tareas_titulo_tarea"><?= $Page->titulo_tarea->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <th class="<?= $Page->fechainireal_tarea->headerCellClass() ?>"><span id="elh_tareas_fechainireal_tarea" class="tareas_fechainireal_tarea"><?= $Page->fechainireal_tarea->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <th class="<?= $Page->fechafin_tarea->headerCellClass() ?>"><span id="elh_tareas_fechafin_tarea" class="tareas_fechafin_tarea"><?= $Page->fechafin_tarea->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <th class="<?= $Page->fechainisimulado_tarea->headerCellClass() ?>"><span id="elh_tareas_fechainisimulado_tarea" class="tareas_fechainisimulado_tarea"><?= $Page->fechainisimulado_tarea->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <th class="<?= $Page->fechafinsimulado_tarea->headerCellClass() ?>"><span id="elh_tareas_fechafinsimulado_tarea" class="tareas_fechafinsimulado_tarea"><?= $Page->fechafinsimulado_tarea->caption() ?></span></th>
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
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
        <td <?= $Page->id_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_id_tarea" class="tareas_id_tarea">
<span<?= $Page->id_tarea->viewAttributes() ?>>
<?= $Page->id_tarea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <td <?= $Page->id_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_id_grupo" class="tareas_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
        <td <?= $Page->titulo_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_titulo_tarea" class="tareas_titulo_tarea">
<span<?= $Page->titulo_tarea->viewAttributes() ?>>
<?= $Page->titulo_tarea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <td <?= $Page->fechainireal_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechainireal_tarea" class="tareas_fechainireal_tarea">
<span<?= $Page->fechainireal_tarea->viewAttributes() ?>>
<?= $Page->fechainireal_tarea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <td <?= $Page->fechafin_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechafin_tarea" class="tareas_fechafin_tarea">
<span<?= $Page->fechafin_tarea->viewAttributes() ?>>
<?= $Page->fechafin_tarea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <td <?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechainisimulado_tarea" class="tareas_fechainisimulado_tarea">
<span<?= $Page->fechainisimulado_tarea->viewAttributes() ?>>
<?= $Page->fechainisimulado_tarea->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <td <?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechafinsimulado_tarea" class="tareas_fechafinsimulado_tarea">
<span<?= $Page->fechafinsimulado_tarea->viewAttributes() ?>>
<?= $Page->fechafinsimulado_tarea->getViewValue() ?></span>
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
