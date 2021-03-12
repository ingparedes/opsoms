<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpermisos_docdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpermisos_docdelete = currentForm = new ew.Form("fpermisos_docdelete", "delete");
    loadjs.done("fpermisos_docdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.permisos_doc) ew.vars.tables.permisos_doc = <?= JsonEncode(GetClientVar("tables", "permisos_doc")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpermisos_docdelete" id="fpermisos_docdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_doc">
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
<?php if ($Page->id_permiso->Visible) { // id_permiso ?>
        <th class="<?= $Page->id_permiso->headerCellClass() ?>"><span id="elh_permisos_doc_id_permiso" class="permisos_doc_id_permiso"><?= $Page->id_permiso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
        <th class="<?= $Page->id_file->headerCellClass() ?>"><span id="elh_permisos_doc_id_file" class="permisos_doc_id_file"><?= $Page->id_file->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <th class="<?= $Page->tipo_permiso->headerCellClass() ?>"><span id="elh_permisos_doc_tipo_permiso" class="permisos_doc_tipo_permiso"><?= $Page->tipo_permiso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <th class="<?= $Page->fecha_created->headerCellClass() ?>"><span id="elh_permisos_doc_fecha_created" class="permisos_doc_fecha_created"><?= $Page->fecha_created->caption() ?></span></th>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
        <th class="<?= $Page->id_usuarios->headerCellClass() ?>"><span id="elh_permisos_doc_id_usuarios" class="permisos_doc_id_usuarios"><?= $Page->id_usuarios->caption() ?></span></th>
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
<?php if ($Page->id_permiso->Visible) { // id_permiso ?>
        <td <?= $Page->id_permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_id_permiso" class="permisos_doc_id_permiso">
<span<?= $Page->id_permiso->viewAttributes() ?>>
<?= $Page->id_permiso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
        <td <?= $Page->id_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_id_file" class="permisos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <td <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_tipo_permiso" class="permisos_doc_tipo_permiso">
<span<?= $Page->tipo_permiso->viewAttributes() ?>>
<?= $Page->tipo_permiso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <td <?= $Page->fecha_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_fecha_created" class="permisos_doc_fecha_created">
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
        <td <?= $Page->id_usuarios->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_id_usuarios" class="permisos_doc_id_usuarios">
<span<?= $Page->id_usuarios->viewAttributes() ?>>
<?= $Page->id_usuarios->getViewValue() ?></span>
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
