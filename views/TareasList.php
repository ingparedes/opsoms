<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftareaslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    ftareaslist = currentForm = new ew.Form("ftareaslist", "list");
    ftareaslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("ftareaslist");
});
var ftareaslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    ftareaslistsrch = currentSearchForm = new ew.Form("ftareaslistsrch");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>,
        fields = currentTable.fields;
    ftareaslistsrch.addFields([
        ["id_tarea", [], fields.id_tarea.isInvalid],
        ["id_grupo", [], fields.id_grupo.isInvalid],
        ["titulo_tarea", [], fields.titulo_tarea.isInvalid],
        ["fechainireal_tarea", [], fields.fechainireal_tarea.isInvalid],
        ["fechafin_tarea", [], fields.fechafin_tarea.isInvalid],
        ["fechainisimulado_tarea", [], fields.fechainisimulado_tarea.isInvalid],
        ["fechafinsimulado_tarea", [], fields.fechafinsimulado_tarea.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        ftareaslistsrch.setInvalid();
    });

    // Validate form
    ftareaslistsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    ftareaslistsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftareaslistsrch.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftareaslistsrch.lists.id_grupo = <?= $Page->id_grupo->toClientList($Page) ?>;

    // Filters
    ftareaslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ftareaslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #DCDCDC; /* preview row color */
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "escenario") {
    if ($Page->MasterRecordExists) {
        include_once "views/EscenarioMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="ftareaslistsrch" id="ftareaslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="ftareaslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tareas">
    <div class="ew-extended-search">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <?php
        $Page->SearchColumnCount++;
        if (($Page->SearchColumnCount - 1) % $Page->SearchFieldsPerRow == 0) {
            $Page->SearchRowCount++;
    ?>
<div id="xsr_<?= $Page->SearchRowCount ?>" class="ew-row d-sm-flex">
    <?php
        }
     ?>
    <div id="xsc_id_grupo" class="ew-cell form-group">
        <label for="x_id_grupo" class="ew-search-caption ew-label"><?= $Page->id_grupo->caption() ?></label>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id_grupo" id="z_id_grupo" value="=">
</span>
        <span id="el_tareas_id_grupo" class="ew-search-field">
    <select
        id="x_id_grupo"
        name="x_id_grupo"
        class="form-control ew-select<?= $Page->id_grupo->isInvalidClass() ?>"
        data-select2-id="tareas_x_id_grupo"
        data-table="tareas"
        data-field="x_id_grupo"
        data-value-separator="<?= $Page->id_grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_grupo->getPlaceHolder()) ?>"
        <?= $Page->id_grupo->editAttributes() ?>>
        <?= $Page->id_grupo->selectOptionListHtml("x_id_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->id_grupo->getErrorMessage(false) ?></div>
<?= $Page->id_grupo->Lookup->getParamTag($Page, "p_x_id_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='tareas_x_id_grupo']"),
        options = { name: "x_id_grupo", selectId: "tareas_x_id_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.tareas.fields.id_grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
    </div>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow == 0) { ?>
</div>
    <?php } ?>
<?php } ?>
    <?php if ($Page->SearchColumnCount % $Page->SearchFieldsPerRow > 0) { ?>
</div>
    <?php } ?>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tareas">
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
<form name="ftareaslist" id="ftareaslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tareas">
<?php if ($Page->getCurrentMasterTable() == "escenario" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="escenario">
<input type="hidden" name="fk_id_escenario" value="<?= HtmlEncode($Page->id_escenario->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_tareas" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_tareaslist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
        <th data-name="id_tarea" class="<?= $Page->id_tarea->headerCellClass() ?>"><div id="elh_tareas_id_tarea" class="tareas_id_tarea"><?= $Page->renderSort($Page->id_tarea) ?></div></th>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <th data-name="id_grupo" class="<?= $Page->id_grupo->headerCellClass() ?>"><div id="elh_tareas_id_grupo" class="tareas_id_grupo"><?= $Page->renderSort($Page->id_grupo) ?></div></th>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
        <th data-name="titulo_tarea" class="<?= $Page->titulo_tarea->headerCellClass() ?>"><div id="elh_tareas_titulo_tarea" class="tareas_titulo_tarea"><?= $Page->renderSort($Page->titulo_tarea) ?></div></th>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <th data-name="fechainireal_tarea" class="<?= $Page->fechainireal_tarea->headerCellClass() ?>"><div id="elh_tareas_fechainireal_tarea" class="tareas_fechainireal_tarea"><?= $Page->renderSort($Page->fechainireal_tarea) ?></div></th>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <th data-name="fechafin_tarea" class="<?= $Page->fechafin_tarea->headerCellClass() ?>"><div id="elh_tareas_fechafin_tarea" class="tareas_fechafin_tarea"><?= $Page->renderSort($Page->fechafin_tarea) ?></div></th>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <th data-name="fechainisimulado_tarea" class="<?= $Page->fechainisimulado_tarea->headerCellClass() ?>"><div id="elh_tareas_fechainisimulado_tarea" class="tareas_fechainisimulado_tarea"><?= $Page->renderSort($Page->fechainisimulado_tarea) ?></div></th>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <th data-name="fechafinsimulado_tarea" class="<?= $Page->fechafinsimulado_tarea->headerCellClass() ?>"><div id="elh_tareas_fechafinsimulado_tarea" class="tareas_fechafinsimulado_tarea"><?= $Page->renderSort($Page->fechafinsimulado_tarea) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_tareas", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_tarea->Visible) { // id_tarea ?>
        <td data-name="id_tarea" <?= $Page->id_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_id_tarea">
<span<?= $Page->id_tarea->viewAttributes() ?>>
<?= $Page->id_tarea->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo" <?= $Page->id_grupo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
        <td data-name="titulo_tarea" <?= $Page->titulo_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_titulo_tarea">
<span<?= $Page->titulo_tarea->viewAttributes() ?>>
<?= $Page->titulo_tarea->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <td data-name="fechainireal_tarea" <?= $Page->fechainireal_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechainireal_tarea">
<span<?= $Page->fechainireal_tarea->viewAttributes() ?>>
<?= $Page->fechainireal_tarea->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <td data-name="fechafin_tarea" <?= $Page->fechafin_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechafin_tarea">
<span<?= $Page->fechafin_tarea->viewAttributes() ?>>
<?= $Page->fechafin_tarea->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <td data-name="fechainisimulado_tarea" <?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechainisimulado_tarea">
<span<?= $Page->fechainisimulado_tarea->viewAttributes() ?>>
<?= $Page->fechainisimulado_tarea->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <td data-name="fechafinsimulado_tarea" <?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tareas_fechafinsimulado_tarea">
<span<?= $Page->fechafinsimulado_tarea->viewAttributes() ?>>
<?= $Page->fechafinsimulado_tarea->getViewValue() ?></span>
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
    ew.addEventHandlers("tareas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_id_grupo").hide(),$("#r_excon_grupo").hide(),$("#r_color").hide(),$("#r_participante").hide(),$('[class="ew-master-div"]').remove(),$,$,$('[class="btn-group btn-group-sm"]').remove(),$('a[data-caption="InsertLink"]').empty();
});
</script>
<?php } ?>
