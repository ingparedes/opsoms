<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UsersDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fusersdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fusersdelete = currentForm = new ew.Form("fusersdelete", "delete");
    loadjs.done("fusersdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.users) ew.vars.tables.users = <?= JsonEncode(GetClientVar("tables", "users")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fusersdelete" id="fusersdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
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
<?php if ($Page->id_users->Visible) { // id_users ?>
        <th class="<?= $Page->id_users->headerCellClass() ?>"><span id="elh_users_id_users" class="users_id_users"><?= $Page->id_users->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_users_fecha" class="users_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <th class="<?= $Page->nombres->headerCellClass() ?>"><span id="elh_users_nombres" class="users_nombres"><?= $Page->nombres->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <th class="<?= $Page->apellidos->headerCellClass() ?>"><span id="elh_users_apellidos" class="users_apellidos"><?= $Page->apellidos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <th class="<?= $Page->grupo->headerCellClass() ?>"><span id="elh_users_grupo" class="users_grupo"><?= $Page->grupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <th class="<?= $Page->subgrupo->headerCellClass() ?>"><span id="elh_users_subgrupo" class="users_subgrupo"><?= $Page->subgrupo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
        <th class="<?= $Page->perfil->headerCellClass() ?>"><span id="elh_users_perfil" class="users_perfil"><?= $Page->perfil->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_users__email" class="users__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
        <th class="<?= $Page->telefono->headerCellClass() ?>"><span id="elh_users_telefono" class="users_telefono"><?= $Page->telefono->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
        <th class="<?= $Page->pais->headerCellClass() ?>"><span id="elh_users_pais" class="users_pais"><?= $Page->pais->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th class="<?= $Page->estado->headerCellClass() ?>"><span id="elh_users_estado" class="users_estado"><?= $Page->estado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
        <th class="<?= $Page->img_user->headerCellClass() ?>"><span id="elh_users_img_user" class="users_img_user"><?= $Page->img_user->caption() ?></span></th>
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
<?php if ($Page->id_users->Visible) { // id_users ?>
        <td <?= $Page->id_users->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_id_users" class="users_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <td <?= $Page->fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_fecha" class="users_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <td <?= $Page->nombres->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_nombres" class="users_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <td <?= $Page->apellidos->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_apellidos" class="users_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <td <?= $Page->grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_grupo" class="users_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <td <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_subgrupo" class="users_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
        <td <?= $Page->perfil->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_perfil" class="users_perfil">
<span<?= $Page->perfil->viewAttributes() ?>>
<?= $Page->perfil->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td <?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users__email" class="users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
        <td <?= $Page->telefono->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_telefono" class="users_telefono">
<span<?= $Page->telefono->viewAttributes() ?>>
<?= $Page->telefono->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
        <td <?= $Page->pais->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_pais" class="users_pais">
<span<?= $Page->pais->viewAttributes() ?>>
<?= $Page->pais->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <td <?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_estado" class="users_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
        <td <?= $Page->img_user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_users_img_user" class="users_img_user">
<span>
<?= GetFileViewTag($Page->img_user, $Page->img_user->getViewValue(), false) ?>
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
