<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArchivosDocView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var farchivos_docview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    farchivos_docview = currentForm = new ew.Form("farchivos_docview", "view");
    loadjs.done("farchivos_docview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.archivos_doc) ew.vars.tables.archivos_doc = <?= JsonEncode(GetClientVar("tables", "archivos_doc")) ?>;
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
<form name="farchivos_docview" id="farchivos_docview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="archivos_doc">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_file->Visible) { // id_file ?>
    <tr id="r_id_file">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_id_file"><?= $Page->id_file->caption() ?></span></td>
        <td data-name="id_file" <?= $Page->id_file->cellAttributes() ?>>
<span id="el_archivos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_users->Visible) { // id_users ?>
    <tr id="r_id_users">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_id_users"><?= $Page->id_users->caption() ?></span></td>
        <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<span id="el_archivos_doc_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file_name->Visible) { // file_name ?>
    <tr id="r_file_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_file_name"><?= $Page->file_name->caption() ?></span></td>
        <td data-name="file_name" <?= $Page->file_name->cellAttributes() ?>>
<span id="el_archivos_doc_file_name">
<span<?= $Page->file_name->viewAttributes() ?>>
<?= GetFileViewTag($Page->file_name, $Page->file_name->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
    <tr id="r_fecha_created">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_archivos_doc_fecha_created"><?= $Page->fecha_created->caption() ?></span></td>
        <td data-name="fecha_created" <?= $Page->fecha_created->cellAttributes() ?>>
<span id="el_archivos_doc_fecha_created">
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("permisos_doc", explode(",", $Page->getCurrentDetailTable())) && $permisos_doc->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("permisos_doc", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PermisosDocGrid.php" ?>
<?php } ?>
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
