<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EscenarioList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fescenariolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fescenariolist = currentForm = new ew.Form("fescenariolist", "list");
    fescenariolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fescenariolist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> escenario">
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
<form name="fescenariolist" id="fescenariolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="escenario">
<div id="gmp_escenario" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_escenariolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <th data-name="id_escenario" class="<?= $Page->id_escenario->headerCellClass() ?>"><div id="elh_escenario_id_escenario" class="escenario_id_escenario"><?= $Page->renderSort($Page->id_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
        <th data-name="icon_escenario" class="<?= $Page->icon_escenario->headerCellClass() ?>"><div id="elh_escenario_icon_escenario" class="escenario_icon_escenario"><?= $Page->renderSort($Page->icon_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <th data-name="fechacreacion_escenario" class="<?= $Page->fechacreacion_escenario->headerCellClass() ?>"><div id="elh_escenario_fechacreacion_escenario" class="escenario_fechacreacion_escenario"><?= $Page->renderSort($Page->fechacreacion_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
        <th data-name="nombre_escenario" class="<?= $Page->nombre_escenario->headerCellClass() ?>"><div id="elh_escenario_nombre_escenario" class="escenario_nombre_escenario"><?= $Page->renderSort($Page->nombre_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
        <th data-name="incidente" class="<?= $Page->incidente->headerCellClass() ?>"><div id="elh_escenario_incidente" class="escenario_incidente"><?= $Page->renderSort($Page->incidente) ?></div></th>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
        <th data-name="pais_escenario" class="<?= $Page->pais_escenario->headerCellClass() ?>"><div id="elh_escenario_pais_escenario" class="escenario_pais_escenario"><?= $Page->renderSort($Page->pais_escenario) ?></div></th>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <th data-name="fechaini_simulado" class="<?= $Page->fechaini_simulado->headerCellClass() ?>"><div id="elh_escenario_fechaini_simulado" class="escenario_fechaini_simulado"><?= $Page->renderSort($Page->fechaini_simulado) ?></div></th>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
        <th data-name="fechaini_real" class="<?= $Page->fechaini_real->headerCellClass() ?>"><div id="elh_escenario_fechaini_real" class="escenario_fechaini_real"><?= $Page->renderSort($Page->fechaini_real) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_escenario_estado" class="escenario_estado"><?= $Page->renderSort($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->entrar->Visible) { // entrar ?>
        <th data-name="entrar" class="<?= $Page->entrar->headerCellClass() ?>"><div id="elh_escenario_entrar" class="escenario_entrar"><?= $Page->renderSort($Page->entrar) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_escenario", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_escenario->Visible) { // id_escenario ?>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
        <td data-name="icon_escenario" <?= $Page->icon_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_icon_escenario">
<span><?php
$idm = CurrentPage()->icon_escenario->CurrentValue;
echo "<img width='25px' src='$idm'>";
?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <td data-name="fechacreacion_escenario" <?= $Page->fechacreacion_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechacreacion_escenario">
<span<?= $Page->fechacreacion_escenario->viewAttributes() ?>>
<?= $Page->fechacreacion_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
        <td data-name="nombre_escenario" <?= $Page->nombre_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_nombre_escenario">
<span<?= $Page->nombre_escenario->viewAttributes() ?>>
<?= $Page->nombre_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->incidente->Visible) { // incidente ?>
        <td data-name="incidente" <?= $Page->incidente->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_incidente">
<span<?= $Page->incidente->viewAttributes() ?>>
<?= $Page->incidente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
        <td data-name="pais_escenario" <?= $Page->pais_escenario->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_pais_escenario">
<span<?= $Page->pais_escenario->viewAttributes() ?>>
<?= $Page->pais_escenario->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <td data-name="fechaini_simulado" <?= $Page->fechaini_simulado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechaini_simulado">
<span<?= $Page->fechaini_simulado->viewAttributes() ?>>
<?= $Page->fechaini_simulado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
        <td data-name="fechaini_real" <?= $Page->fechaini_real->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_fechaini_real">
<span<?= $Page->fechaini_real->viewAttributes() ?>>
<?= $Page->fechaini_real->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->entrar->Visible) { // entrar ?>
        <td data-name="entrar" <?= $Page->entrar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_escenario_entrar">
<span<?= $Page->entrar->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->entrar->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"GrupoList?showmaster=escenario&fk_id_escenario=$id&showdetail=\" data-original-title=\"Grupo\"><i class=\"fa fa-user-plus\"data-caption=\"Grupo\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"TareasList?showmaster=escenario&fk_id_escenario=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
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
    ew.addEventHandlers("escenario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    //Write your table-specific startup script here, no need to add script tags.
    /*function refreshTable(delay = 10000, previewCheck = true) { // Refresh period ... 1000 = 1 second
    tableRefresh = setInterval(function() {
    if ((previewCheck && $('.ew-preview-row-btn.icon-collapse').length > 0) || $('.modal.show').length > 0)
    return;
    $('.ew-preview-row-btn.icon-collapse').trigger('click');
    $('table.ew-table > tbody').load(location.href + ' table.ew-table > tbody tr', function() {
    $(this).find('tr:even').removeClass('ew-table-alt-row').addClass('ew-table-row');
    $(this).find('tr:odd').removeClass('ew-table-row').addClass('ew-table-alt-row');
    $('.ew-preview-row-btn').click(ew.showDetails);
    $('div.ew-preview [data-toggle="tab"]').on('show.bs.tab', ew.tabShow);
    $('div.popover').hide();
    ew.initTooltips();
    });
    }, delay);
    }
    refreshTable(15000, false);*/

    //http://localhost/simexamerica/GrupoList?showmaster=escenario&fk_id_escenario=40#
});
</script>
<?php } ?>
