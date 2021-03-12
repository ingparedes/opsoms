<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fgrupolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fgrupolist = currentForm = new ew.Form("fgrupolist", "list");
    fgrupolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.grupo)
        ew.vars.tables.grupo = currentTable;
    fgrupolist.addFields([
        ["id_grupo", [fields.id_grupo.visible && fields.id_grupo.required ? ew.Validators.required(fields.id_grupo.caption) : null], fields.id_grupo.isInvalid],
        ["imgen_grupo", [fields.imgen_grupo.visible && fields.imgen_grupo.required ? ew.Validators.fileRequired(fields.imgen_grupo.caption) : null], fields.imgen_grupo.isInvalid],
        ["nombre_grupo", [fields.nombre_grupo.visible && fields.nombre_grupo.required ? ew.Validators.required(fields.nombre_grupo.caption) : null], fields.nombre_grupo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fgrupolist,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fgrupolist.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }
        return true;
    }

    // Form_CustomValidate
    fgrupolist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fgrupolist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fgrupolist");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #F8F8FF; /* preview row color */
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> grupo">
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
<form name="fgrupolist" id="fgrupolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
<?php if ($Page->getCurrentMasterTable() == "escenario" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="escenario">
<input type="hidden" name="fk_id_escenario" value="<?= HtmlEncode($Page->id_escenario->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_grupo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_grupolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <th data-name="id_grupo" class="<?= $Page->id_grupo->headerCellClass() ?>"><div id="elh_grupo_id_grupo" class="grupo_id_grupo"><?= $Page->renderSort($Page->id_grupo) ?></div></th>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <th data-name="imgen_grupo" class="<?= $Page->imgen_grupo->headerCellClass() ?>"><div id="elh_grupo_imgen_grupo" class="grupo_imgen_grupo"><?= $Page->renderSort($Page->imgen_grupo) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <th data-name="nombre_grupo" class="<?= $Page->nombre_grupo->headerCellClass() ?>"><div id="elh_grupo_nombre_grupo" class="grupo_nombre_grupo"><?= $Page->renderSort($Page->nombre_grupo) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
    if ($Page->isAdd() || $Page->isCopy()) {
        $Page->RowIndex = 0;
        $Page->KeyCount = $Page->RowIndex;
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_grupo", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo">
<span id="el<?= $Page->RowCount ?>_grupo_id_grupo" class="form-group grupo_id_grupo"></span>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_id_grupo" id="o<?= $Page->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Page->id_grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <td data-name="imgen_grupo">
<span id="el<?= $Page->RowCount ?>_grupo_imgen_grupo" class="form-group grupo_imgen_grupo">
<div id="fd_x<?= $Page->RowIndex ?>_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x<?= $Page->RowIndex ?>_imgen_grupo" id="x<?= $Page->RowIndex ?>_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imgen_grupo->editAttributes() ?><?= ($Page->imgen_grupo->ReadOnly || $Page->imgen_grupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fn_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= $Page->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fa_x<?= $Page->RowIndex ?>_imgen_grupo" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fs_x<?= $Page->RowIndex ?>_imgen_grupo" value="30">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fx_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= $Page->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fm_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= $Page->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="grupo" data-field="x_imgen_grupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_imgen_grupo" id="o<?= $Page->RowIndex ?>_imgen_grupo" value="<?= HtmlEncode($Page->imgen_grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <td data-name="nombre_grupo">
<span id="el<?= $Page->RowCount ?>_grupo_nombre_grupo" class="form-group grupo_nombre_grupo">
<input type="<?= $Page->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x<?= $Page->RowIndex ?>_nombre_grupo" id="x<?= $Page->RowIndex ?>_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_grupo->EditValue ?>"<?= $Page->nombre_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre_grupo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="grupo" data-field="x_nombre_grupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_nombre_grupo" id="o<?= $Page->RowIndex ?>_nombre_grupo" value="<?= HtmlEncode($Page->nombre_grupo->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fgrupolist","load"], function() {
    fgrupolist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
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

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
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
$Page->EditRowCount = 0;
if ($Page->isEdit())
    $Page->RowIndex = 1;
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
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_grupo", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo" <?= $Page->id_grupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_grupo_id_grupo" class="form-group">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_grupo->getDisplayValue($Page->id_grupo->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_grupo" id="x<?= $Page->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Page->id_grupo->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_grupo_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_grupo" id="x<?= $Page->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Page->id_grupo->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <td data-name="imgen_grupo" <?= $Page->imgen_grupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_grupo_imgen_grupo" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x<?= $Page->RowIndex ?>_imgen_grupo" id="x<?= $Page->RowIndex ?>_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imgen_grupo->editAttributes() ?><?= ($Page->imgen_grupo->ReadOnly || $Page->imgen_grupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fn_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= $Page->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fa_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_imgen_grupo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fs_x<?= $Page->RowIndex ?>_imgen_grupo" value="30">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fx_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= $Page->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_imgen_grupo" id= "fm_x<?= $Page->RowIndex ?>_imgen_grupo" value="<?= $Page->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_grupo_imgen_grupo">
<span>
<?= GetFileViewTag($Page->imgen_grupo, $Page->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <td data-name="nombre_grupo" <?= $Page->nombre_grupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_grupo_nombre_grupo" class="form-group">
<input type="<?= $Page->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x<?= $Page->RowIndex ?>_nombre_grupo" id="x<?= $Page->RowIndex ?>_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_grupo->EditValue ?>"<?= $Page->nombre_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre_grupo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_grupo_nombre_grupo">
<span<?= $Page->nombre_grupo->viewAttributes() ?>>
<?= $Page->nombre_grupo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fgrupolist","load"], function () {
    fgrupolist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
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
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
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
    ew.addEventHandlers("grupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_id_escenario").hide(),$("#r_icon_escenario").hide(),$("#r_fechacreacion_escenario").hide(),$("#r_estado").hide(),$("#r_entrar").hide(),$('[class="ew-master-div"]').remove(),$('[class="btn-group btn-group-sm"]').remove(),$('a[data-caption="InsertLink"]').empty(),$('a[data-caption="InsertLink"]').append("<i data-phrase='CancelLink' class='fa fa-check ew-icon' data-caption='Cancelar'></i>");
});
</script>
<?php } ?>
