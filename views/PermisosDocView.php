<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpermisos_docview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpermisos_docview = currentForm = new ew.Form("fpermisos_docview", "view");
    loadjs.done("fpermisos_docview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.permisos_doc) ew.vars.tables.permisos_doc = <?= JsonEncode(GetClientVar("tables", "permisos_doc")) ?>;
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
<form name="fpermisos_docview" id="fpermisos_docview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_doc">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_permiso->Visible) { // id_permiso ?>
    <tr id="r_id_permiso">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_doc_id_permiso"><?= $Page->id_permiso->caption() ?></span></td>
        <td data-name="id_permiso" <?= $Page->id_permiso->cellAttributes() ?>>
<span id="el_permisos_doc_id_permiso">
<span<?= $Page->id_permiso->viewAttributes() ?>>
<?= $Page->id_permiso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
    <tr id="r_id_file">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_doc_id_file"><?= $Page->id_file->caption() ?></span></td>
        <td data-name="id_file" <?= $Page->id_file->cellAttributes() ?>>
<span id="el_permisos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <tr id="r_tipo_permiso">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_doc_tipo_permiso"><?= $Page->tipo_permiso->caption() ?></span></td>
        <td data-name="tipo_permiso" <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el_permisos_doc_tipo_permiso">
<span<?= $Page->tipo_permiso->viewAttributes() ?>>
<?= $Page->tipo_permiso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
    <tr id="r_fecha_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_doc_fecha_created"><?= $Page->fecha_created->caption() ?></span></td>
        <td data-name="fecha_created" <?= $Page->fecha_created->cellAttributes() ?>>
<span id="el_permisos_doc_fecha_created">
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
    <tr id="r_id_usuarios">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_permisos_doc_id_usuarios"><?= $Page->id_usuarios->caption() ?></span></td>
        <td data-name="id_usuarios" <?= $Page->id_usuarios->cellAttributes() ?>>
<span id="el_permisos_doc_id_usuarios">
<span<?= $Page->id_usuarios->viewAttributes() ?>>
<?= $Page->id_usuarios->getViewValue() ?></span>
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
