<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("GrupoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fgrupogrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fgrupogrid = new ew.Form("fgrupogrid", "grid");
    fgrupogrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.grupo)
        ew.vars.tables.grupo = currentTable;
    fgrupogrid.addFields([
        ["id_grupo", [fields.id_grupo.visible && fields.id_grupo.required ? ew.Validators.required(fields.id_grupo.caption) : null], fields.id_grupo.isInvalid],
        ["imgen_grupo", [fields.imgen_grupo.visible && fields.imgen_grupo.required ? ew.Validators.fileRequired(fields.imgen_grupo.caption) : null], fields.imgen_grupo.isInvalid],
        ["nombre_grupo", [fields.nombre_grupo.visible && fields.nombre_grupo.required ? ew.Validators.required(fields.nombre_grupo.caption) : null], fields.nombre_grupo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fgrupogrid,
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
    fgrupogrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    fgrupogrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "imgen_grupo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nombre_grupo", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fgrupogrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fgrupogrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fgrupogrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> grupo">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fgrupogrid" class="ew-form ew-list-form form-inline">
<div id="gmp_grupo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_grupogrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id_grupo->Visible) { // id_grupo ?>
        <th data-name="id_grupo" class="<?= $Grid->id_grupo->headerCellClass() ?>"><div id="elh_grupo_id_grupo" class="grupo_id_grupo"><?= $Grid->renderSort($Grid->id_grupo) ?></div></th>
<?php } ?>
<?php if ($Grid->imgen_grupo->Visible) { // imgen_grupo ?>
        <th data-name="imgen_grupo" class="<?= $Grid->imgen_grupo->headerCellClass() ?>"><div id="elh_grupo_imgen_grupo" class="grupo_imgen_grupo"><?= $Grid->renderSort($Grid->imgen_grupo) ?></div></th>
<?php } ?>
<?php if ($Grid->nombre_grupo->Visible) { // nombre_grupo ?>
        <th data-name="nombre_grupo" class="<?= $Grid->nombre_grupo->headerCellClass() ?>"><div id="elh_grupo_nombre_grupo" class="grupo_nombre_grupo"><?= $Grid->renderSort($Grid->nombre_grupo) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_grupo", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo" <?= $Grid->id_grupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_id_grupo" class="form-group"></span>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_grupo" id="o<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_id_grupo" class="form-group">
<span<?= $Grid->id_grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_grupo->getDisplayValue($Grid->id_grupo->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_grupo" id="x<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_id_grupo">
<span<?= $Grid->id_grupo->viewAttributes() ?>>
<?= $Grid->id_grupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="fgrupogrid$x<?= $Grid->RowIndex ?>_id_grupo" id="fgrupogrid$x<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->FormValue) ?>">
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="fgrupogrid$o<?= $Grid->RowIndex ?>_id_grupo" id="fgrupogrid$o<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_grupo" id="x<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->imgen_grupo->Visible) { // imgen_grupo ?>
        <td data-name="imgen_grupo" <?= $Grid->imgen_grupo->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_imgen_grupo" class="form-group grupo_imgen_grupo">
<div id="fd_x<?= $Grid->RowIndex ?>_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x<?= $Grid->RowIndex ?>_imgen_grupo" id="x<?= $Grid->RowIndex ?>_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->imgen_grupo->editAttributes() ?><?= ($Grid->imgen_grupo->ReadOnly || $Grid->imgen_grupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fn_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fa_x<?= $Grid->RowIndex ?>_imgen_grupo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fs_x<?= $Grid->RowIndex ?>_imgen_grupo" value="30">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fx_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fm_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="grupo" data-field="x_imgen_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_imgen_grupo" id="o<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= HtmlEncode($Grid->imgen_grupo->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_imgen_grupo">
<span>
<?= GetFileViewTag($Grid->imgen_grupo, $Grid->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_imgen_grupo" class="form-group grupo_imgen_grupo">
<div id="fd_x<?= $Grid->RowIndex ?>_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x<?= $Grid->RowIndex ?>_imgen_grupo" id="x<?= $Grid->RowIndex ?>_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->imgen_grupo->editAttributes() ?><?= ($Grid->imgen_grupo->ReadOnly || $Grid->imgen_grupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fn_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fa_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_imgen_grupo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fs_x<?= $Grid->RowIndex ?>_imgen_grupo" value="30">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fx_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fm_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nombre_grupo->Visible) { // nombre_grupo ?>
        <td data-name="nombre_grupo" <?= $Grid->nombre_grupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_nombre_grupo" class="form-group">
<input type="<?= $Grid->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x<?= $Grid->RowIndex ?>_nombre_grupo" id="x<?= $Grid->RowIndex ?>_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Grid->nombre_grupo->EditValue ?>"<?= $Grid->nombre_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre_grupo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="grupo" data-field="x_nombre_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nombre_grupo" id="o<?= $Grid->RowIndex ?>_nombre_grupo" value="<?= HtmlEncode($Grid->nombre_grupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_nombre_grupo" class="form-group">
<input type="<?= $Grid->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x<?= $Grid->RowIndex ?>_nombre_grupo" id="x<?= $Grid->RowIndex ?>_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Grid->nombre_grupo->EditValue ?>"<?= $Grid->nombre_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre_grupo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_grupo_nombre_grupo">
<span<?= $Grid->nombre_grupo->viewAttributes() ?>>
<?= $Grid->nombre_grupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="grupo" data-field="x_nombre_grupo" data-hidden="1" name="fgrupogrid$x<?= $Grid->RowIndex ?>_nombre_grupo" id="fgrupogrid$x<?= $Grid->RowIndex ?>_nombre_grupo" value="<?= HtmlEncode($Grid->nombre_grupo->FormValue) ?>">
<input type="hidden" data-table="grupo" data-field="x_nombre_grupo" data-hidden="1" name="fgrupogrid$o<?= $Grid->RowIndex ?>_nombre_grupo" id="fgrupogrid$o<?= $Grid->RowIndex ?>_nombre_grupo" value="<?= HtmlEncode($Grid->nombre_grupo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fgrupogrid","load"], function () {
    fgrupogrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_grupo", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_grupo_id_grupo" class="form-group grupo_id_grupo"></span>
<?php } else { ?>
<span id="el$rowindex$_grupo_id_grupo" class="form-group grupo_id_grupo">
<span<?= $Grid->id_grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_grupo->getDisplayValue($Grid->id_grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_grupo" id="x<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo" data-field="x_id_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_grupo" id="o<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->imgen_grupo->Visible) { // imgen_grupo ?>
        <td data-name="imgen_grupo">
<span id="el$rowindex$_grupo_imgen_grupo" class="form-group grupo_imgen_grupo">
<div id="fd_x<?= $Grid->RowIndex ?>_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x<?= $Grid->RowIndex ?>_imgen_grupo" id="x<?= $Grid->RowIndex ?>_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->imgen_grupo->editAttributes() ?><?= ($Grid->imgen_grupo->ReadOnly || $Grid->imgen_grupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fn_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fa_x<?= $Grid->RowIndex ?>_imgen_grupo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fs_x<?= $Grid->RowIndex ?>_imgen_grupo" value="30">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fx_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_imgen_grupo" id= "fm_x<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= $Grid->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="grupo" data-field="x_imgen_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_imgen_grupo" id="o<?= $Grid->RowIndex ?>_imgen_grupo" value="<?= HtmlEncode($Grid->imgen_grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nombre_grupo->Visible) { // nombre_grupo ?>
        <td data-name="nombre_grupo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_grupo_nombre_grupo" class="form-group grupo_nombre_grupo">
<input type="<?= $Grid->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x<?= $Grid->RowIndex ?>_nombre_grupo" id="x<?= $Grid->RowIndex ?>_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Grid->nombre_grupo->EditValue ?>"<?= $Grid->nombre_grupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre_grupo->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_nombre_grupo" class="form-group grupo_nombre_grupo">
<span<?= $Grid->nombre_grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nombre_grupo->getDisplayValue($Grid->nombre_grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="grupo" data-field="x_nombre_grupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nombre_grupo" id="x<?= $Grid->RowIndex ?>_nombre_grupo" value="<?= HtmlEncode($Grid->nombre_grupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo" data-field="x_nombre_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nombre_grupo" id="o<?= $Grid->RowIndex ?>_nombre_grupo" value="<?= HtmlEncode($Grid->nombre_grupo->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fgrupogrid","load"], function() {
    fgrupogrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fgrupogrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
