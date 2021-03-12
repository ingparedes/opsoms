<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("PermisosDocGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpermisos_docgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fpermisos_docgrid = new ew.Form("fpermisos_docgrid", "grid");
    fpermisos_docgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "permisos_doc")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.permisos_doc)
        ew.vars.tables.permisos_doc = currentTable;
    fpermisos_docgrid.addFields([
        ["id_permiso", [fields.id_permiso.visible && fields.id_permiso.required ? ew.Validators.required(fields.id_permiso.caption) : null], fields.id_permiso.isInvalid],
        ["id_file", [fields.id_file.visible && fields.id_file.required ? ew.Validators.required(fields.id_file.caption) : null, ew.Validators.integer], fields.id_file.isInvalid],
        ["tipo_permiso", [fields.tipo_permiso.visible && fields.tipo_permiso.required ? ew.Validators.required(fields.tipo_permiso.caption) : null], fields.tipo_permiso.isInvalid],
        ["fecha_created", [fields.fecha_created.visible && fields.fecha_created.required ? ew.Validators.required(fields.fecha_created.caption) : null], fields.fecha_created.isInvalid],
        ["id_usuarios", [fields.id_usuarios.visible && fields.id_usuarios.required ? ew.Validators.required(fields.id_usuarios.caption) : null], fields.id_usuarios.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpermisos_docgrid,
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
    fpermisos_docgrid.validate = function () {
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
    fpermisos_docgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "id_file", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tipo_permiso", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "id_usuarios", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fpermisos_docgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpermisos_docgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpermisos_docgrid.lists.tipo_permiso = <?= $Grid->tipo_permiso->toClientList($Grid) ?>;
    fpermisos_docgrid.lists.id_usuarios = <?= $Grid->id_usuarios->toClientList($Grid) ?>;
    loadjs.done("fpermisos_docgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> permisos_doc">
<div id="fpermisos_docgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_permisos_doc" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_permisos_docgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->id_permiso->Visible) { // id_permiso ?>
        <th data-name="id_permiso" class="<?= $Grid->id_permiso->headerCellClass() ?>"><div id="elh_permisos_doc_id_permiso" class="permisos_doc_id_permiso"><?= $Grid->renderSort($Grid->id_permiso) ?></div></th>
<?php } ?>
<?php if ($Grid->id_file->Visible) { // id_file ?>
        <th data-name="id_file" class="<?= $Grid->id_file->headerCellClass() ?>"><div id="elh_permisos_doc_id_file" class="permisos_doc_id_file"><?= $Grid->renderSort($Grid->id_file) ?></div></th>
<?php } ?>
<?php if ($Grid->tipo_permiso->Visible) { // tipo_permiso ?>
        <th data-name="tipo_permiso" class="<?= $Grid->tipo_permiso->headerCellClass() ?>"><div id="elh_permisos_doc_tipo_permiso" class="permisos_doc_tipo_permiso"><?= $Grid->renderSort($Grid->tipo_permiso) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha_created->Visible) { // fecha_created ?>
        <th data-name="fecha_created" class="<?= $Grid->fecha_created->headerCellClass() ?>"><div id="elh_permisos_doc_fecha_created" class="permisos_doc_fecha_created"><?= $Grid->renderSort($Grid->fecha_created) ?></div></th>
<?php } ?>
<?php if ($Grid->id_usuarios->Visible) { // id_usuarios ?>
        <th data-name="id_usuarios" class="<?= $Grid->id_usuarios->headerCellClass() ?>"><div id="elh_permisos_doc_id_usuarios" class="permisos_doc_id_usuarios"><?= $Grid->renderSort($Grid->id_usuarios) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_permisos_doc", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->id_permiso->Visible) { // id_permiso ?>
        <td data-name="id_permiso" <?= $Grid->id_permiso->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_permiso" class="form-group"></span>
<input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_permiso" id="o<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_permiso" class="form-group">
<span<?= $Grid->id_permiso->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_permiso->getDisplayValue($Grid->id_permiso->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_permiso" id="x<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_permiso">
<span<?= $Grid->id_permiso->viewAttributes() ?>>
<?= $Grid->id_permiso->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_id_permiso" id="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->FormValue) ?>">
<input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_id_permiso" id="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_permiso" id="x<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->id_file->Visible) { // id_file ?>
        <td data-name="id_file" <?= $Grid->id_file->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->id_file->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_file" class="form-group">
<span<?= $Grid->id_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_file->getDisplayValue($Grid->id_file->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_file" name="x<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_file" class="form-group">
<input type="<?= $Grid->id_file->getInputTextType() ?>" data-table="permisos_doc" data-field="x_id_file" name="x<?= $Grid->RowIndex ?>_id_file" id="x<?= $Grid->RowIndex ?>_id_file" size="30" placeholder="<?= HtmlEncode($Grid->id_file->getPlaceHolder()) ?>" value="<?= $Grid->id_file->EditValue ?>"<?= $Grid->id_file->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_file->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_file" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_file" id="o<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->id_file->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_file" class="form-group">
<span<?= $Grid->id_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_file->getDisplayValue($Grid->id_file->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_file" name="x<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_file" class="form-group">
<input type="<?= $Grid->id_file->getInputTextType() ?>" data-table="permisos_doc" data-field="x_id_file" name="x<?= $Grid->RowIndex ?>_id_file" id="x<?= $Grid->RowIndex ?>_id_file" size="30" placeholder="<?= HtmlEncode($Grid->id_file->getPlaceHolder()) ?>" value="<?= $Grid->id_file->EditValue ?>"<?= $Grid->id_file->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_file->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_file">
<span<?= $Grid->id_file->viewAttributes() ?>>
<?= $Grid->id_file->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_file" data-hidden="1" name="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_id_file" id="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->FormValue) ?>">
<input type="hidden" data-table="permisos_doc" data-field="x_id_file" data-hidden="1" name="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_id_file" id="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tipo_permiso->Visible) { // tipo_permiso ?>
        <td data-name="tipo_permiso" <?= $Grid->tipo_permiso->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_tipo_permiso" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo_permiso"
        name="x<?= $Grid->RowIndex ?>_tipo_permiso"
        class="form-control ew-select<?= $Grid->tipo_permiso->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso"
        data-table="permisos_doc"
        data-field="x_tipo_permiso"
        data-value-separator="<?= $Grid->tipo_permiso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo_permiso->getPlaceHolder()) ?>"
        <?= $Grid->tipo_permiso->editAttributes() ?>>
        <?= $Grid->tipo_permiso->selectOptionListHtml("x{$Grid->RowIndex}_tipo_permiso") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo_permiso->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tipo_permiso", selectId: "permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.permisos_doc.fields.tipo_permiso.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.tipo_permiso.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_tipo_permiso" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tipo_permiso" id="o<?= $Grid->RowIndex ?>_tipo_permiso" value="<?= HtmlEncode($Grid->tipo_permiso->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_tipo_permiso" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo_permiso"
        name="x<?= $Grid->RowIndex ?>_tipo_permiso"
        class="form-control ew-select<?= $Grid->tipo_permiso->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso"
        data-table="permisos_doc"
        data-field="x_tipo_permiso"
        data-value-separator="<?= $Grid->tipo_permiso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo_permiso->getPlaceHolder()) ?>"
        <?= $Grid->tipo_permiso->editAttributes() ?>>
        <?= $Grid->tipo_permiso->selectOptionListHtml("x{$Grid->RowIndex}_tipo_permiso") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo_permiso->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tipo_permiso", selectId: "permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.permisos_doc.fields.tipo_permiso.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.tipo_permiso.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_tipo_permiso">
<span<?= $Grid->tipo_permiso->viewAttributes() ?>>
<?= $Grid->tipo_permiso->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="permisos_doc" data-field="x_tipo_permiso" data-hidden="1" name="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_tipo_permiso" id="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_tipo_permiso" value="<?= HtmlEncode($Grid->tipo_permiso->FormValue) ?>">
<input type="hidden" data-table="permisos_doc" data-field="x_tipo_permiso" data-hidden="1" name="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_tipo_permiso" id="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_tipo_permiso" value="<?= HtmlEncode($Grid->tipo_permiso->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha_created->Visible) { // fecha_created ?>
        <td data-name="fecha_created" <?= $Grid->fecha_created->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="permisos_doc" data-field="x_fecha_created" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fecha_created" id="o<?= $Grid->RowIndex ?>_fecha_created" value="<?= HtmlEncode($Grid->fecha_created->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_fecha_created">
<span<?= $Grid->fecha_created->viewAttributes() ?>>
<?= $Grid->fecha_created->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="permisos_doc" data-field="x_fecha_created" data-hidden="1" name="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_fecha_created" id="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_fecha_created" value="<?= HtmlEncode($Grid->fecha_created->FormValue) ?>">
<input type="hidden" data-table="permisos_doc" data-field="x_fecha_created" data-hidden="1" name="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_fecha_created" id="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_fecha_created" value="<?= HtmlEncode($Grid->fecha_created->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->id_usuarios->Visible) { // id_usuarios ?>
        <td data-name="id_usuarios" <?= $Grid->id_usuarios->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_usuarios" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_id_usuarios"
        name="x<?= $Grid->RowIndex ?>_id_usuarios"
        class="form-control ew-select<?= $Grid->id_usuarios->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios"
        data-table="permisos_doc"
        data-field="x_id_usuarios"
        data-value-separator="<?= $Grid->id_usuarios->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_usuarios->getPlaceHolder()) ?>"
        <?= $Grid->id_usuarios->editAttributes() ?>>
        <?= $Grid->id_usuarios->selectOptionListHtml("x{$Grid->RowIndex}_id_usuarios") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->id_usuarios->getErrorMessage() ?></div>
<?= $Grid->id_usuarios->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_usuarios") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_usuarios", selectId: "permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.id_usuarios.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_id_usuarios" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_usuarios" id="o<?= $Grid->RowIndex ?>_id_usuarios" value="<?= HtmlEncode($Grid->id_usuarios->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_usuarios" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_id_usuarios"
        name="x<?= $Grid->RowIndex ?>_id_usuarios"
        class="form-control ew-select<?= $Grid->id_usuarios->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios"
        data-table="permisos_doc"
        data-field="x_id_usuarios"
        data-value-separator="<?= $Grid->id_usuarios->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_usuarios->getPlaceHolder()) ?>"
        <?= $Grid->id_usuarios->editAttributes() ?>>
        <?= $Grid->id_usuarios->selectOptionListHtml("x{$Grid->RowIndex}_id_usuarios") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->id_usuarios->getErrorMessage() ?></div>
<?= $Grid->id_usuarios->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_usuarios") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_usuarios", selectId: "permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.id_usuarios.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_permisos_doc_id_usuarios">
<span<?= $Grid->id_usuarios->viewAttributes() ?>>
<?= $Grid->id_usuarios->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_usuarios" data-hidden="1" name="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_id_usuarios" id="fpermisos_docgrid$x<?= $Grid->RowIndex ?>_id_usuarios" value="<?= HtmlEncode($Grid->id_usuarios->FormValue) ?>">
<input type="hidden" data-table="permisos_doc" data-field="x_id_usuarios" data-hidden="1" name="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_id_usuarios" id="fpermisos_docgrid$o<?= $Grid->RowIndex ?>_id_usuarios" value="<?= HtmlEncode($Grid->id_usuarios->OldValue) ?>">
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
loadjs.ready(["fpermisos_docgrid","load"], function () {
    fpermisos_docgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_permisos_doc", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->id_permiso->Visible) { // id_permiso ?>
        <td data-name="id_permiso">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_permisos_doc_id_permiso" class="form-group permisos_doc_id_permiso"></span>
<?php } else { ?>
<span id="el$rowindex$_permisos_doc_id_permiso" class="form-group permisos_doc_id_permiso">
<span<?= $Grid->id_permiso->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_permiso->getDisplayValue($Grid->id_permiso->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_permiso" id="x<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_permiso" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_permiso" id="o<?= $Grid->RowIndex ?>_id_permiso" value="<?= HtmlEncode($Grid->id_permiso->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->id_file->Visible) { // id_file ?>
        <td data-name="id_file">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->id_file->getSessionValue() != "") { ?>
<span id="el$rowindex$_permisos_doc_id_file" class="form-group permisos_doc_id_file">
<span<?= $Grid->id_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_file->getDisplayValue($Grid->id_file->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_id_file" name="x<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_permisos_doc_id_file" class="form-group permisos_doc_id_file">
<input type="<?= $Grid->id_file->getInputTextType() ?>" data-table="permisos_doc" data-field="x_id_file" name="x<?= $Grid->RowIndex ?>_id_file" id="x<?= $Grid->RowIndex ?>_id_file" size="30" placeholder="<?= HtmlEncode($Grid->id_file->getPlaceHolder()) ?>" value="<?= $Grid->id_file->EditValue ?>"<?= $Grid->id_file->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->id_file->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_permisos_doc_id_file" class="form-group permisos_doc_id_file">
<span<?= $Grid->id_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_file->getDisplayValue($Grid->id_file->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_id_file" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_file" id="x<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_file" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_file" id="o<?= $Grid->RowIndex ?>_id_file" value="<?= HtmlEncode($Grid->id_file->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tipo_permiso->Visible) { // tipo_permiso ?>
        <td data-name="tipo_permiso">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_permisos_doc_tipo_permiso" class="form-group permisos_doc_tipo_permiso">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo_permiso"
        name="x<?= $Grid->RowIndex ?>_tipo_permiso"
        class="form-control ew-select<?= $Grid->tipo_permiso->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso"
        data-table="permisos_doc"
        data-field="x_tipo_permiso"
        data-value-separator="<?= $Grid->tipo_permiso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo_permiso->getPlaceHolder()) ?>"
        <?= $Grid->tipo_permiso->editAttributes() ?>>
        <?= $Grid->tipo_permiso->selectOptionListHtml("x{$Grid->RowIndex}_tipo_permiso") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo_permiso->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso']"),
        options = { name: "x<?= $Grid->RowIndex ?>_tipo_permiso", selectId: "permisos_doc_x<?= $Grid->RowIndex ?>_tipo_permiso", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.permisos_doc.fields.tipo_permiso.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.tipo_permiso.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_permisos_doc_tipo_permiso" class="form-group permisos_doc_tipo_permiso">
<span<?= $Grid->tipo_permiso->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tipo_permiso->getDisplayValue($Grid->tipo_permiso->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_tipo_permiso" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tipo_permiso" id="x<?= $Grid->RowIndex ?>_tipo_permiso" value="<?= HtmlEncode($Grid->tipo_permiso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="permisos_doc" data-field="x_tipo_permiso" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tipo_permiso" id="o<?= $Grid->RowIndex ?>_tipo_permiso" value="<?= HtmlEncode($Grid->tipo_permiso->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fecha_created->Visible) { // fecha_created ?>
        <td data-name="fecha_created">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_permisos_doc_fecha_created" class="form-group permisos_doc_fecha_created">
<span<?= $Grid->fecha_created->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fecha_created->getDisplayValue($Grid->fecha_created->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_fecha_created" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fecha_created" id="x<?= $Grid->RowIndex ?>_fecha_created" value="<?= HtmlEncode($Grid->fecha_created->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="permisos_doc" data-field="x_fecha_created" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fecha_created" id="o<?= $Grid->RowIndex ?>_fecha_created" value="<?= HtmlEncode($Grid->fecha_created->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->id_usuarios->Visible) { // id_usuarios ?>
        <td data-name="id_usuarios">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_permisos_doc_id_usuarios" class="form-group permisos_doc_id_usuarios">
    <select
        id="x<?= $Grid->RowIndex ?>_id_usuarios"
        name="x<?= $Grid->RowIndex ?>_id_usuarios"
        class="form-control ew-select<?= $Grid->id_usuarios->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios"
        data-table="permisos_doc"
        data-field="x_id_usuarios"
        data-value-separator="<?= $Grid->id_usuarios->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_usuarios->getPlaceHolder()) ?>"
        <?= $Grid->id_usuarios->editAttributes() ?>>
        <?= $Grid->id_usuarios->selectOptionListHtml("x{$Grid->RowIndex}_id_usuarios") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->id_usuarios->getErrorMessage() ?></div>
<?= $Grid->id_usuarios->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_usuarios") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_usuarios", selectId: "permisos_doc_x<?= $Grid->RowIndex ?>_id_usuarios", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.id_usuarios.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_permisos_doc_id_usuarios" class="form-group permisos_doc_id_usuarios">
<span<?= $Grid->id_usuarios->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_usuarios->getDisplayValue($Grid->id_usuarios->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="permisos_doc" data-field="x_id_usuarios" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_usuarios" id="x<?= $Grid->RowIndex ?>_id_usuarios" value="<?= HtmlEncode($Grid->id_usuarios->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="permisos_doc" data-field="x_id_usuarios" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_usuarios" id="o<?= $Grid->RowIndex ?>_id_usuarios" value="<?= HtmlEncode($Grid->id_usuarios->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fpermisos_docgrid","load"], function() {
    fpermisos_docgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fpermisos_docgrid">
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
    ew.addEventHandlers("permisos_doc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
