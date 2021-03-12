<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmensajeslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fmensajeslist = currentForm = new ew.Form("fmensajeslist", "list");
    fmensajeslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fmensajeslist");
});
var fmensajeslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fmensajeslistsrch = currentSearchForm = new ew.Form("fmensajeslistsrch");

    // Dynamic selection lists

    // Filters
    fmensajeslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmensajeslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #6495ED; /* preview row color */
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
    ew.PREVIEW_SINGLE_ROW = true;
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "tareas") {
    if ($Page->MasterRecordExists) {
        include_once "views/TareasMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fmensajeslistsrch" id="fmensajeslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fmensajeslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="mensajes">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> mensajes">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fmensajeslist" id="fmensajeslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes">
<?php if ($Page->getCurrentMasterTable() == "tareas" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="tareas">
<input type="hidden" name="fk_id_tarea" value="<?= HtmlEncode($Page->id_tareas->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_mensajes" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_mensajeslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <th data-name="id_inyect" class="<?= $Page->id_inyect->headerCellClass() ?>"><div id="elh_mensajes_id_inyect" class="mensajes_id_inyect"><?= $Page->renderSort($Page->id_inyect) ?></div></th>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <th data-name="titulo" class="<?= $Page->titulo->headerCellClass() ?>"><div id="elh_mensajes_titulo" class="mensajes_titulo"><?= $Page->renderSort($Page->titulo) ?></div></th>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <th data-name="mensaje" class="<?= $Page->mensaje->headerCellClass() ?>"><div id="elh_mensajes_mensaje" class="mensajes_mensaje"><?= $Page->renderSort($Page->mensaje) ?></div></th>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
        <th data-name="fechareal_start" class="<?= $Page->fechareal_start->headerCellClass() ?>"><div id="elh_mensajes_fechareal_start" class="mensajes_fechareal_start"><?= $Page->renderSort($Page->fechareal_start) ?></div></th>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
        <th data-name="fechasim_start" class="<?= $Page->fechasim_start->headerCellClass() ?>"><div id="elh_mensajes_fechasim_start" class="mensajes_fechasim_start"><?= $Page->renderSort($Page->fechasim_start) ?></div></th>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
        <th data-name="id_actor" class="<?= $Page->id_actor->headerCellClass() ?>"><div id="elh_mensajes_id_actor" class="mensajes_id_actor"><?= $Page->renderSort($Page->id_actor) ?></div></th>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
        <th data-name="para" class="<?= $Page->para->headerCellClass() ?>"><div id="elh_mensajes_para" class="mensajes_para"><?= $Page->renderSort($Page->para) ?></div></th>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
        <th data-name="adjunto" class="<?= $Page->adjunto->headerCellClass() ?>"><div id="elh_mensajes_adjunto" class="mensajes_adjunto"><?= $Page->renderSort($Page->adjunto) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_mensajes", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <td data-name="id_inyect" <?= $Page->id_inyect->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titulo->Visible) { // titulo ?>
        <td data-name="titulo" <?= $Page->titulo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?php if (!EmptyString($Page->titulo->TooltipValue) && $Page->titulo->linkAttributes() != "") { ?>
<a<?= $Page->titulo->linkAttributes() ?>><?= $Page->titulo->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->titulo->getViewValue() ?>
<?php } ?>
<span id="tt_mensajes_x<?= $Page->RowCount ?>_titulo" class="d-none">
<?= $Page->titulo->TooltipValue ?>
</span></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mensaje->Visible) { // mensaje ?>
        <td data-name="mensaje" <?= $Page->mensaje->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
        <td data-name="fechareal_start" <?= $Page->fechareal_start->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_fechareal_start">
<span<?= $Page->fechareal_start->viewAttributes() ?>>
<?= $Page->fechareal_start->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
        <td data-name="fechasim_start" <?= $Page->fechasim_start->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_fechasim_start">
<span<?= $Page->fechasim_start->viewAttributes() ?>>
<?= $Page->fechasim_start->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_actor->Visible) { // id_actor ?>
        <td data-name="id_actor" <?= $Page->id_actor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_id_actor">
<span<?= $Page->id_actor->viewAttributes() ?>>
<?= $Page->id_actor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->para->Visible) { // para ?>
        <td data-name="para" <?= $Page->para->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_para">
<span<?= $Page->para->viewAttributes() ?>>
<?= $Page->para->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->adjunto->Visible) { // adjunto ?>
        <td data-name="adjunto" <?= $Page->adjunto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mensajes_adjunto">
<span<?= $Page->adjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->adjunto, $Page->adjunto->getViewValue(), false) ?>
</span>
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
    ew.addEventHandlers("mensajes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
