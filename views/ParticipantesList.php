<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ParticipantesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fparticipanteslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fparticipanteslist = currentForm = new ew.Form("fparticipanteslist", "list");
    fparticipanteslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fparticipanteslist");
});
var fparticipanteslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fparticipanteslistsrch = currentSearchForm = new ew.Form("fparticipanteslistsrch");

    // Dynamic selection lists

    // Filters
    fparticipanteslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fparticipanteslistsrch");
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
<form name="fparticipanteslistsrch" id="fparticipanteslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fparticipanteslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="participantes">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> participantes">
<form name="fparticipanteslist" id="fparticipanteslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="participantes">
<div id="gmp_participantes" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_participanteslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_participantes->Visible) { // id_participantes ?>
        <th data-name="id_participantes" class="<?= $Page->id_participantes->headerCellClass() ?>"><div id="elh_participantes_id_participantes" class="participantes_id_participantes"><?= $Page->renderSort($Page->id_participantes) ?></div></th>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <th data-name="nombres" class="<?= $Page->nombres->headerCellClass() ?>"><div id="elh_participantes_nombres" class="participantes_nombres"><?= $Page->renderSort($Page->nombres) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <th data-name="apellidos" class="<?= $Page->apellidos->headerCellClass() ?>"><div id="elh_participantes_apellidos" class="participantes_apellidos"><?= $Page->renderSort($Page->apellidos) ?></div></th>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
        <th data-name="_login" class="<?= $Page->_login->headerCellClass() ?>"><div id="elh_participantes__login" class="participantes__login"><?= $Page->renderSort($Page->_login) ?></div></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th data-name="_password" class="<?= $Page->_password->headerCellClass() ?>"><div id="elh_participantes__password" class="participantes__password"><?= $Page->renderSort($Page->_password) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_participantes__email" class="participantes__email"><?= $Page->renderSort($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <th data-name="grupo" class="<?= $Page->grupo->headerCellClass() ?>"><div id="elh_participantes_grupo" class="participantes_grupo"><?= $Page->renderSort($Page->grupo) ?></div></th>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <th data-name="subgrupo" class="<?= $Page->subgrupo->headerCellClass() ?>"><div id="elh_participantes_subgrupo" class="participantes_subgrupo"><?= $Page->renderSort($Page->subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->imagen_participante->Visible) { // imagen_participante ?>
        <th data-name="imagen_participante" class="<?= $Page->imagen_participante->headerCellClass() ?>"><div id="elh_participantes_imagen_participante" class="participantes_imagen_participante"><?= $Page->renderSort($Page->imagen_participante) ?></div></th>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <th data-name="id_escenario" class="<?= $Page->id_escenario->headerCellClass() ?>"><div id="elh_participantes_id_escenario" class="participantes_id_escenario"><?= $Page->renderSort($Page->id_escenario) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_participantes", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_participantes->Visible) { // id_participantes ?>
        <td data-name="id_participantes" <?= $Page->id_participantes->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_id_participantes">
<span<?= $Page->id_participantes->viewAttributes() ?>>
<?= $Page->id_participantes->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombres->Visible) { // nombres ?>
        <td data-name="nombres" <?= $Page->nombres->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos->Visible) { // apellidos ?>
        <td data-name="apellidos" <?= $Page->apellidos->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_login->Visible) { // login ?>
        <td data-name="_login" <?= $Page->_login->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes__login">
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_password->Visible) { // password ?>
        <td data-name="_password" <?= $Page->_password->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->grupo->Visible) { // grupo ?>
        <td data-name="grupo" <?= $Page->grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <td data-name="subgrupo" <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->imagen_participante->Visible) { // imagen_participante ?>
        <td data-name="imagen_participante" <?= $Page->imagen_participante->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_imagen_participante">
<span<?= $Page->imagen_participante->viewAttributes() ?>>
<?= $Page->imagen_participante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_participantes_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
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
    ew.addEventHandlers("participantes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
