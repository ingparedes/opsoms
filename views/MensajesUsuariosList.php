<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesUsuariosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmensajes_usuarioslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmensajes_usuarioslist = currentForm = new ew.Form("fmensajes_usuarioslist", "list");
    fmensajes_usuarioslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fmensajes_usuarioslist");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> mensajes_usuarios">
<form name="fmensajes_usuarioslist" id="fmensajes_usuarioslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes_usuarios">
<div id="gmp_mensajes_usuarios" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_mensajes_usuarioslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_mensaje_usuario->Visible) { // id_mensaje_usuario ?>
        <th data-name="id_mensaje_usuario" class="<?= $Page->id_mensaje_usuario->headerCellClass() ?>"><div id="elh_mensajes_usuarios_id_mensaje_usuario" class="mensajes_usuarios_id_mensaje_usuario"><?= $Page->renderSort($Page->id_mensaje_usuario) ?></div></th>
<?php } ?>
<?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
        <th data-name="id_user_remitente" class="<?= $Page->id_user_remitente->headerCellClass() ?>"><div id="elh_mensajes_usuarios_id_user_remitente" class="mensajes_usuarios_id_user_remitente"><?= $Page->renderSort($Page->id_user_remitente) ?></div></th>
<?php } ?>
<?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
        <th data-name="id_user_destinatario" class="<?= $Page->id_user_destinatario->headerCellClass() ?>"><div id="elh_mensajes_usuarios_id_user_destinatario" class="mensajes_usuarios_id_user_destinatario"><?= $Page->renderSort($Page->id_user_destinatario) ?></div></th>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
        <th data-name="id_mensaje" class="<?= $Page->id_mensaje->headerCellClass() ?>"><div id="elh_mensajes_usuarios_id_mensaje" class="mensajes_usuarios_id_mensaje"><?= $Page->renderSort($Page->id_mensaje) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_mensajes_usuarios", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_mensaje_usuario->Visible) { // id_mensaje_usuario ?>
        <td data-name="id_mensaje_usuario" <?= $Page->id_mensaje_usuario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_usuarios_id_mensaje_usuario">
<span<?= $Page->id_mensaje_usuario->viewAttributes() ?>>
<?= $Page->id_mensaje_usuario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
        <td data-name="id_user_remitente" <?= $Page->id_user_remitente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_usuarios_id_user_remitente">
<span<?= $Page->id_user_remitente->viewAttributes() ?>>
<?= $Page->id_user_remitente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
        <td data-name="id_user_destinatario" <?= $Page->id_user_destinatario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_usuarios_id_user_destinatario">
<span<?= $Page->id_user_destinatario->viewAttributes() ?>>
<?= $Page->id_user_destinatario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
        <td data-name="id_mensaje" <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_usuarios_id_mensaje">
<span<?= $Page->id_mensaje->viewAttributes() ?>>
<?= $Page->id_mensaje->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("mensajes_usuarios");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
