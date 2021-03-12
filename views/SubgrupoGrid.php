<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("SubgrupoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubgrupogrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fsubgrupogrid = new ew.Form("fsubgrupogrid", "grid");
    fsubgrupogrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subgrupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subgrupo)
        ew.vars.tables.subgrupo = currentTable;
    fsubgrupogrid.addFields([
        ["id_subgrupo", [fields.id_subgrupo.visible && fields.id_subgrupo.required ? ew.Validators.required(fields.id_subgrupo.caption) : null], fields.id_subgrupo.isInvalid],
        ["imagen_subgrupo", [fields.imagen_subgrupo.visible && fields.imagen_subgrupo.required ? ew.Validators.fileRequired(fields.imagen_subgrupo.caption) : null], fields.imagen_subgrupo.isInvalid],
        ["nombre_subgrupo", [fields.nombre_subgrupo.visible && fields.nombre_subgrupo.required ? ew.Validators.required(fields.nombre_subgrupo.caption) : null], fields.nombre_subgrupo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubgrupogrid,
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
    fsubgrupogrid.validate = function () {
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
    fsubgrupogrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "imagen_subgrupo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nombre_subgrupo", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsubgrupogrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubgrupogrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsubgrupogrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> subgrupo">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fsubgrupogrid" class="ew-form ew-list-form form-inline">
<div id="gmp_subgrupo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_subgrupogrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->id_subgrupo->Visible) { // id_subgrupo ?>
        <th data-name="id_subgrupo" class="<?= $Grid->id_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_id_subgrupo" class="subgrupo_id_subgrupo"><?= $Grid->renderSort($Grid->id_subgrupo) ?></div></th>
<?php } ?>
<?php if ($Grid->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <th data-name="imagen_subgrupo" class="<?= $Grid->imagen_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_imagen_subgrupo" class="subgrupo_imagen_subgrupo"><?= $Grid->renderSort($Grid->imagen_subgrupo) ?></div></th>
<?php } ?>
<?php if ($Grid->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <th data-name="nombre_subgrupo" class="<?= $Grid->nombre_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_nombre_subgrupo" class="subgrupo_nombre_subgrupo"><?= $Grid->renderSort($Grid->nombre_subgrupo) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_subgrupo", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->id_subgrupo->Visible) { // id_subgrupo ?>
        <td data-name="id_subgrupo" <?= $Grid->id_subgrupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_id_subgrupo" class="form-group"></span>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_subgrupo" id="o<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_id_subgrupo" class="form-group">
<span<?= $Grid->id_subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_subgrupo->getDisplayValue($Grid->id_subgrupo->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_subgrupo" id="x<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_id_subgrupo">
<span<?= $Grid->id_subgrupo->viewAttributes() ?>>
<?= $Grid->id_subgrupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="fsubgrupogrid$x<?= $Grid->RowIndex ?>_id_subgrupo" id="fsubgrupogrid$x<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->FormValue) ?>">
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="fsubgrupogrid$o<?= $Grid->RowIndex ?>_id_subgrupo" id="fsubgrupogrid$o<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_subgrupo" id="x<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <td data-name="imagen_subgrupo" <?= $Grid->imagen_subgrupo->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_imagen_subgrupo" class="form-group subgrupo_imagen_subgrupo">
<div id="fd_x<?= $Grid->RowIndex ?>_imagen_subgrupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->imagen_subgrupo->title() ?>" data-table="subgrupo" data-field="x_imagen_subgrupo" name="x<?= $Grid->RowIndex ?>_imagen_subgrupo" id="x<?= $Grid->RowIndex ?>_imagen_subgrupo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->imagen_subgrupo->editAttributes() ?><?= ($Grid->imagen_subgrupo->ReadOnly || $Grid->imagen_subgrupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_imagen_subgrupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->imagen_subgrupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fn_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fs_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="100">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fx_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fm_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_imagen_subgrupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_imagen_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_imagen_subgrupo" id="o<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= HtmlEncode($Grid->imagen_subgrupo->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_imagen_subgrupo">
<span>
<?= GetFileViewTag($Grid->imagen_subgrupo, $Grid->imagen_subgrupo->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_imagen_subgrupo" class="form-group subgrupo_imagen_subgrupo">
<div id="fd_x<?= $Grid->RowIndex ?>_imagen_subgrupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->imagen_subgrupo->title() ?>" data-table="subgrupo" data-field="x_imagen_subgrupo" name="x<?= $Grid->RowIndex ?>_imagen_subgrupo" id="x<?= $Grid->RowIndex ?>_imagen_subgrupo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->imagen_subgrupo->editAttributes() ?><?= ($Grid->imagen_subgrupo->ReadOnly || $Grid->imagen_subgrupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_imagen_subgrupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->imagen_subgrupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fn_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fs_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="100">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fx_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fm_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_imagen_subgrupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <td data-name="nombre_subgrupo" <?= $Grid->nombre_subgrupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_nombre_subgrupo" class="form-group">
<input type="<?= $Grid->nombre_subgrupo->getInputTextType() ?>" data-table="subgrupo" data-field="x_nombre_subgrupo" name="x<?= $Grid->RowIndex ?>_nombre_subgrupo" id="x<?= $Grid->RowIndex ?>_nombre_subgrupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->nombre_subgrupo->getPlaceHolder()) ?>" value="<?= $Grid->nombre_subgrupo->EditValue ?>"<?= $Grid->nombre_subgrupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre_subgrupo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_nombre_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nombre_subgrupo" id="o<?= $Grid->RowIndex ?>_nombre_subgrupo" value="<?= HtmlEncode($Grid->nombre_subgrupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_nombre_subgrupo" class="form-group">
<input type="<?= $Grid->nombre_subgrupo->getInputTextType() ?>" data-table="subgrupo" data-field="x_nombre_subgrupo" name="x<?= $Grid->RowIndex ?>_nombre_subgrupo" id="x<?= $Grid->RowIndex ?>_nombre_subgrupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->nombre_subgrupo->getPlaceHolder()) ?>" value="<?= $Grid->nombre_subgrupo->EditValue ?>"<?= $Grid->nombre_subgrupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre_subgrupo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_subgrupo_nombre_subgrupo">
<span<?= $Grid->nombre_subgrupo->viewAttributes() ?>>
<?= $Grid->nombre_subgrupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="subgrupo" data-field="x_nombre_subgrupo" data-hidden="1" name="fsubgrupogrid$x<?= $Grid->RowIndex ?>_nombre_subgrupo" id="fsubgrupogrid$x<?= $Grid->RowIndex ?>_nombre_subgrupo" value="<?= HtmlEncode($Grid->nombre_subgrupo->FormValue) ?>">
<input type="hidden" data-table="subgrupo" data-field="x_nombre_subgrupo" data-hidden="1" name="fsubgrupogrid$o<?= $Grid->RowIndex ?>_nombre_subgrupo" id="fsubgrupogrid$o<?= $Grid->RowIndex ?>_nombre_subgrupo" value="<?= HtmlEncode($Grid->nombre_subgrupo->OldValue) ?>">
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
loadjs.ready(["fsubgrupogrid","load"], function () {
    fsubgrupogrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_subgrupo", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->id_subgrupo->Visible) { // id_subgrupo ?>
        <td data-name="id_subgrupo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_subgrupo_id_subgrupo" class="form-group subgrupo_id_subgrupo"></span>
<?php } else { ?>
<span id="el$rowindex$_subgrupo_id_subgrupo" class="form-group subgrupo_id_subgrupo">
<span<?= $Grid->id_subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_subgrupo->getDisplayValue($Grid->id_subgrupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_subgrupo" id="x<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_subgrupo" id="o<?= $Grid->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Grid->id_subgrupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <td data-name="imagen_subgrupo">
<span id="el$rowindex$_subgrupo_imagen_subgrupo" class="form-group subgrupo_imagen_subgrupo">
<div id="fd_x<?= $Grid->RowIndex ?>_imagen_subgrupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->imagen_subgrupo->title() ?>" data-table="subgrupo" data-field="x_imagen_subgrupo" name="x<?= $Grid->RowIndex ?>_imagen_subgrupo" id="x<?= $Grid->RowIndex ?>_imagen_subgrupo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->imagen_subgrupo->editAttributes() ?><?= ($Grid->imagen_subgrupo->ReadOnly || $Grid->imagen_subgrupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_imagen_subgrupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->imagen_subgrupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fn_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fa_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fs_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="100">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fx_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_imagen_subgrupo" id= "fm_x<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= $Grid->imagen_subgrupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_imagen_subgrupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_imagen_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_imagen_subgrupo" id="o<?= $Grid->RowIndex ?>_imagen_subgrupo" value="<?= HtmlEncode($Grid->imagen_subgrupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <td data-name="nombre_subgrupo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_subgrupo_nombre_subgrupo" class="form-group subgrupo_nombre_subgrupo">
<input type="<?= $Grid->nombre_subgrupo->getInputTextType() ?>" data-table="subgrupo" data-field="x_nombre_subgrupo" name="x<?= $Grid->RowIndex ?>_nombre_subgrupo" id="x<?= $Grid->RowIndex ?>_nombre_subgrupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->nombre_subgrupo->getPlaceHolder()) ?>" value="<?= $Grid->nombre_subgrupo->EditValue ?>"<?= $Grid->nombre_subgrupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre_subgrupo->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_subgrupo_nombre_subgrupo" class="form-group subgrupo_nombre_subgrupo">
<span<?= $Grid->nombre_subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nombre_subgrupo->getDisplayValue($Grid->nombre_subgrupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_nombre_subgrupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nombre_subgrupo" id="x<?= $Grid->RowIndex ?>_nombre_subgrupo" value="<?= HtmlEncode($Grid->nombre_subgrupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subgrupo" data-field="x_nombre_subgrupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nombre_subgrupo" id="o<?= $Grid->RowIndex ?>_nombre_subgrupo" value="<?= HtmlEncode($Grid->nombre_subgrupo->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fsubgrupogrid","load"], function() {
    fsubgrupogrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fsubgrupogrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
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
    ew.addEventHandlers("subgrupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#r_id_grupo").hide(),$("#r_excon_grupo").hide(),$("#r_color").hide(),$("#r_participante").hide(),$('[class="ew-master-div"]').remove();
});
</script>
<?php } ?>
