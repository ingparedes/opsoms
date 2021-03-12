<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpermisos_doclist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpermisos_doclist = currentForm = new ew.Form("fpermisos_doclist", "list");
    fpermisos_doclist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpermisos_doclist");
});
var fpermisos_doclistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fpermisos_doclistsrch = currentSearchForm = new ew.Form("fpermisos_doclistsrch");

    // Dynamic selection lists

    // Filters
    fpermisos_doclistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpermisos_doclistsrch");
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "archivos_doc") {
    if ($Page->MasterRecordExists) {
        include_once "views/ArchivosDocMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fpermisos_doclistsrch" id="fpermisos_doclistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fpermisos_doclistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="permisos_doc">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> permisos_doc">
<form name="fpermisos_doclist" id="fpermisos_doclist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_doc">
<?php if ($Page->getCurrentMasterTable() == "archivos_doc" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="archivos_doc">
<input type="hidden" name="fk_id_file" value="<?= HtmlEncode($Page->id_file->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_permisos_doc" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_permisos_doclist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_permiso->Visible) { // id_permiso ?>
        <th data-name="id_permiso" class="<?= $Page->id_permiso->headerCellClass() ?>"><div id="elh_permisos_doc_id_permiso" class="permisos_doc_id_permiso"><?= $Page->renderSort($Page->id_permiso) ?></div></th>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
        <th data-name="id_file" class="<?= $Page->id_file->headerCellClass() ?>"><div id="elh_permisos_doc_id_file" class="permisos_doc_id_file"><?= $Page->renderSort($Page->id_file) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <th data-name="tipo_permiso" class="<?= $Page->tipo_permiso->headerCellClass() ?>"><div id="elh_permisos_doc_tipo_permiso" class="permisos_doc_tipo_permiso"><?= $Page->renderSort($Page->tipo_permiso) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <th data-name="fecha_created" class="<?= $Page->fecha_created->headerCellClass() ?>"><div id="elh_permisos_doc_fecha_created" class="permisos_doc_fecha_created"><?= $Page->renderSort($Page->fecha_created) ?></div></th>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
        <th data-name="id_usuarios" class="<?= $Page->id_usuarios->headerCellClass() ?>"><div id="elh_permisos_doc_id_usuarios" class="permisos_doc_id_usuarios"><?= $Page->renderSort($Page->id_usuarios) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_permisos_doc", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_permiso->Visible) { // id_permiso ?>
        <td data-name="id_permiso" <?= $Page->id_permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_id_permiso">
<span<?= $Page->id_permiso->viewAttributes() ?>>
<?= $Page->id_permiso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_file->Visible) { // id_file ?>
        <td data-name="id_file" <?= $Page->id_file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <td data-name="tipo_permiso" <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_tipo_permiso">
<span<?= $Page->tipo_permiso->viewAttributes() ?>>
<?= $Page->tipo_permiso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <td data-name="fecha_created" <?= $Page->fecha_created->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_fecha_created">
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
        <td data-name="id_usuarios" <?= $Page->id_usuarios->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_permisos_doc_id_usuarios">
<span<?= $Page->id_usuarios->viewAttributes() ?>>
<?= $Page->id_usuarios->getViewValue() ?></span>
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
    ew.addEventHandlers("permisos_doc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
