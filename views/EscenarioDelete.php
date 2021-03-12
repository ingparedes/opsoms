<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EscenarioDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fescenariodelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fescenariodelete = currentForm = new ew.Form("fescenariodelete", "delete");
    loadjs.done("fescenariodelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.escenario) ew.vars.tables.escenario = <?= JsonEncode(GetClientVar("tables", "escenario")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fescenariodelete" id="fescenariodelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="escenario">
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
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <th class="<?= $Page->id_escenario->headerCellClass() ?>"><span id="elh_escenario_id_escenario" class="escenario_id_escenario"><?= $Page->id_escenario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
        <th class="<?= $Page->icon_escenario->headerCellClass() ?>"><span id="elh_escenario_icon_escenario" class="escenario_icon_escenario"><?= $Page->icon_escenario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <th class="<?= $Page->fechacreacion_escenario->headerCellClass() ?>"><span id="elh_escenario_fechacreacion_escenario" class="escenario_fechacreacion_escenario"><?= $Page->fechacreacion_escenario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
        <th class="<?= $Page->nombre_escenario->headerCellClass() ?>"><span id="elh_escenario_nombre_escenario" class="escenario_nombre_escenario"><?= $Page->nombre_escenario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
        <th class="<?= $Page->incidente->headerCellClass() ?>"><span id="elh_escenario_incidente" class="escenario_incidente"><?= $Page->incidente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
        <th class="<?= $Page->pais_escenario->headerCellClass() ?>"><span id="elh_escenario_pais_escenario" class="escenario_pais_escenario"><?= $Page->pais_escenario->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <th class="<?= $Page->fechaini_simulado->headerCellClass() ?>"><span id="elh_escenario_fechaini_simulado" class="escenario_fechaini_simulado"><?= $Page->fechaini_simulado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
        <th class="<?= $Page->fechaini_real->headerCellClass() ?>"><span id="elh_escenario_fechaini_real" class="escenario_fechaini_real"><?= $Page->fechaini_real->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_escenario_estado" class="escenario_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->entrar->Visible) { // entrar ?>
        <th class="<?= $Page->entrar->headerCellClass() ?>"><span id="elh_escenario_entrar" class="escenario_entrar"><?= $Page->entrar->caption() ?></span></th>
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
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <td <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_id_escenario" class="escenario_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
        <td <?= $Page->icon_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_icon_escenario" class="escenario_icon_escenario">
<span><?php
$idm = CurrentPage()->icon_escenario->CurrentValue;
echo "<img width='25px' src='$idm'>";
?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <td <?= $Page->fechacreacion_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechacreacion_escenario" class="escenario_fechacreacion_escenario">
<span<?= $Page->fechacreacion_escenario->viewAttributes() ?>>
<?= $Page->fechacreacion_escenario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
        <td <?= $Page->nombre_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_nombre_escenario" class="escenario_nombre_escenario">
<span<?= $Page->nombre_escenario->viewAttributes() ?>>
<?= $Page->nombre_escenario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
        <td <?= $Page->incidente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_incidente" class="escenario_incidente">
<span<?= $Page->incidente->viewAttributes() ?>>
<?= $Page->incidente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
        <td <?= $Page->pais_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_pais_escenario" class="escenario_pais_escenario">
<span<?= $Page->pais_escenario->viewAttributes() ?>>
<?= $Page->pais_escenario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <td <?= $Page->fechaini_simulado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechaini_simulado" class="escenario_fechaini_simulado">
<span<?= $Page->fechaini_simulado->viewAttributes() ?>>
<?= $Page->fechaini_simulado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
        <td <?= $Page->fechaini_real->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechaini_real" class="escenario_fechaini_real">
<span<?= $Page->fechaini_real->viewAttributes() ?>>
<?= $Page->fechaini_real->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <td <?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_estado" class="escenario_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->entrar->Visible) { // entrar ?>
        <td <?= $Page->entrar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_entrar" class="escenario_entrar">
<span<?= $Page->entrar->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->entrar->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"GrupoList?showmaster=escenario&fk_id_escenario=$id&showdetail=\" data-original-title=\"Grupo\"><i class=\"fa fa-user-plus\"data-caption=\"Grupo\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"TareasList?showmaster=escenario&fk_id_escenario=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
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
