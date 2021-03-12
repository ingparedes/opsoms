<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PaisgmtList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpaisgmtlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpaisgmtlist = currentForm = new ew.Form("fpaisgmtlist", "list");
    fpaisgmtlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpaisgmtlist");
});
var fpaisgmtlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fpaisgmtlistsrch = currentSearchForm = new ew.Form("fpaisgmtlistsrch");

    // Dynamic selection lists

    // Filters
    fpaisgmtlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpaisgmtlistsrch");
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
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fpaisgmtlistsrch" id="fpaisgmtlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fpaisgmtlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="paisgmt">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> paisgmt">
<form name="fpaisgmtlist" id="fpaisgmtlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="paisgmt">
<div id="gmp_paisgmt" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_paisgmtlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_zone->Visible) { // id_zone ?>
        <th data-name="id_zone" class="<?= $Page->id_zone->headerCellClass() ?>"><div id="elh_paisgmt_id_zone" class="paisgmt_id_zone"><?= $Page->renderSort($Page->id_zone) ?></div></th>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
        <th data-name="codpais" class="<?= $Page->codpais->headerCellClass() ?>"><div id="elh_paisgmt_codpais" class="paisgmt_codpais"><?= $Page->renderSort($Page->codpais) ?></div></th>
<?php } ?>
<?php if ($Page->nompais->Visible) { // nompais ?>
        <th data-name="nompais" class="<?= $Page->nompais->headerCellClass() ?>"><div id="elh_paisgmt_nompais" class="paisgmt_nompais"><?= $Page->renderSort($Page->nompais) ?></div></th>
<?php } ?>
<?php if ($Page->timezone->Visible) { // timezone ?>
        <th data-name="timezone" class="<?= $Page->timezone->headerCellClass() ?>"><div id="elh_paisgmt_timezone" class="paisgmt_timezone"><?= $Page->renderSort($Page->timezone) ?></div></th>
<?php } ?>
<?php if ($Page->gmt->Visible) { // gmt ?>
        <th data-name="gmt" class="<?= $Page->gmt->headerCellClass() ?>"><div id="elh_paisgmt_gmt" class="paisgmt_gmt"><?= $Page->renderSort($Page->gmt) ?></div></th>
<?php } ?>
<?php if ($Page->codiso3->Visible) { // codiso3 ?>
        <th data-name="codiso3" class="<?= $Page->codiso3->headerCellClass() ?>"><div id="elh_paisgmt_codiso3" class="paisgmt_codiso3"><?= $Page->renderSort($Page->codiso3) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_paisgmt", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_zone->Visible) { // id_zone ?>
        <td data-name="id_zone" <?= $Page->id_zone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_id_zone">
<span<?= $Page->id_zone->viewAttributes() ?>>
<?= $Page->id_zone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codpais->Visible) { // codpais ?>
        <td data-name="codpais" <?= $Page->codpais->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_codpais">
<span<?= $Page->codpais->viewAttributes() ?>>
<?= $Page->codpais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nompais->Visible) { // nompais ?>
        <td data-name="nompais" <?= $Page->nompais->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_nompais">
<span<?= $Page->nompais->viewAttributes() ?>>
<?= $Page->nompais->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->timezone->Visible) { // timezone ?>
        <td data-name="timezone" <?= $Page->timezone->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_timezone">
<span<?= $Page->timezone->viewAttributes() ?>>
<?= $Page->timezone->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gmt->Visible) { // gmt ?>
        <td data-name="gmt" <?= $Page->gmt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_gmt">
<span<?= $Page->gmt->viewAttributes() ?>>
<?= $Page->gmt->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codiso3->Visible) { // codiso3 ?>
        <td data-name="codiso3" <?= $Page->codiso3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_paisgmt_codiso3">
<span<?= $Page->codiso3->viewAttributes() ?>>
<?= $Page->codiso3->getViewValue() ?></span>
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
    ew.addEventHandlers("paisgmt");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
