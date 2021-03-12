<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("TareasGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ftareasgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    ftareasgrid = new ew.Form("ftareasgrid", "grid");
    ftareasgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.tareas)
        ew.vars.tables.tareas = currentTable;
    ftareasgrid.addFields([
        ["id_tarea", [fields.id_tarea.visible && fields.id_tarea.required ? ew.Validators.required(fields.id_tarea.caption) : null], fields.id_tarea.isInvalid],
        ["id_grupo", [fields.id_grupo.visible && fields.id_grupo.required ? ew.Validators.required(fields.id_grupo.caption) : null], fields.id_grupo.isInvalid],
        ["titulo_tarea", [fields.titulo_tarea.visible && fields.titulo_tarea.required ? ew.Validators.required(fields.titulo_tarea.caption) : null], fields.titulo_tarea.isInvalid],
        ["fechainireal_tarea", [fields.fechainireal_tarea.visible && fields.fechainireal_tarea.required ? ew.Validators.required(fields.fechainireal_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechainireal_tarea.isInvalid],
        ["fechafin_tarea", [fields.fechafin_tarea.visible && fields.fechafin_tarea.required ? ew.Validators.required(fields.fechafin_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechafin_tarea.isInvalid],
        ["fechainisimulado_tarea", [fields.fechainisimulado_tarea.visible && fields.fechainisimulado_tarea.required ? ew.Validators.required(fields.fechainisimulado_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechainisimulado_tarea.isInvalid],
        ["fechafinsimulado_tarea", [fields.fechafinsimulado_tarea.visible && fields.fechafinsimulado_tarea.required ? ew.Validators.required(fields.fechafinsimulado_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechafinsimulado_tarea.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftareasgrid,
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
    ftareasgrid.validate = function () {
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
    ftareasgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "id_grupo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "titulo_tarea", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fechainireal_tarea", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fechafin_tarea", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fechainisimulado_tarea", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fechafinsimulado_tarea", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    ftareasgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftareasgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftareasgrid.lists.id_grupo = <?= $Grid->id_grupo->toClientList($Grid) ?>;
    loadjs.done("ftareasgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tareas">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="ftareasgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_tareas" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_tareasgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->id_tarea->Visible) { // id_tarea ?>
        <th data-name="id_tarea" class="<?= $Grid->id_tarea->headerCellClass() ?>"><div id="elh_tareas_id_tarea" class="tareas_id_tarea"><?= $Grid->renderSort($Grid->id_tarea) ?></div></th>
<?php } ?>
<?php if ($Grid->id_grupo->Visible) { // id_grupo ?>
        <th data-name="id_grupo" class="<?= $Grid->id_grupo->headerCellClass() ?>"><div id="elh_tareas_id_grupo" class="tareas_id_grupo"><?= $Grid->renderSort($Grid->id_grupo) ?></div></th>
<?php } ?>
<?php if ($Grid->titulo_tarea->Visible) { // titulo_tarea ?>
        <th data-name="titulo_tarea" class="<?= $Grid->titulo_tarea->headerCellClass() ?>"><div id="elh_tareas_titulo_tarea" class="tareas_titulo_tarea"><?= $Grid->renderSort($Grid->titulo_tarea) ?></div></th>
<?php } ?>
<?php if ($Grid->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <th data-name="fechainireal_tarea" class="<?= $Grid->fechainireal_tarea->headerCellClass() ?>"><div id="elh_tareas_fechainireal_tarea" class="tareas_fechainireal_tarea"><?= $Grid->renderSort($Grid->fechainireal_tarea) ?></div></th>
<?php } ?>
<?php if ($Grid->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <th data-name="fechafin_tarea" class="<?= $Grid->fechafin_tarea->headerCellClass() ?>"><div id="elh_tareas_fechafin_tarea" class="tareas_fechafin_tarea"><?= $Grid->renderSort($Grid->fechafin_tarea) ?></div></th>
<?php } ?>
<?php if ($Grid->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <th data-name="fechainisimulado_tarea" class="<?= $Grid->fechainisimulado_tarea->headerCellClass() ?>"><div id="elh_tareas_fechainisimulado_tarea" class="tareas_fechainisimulado_tarea"><?= $Grid->renderSort($Grid->fechainisimulado_tarea) ?></div></th>
<?php } ?>
<?php if ($Grid->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <th data-name="fechafinsimulado_tarea" class="<?= $Grid->fechafinsimulado_tarea->headerCellClass() ?>"><div id="elh_tareas_fechafinsimulado_tarea" class="tareas_fechafinsimulado_tarea"><?= $Grid->renderSort($Grid->fechafinsimulado_tarea) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_tareas", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->id_tarea->Visible) { // id_tarea ?>
        <td data-name="id_tarea" <?= $Grid->id_tarea->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_id_tarea" class="form-group"></span>
<input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_tarea" id="o<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_id_tarea" class="form-group">
<span<?= $Grid->id_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_tarea->getDisplayValue($Grid->id_tarea->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_tarea" id="x<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_id_tarea">
<span<?= $Grid->id_tarea->viewAttributes() ?>>
<?= $Grid->id_tarea->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_id_tarea" id="ftareasgrid$x<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_id_tarea" id="ftareasgrid$o<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_tarea" id="x<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo" <?= $Grid->id_grupo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_id_grupo" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_id_grupo"
        name="x<?= $Grid->RowIndex ?>_id_grupo"
        class="form-control ew-select<?= $Grid->id_grupo->isInvalidClass() ?>"
        data-select2-id="tareas_x<?= $Grid->RowIndex ?>_id_grupo"
        data-table="tareas"
        data-field="x_id_grupo"
        data-value-separator="<?= $Grid->id_grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_grupo->getPlaceHolder()) ?>"
        <?= $Grid->id_grupo->editAttributes() ?>>
        <?= $Grid->id_grupo->selectOptionListHtml("x{$Grid->RowIndex}_id_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->id_grupo->getErrorMessage() ?></div>
<?= $Grid->id_grupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='tareas_x<?= $Grid->RowIndex ?>_id_grupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_grupo", selectId: "tareas_x<?= $Grid->RowIndex ?>_id_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.tareas.fields.id_grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tareas" data-field="x_id_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_grupo" id="o<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_id_grupo" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_id_grupo"
        name="x<?= $Grid->RowIndex ?>_id_grupo"
        class="form-control ew-select<?= $Grid->id_grupo->isInvalidClass() ?>"
        data-select2-id="tareas_x<?= $Grid->RowIndex ?>_id_grupo"
        data-table="tareas"
        data-field="x_id_grupo"
        data-value-separator="<?= $Grid->id_grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_grupo->getPlaceHolder()) ?>"
        <?= $Grid->id_grupo->editAttributes() ?>>
        <?= $Grid->id_grupo->selectOptionListHtml("x{$Grid->RowIndex}_id_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->id_grupo->getErrorMessage() ?></div>
<?= $Grid->id_grupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='tareas_x<?= $Grid->RowIndex ?>_id_grupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_grupo", selectId: "tareas_x<?= $Grid->RowIndex ?>_id_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.tareas.fields.id_grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_id_grupo">
<span<?= $Grid->id_grupo->viewAttributes() ?>>
<?= $Grid->id_grupo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_id_grupo" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_id_grupo" id="ftareasgrid$x<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_id_grupo" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_id_grupo" id="ftareasgrid$o<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->titulo_tarea->Visible) { // titulo_tarea ?>
        <td data-name="titulo_tarea" <?= $Grid->titulo_tarea->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_titulo_tarea" class="form-group">
<input type="<?= $Grid->titulo_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_titulo_tarea" name="x<?= $Grid->RowIndex ?>_titulo_tarea" id="x<?= $Grid->RowIndex ?>_titulo_tarea" size="50" maxlength="50" placeholder="<?= HtmlEncode($Grid->titulo_tarea->getPlaceHolder()) ?>" value="<?= $Grid->titulo_tarea->EditValue ?>"<?= $Grid->titulo_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titulo_tarea->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="tareas" data-field="x_titulo_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_titulo_tarea" id="o<?= $Grid->RowIndex ?>_titulo_tarea" value="<?= HtmlEncode($Grid->titulo_tarea->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_titulo_tarea" class="form-group">
<input type="<?= $Grid->titulo_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_titulo_tarea" name="x<?= $Grid->RowIndex ?>_titulo_tarea" id="x<?= $Grid->RowIndex ?>_titulo_tarea" size="50" maxlength="50" placeholder="<?= HtmlEncode($Grid->titulo_tarea->getPlaceHolder()) ?>" value="<?= $Grid->titulo_tarea->EditValue ?>"<?= $Grid->titulo_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titulo_tarea->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_titulo_tarea">
<span<?= $Grid->titulo_tarea->viewAttributes() ?>>
<?= $Grid->titulo_tarea->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_titulo_tarea" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_titulo_tarea" id="ftareasgrid$x<?= $Grid->RowIndex ?>_titulo_tarea" value="<?= HtmlEncode($Grid->titulo_tarea->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_titulo_tarea" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_titulo_tarea" id="ftareasgrid$o<?= $Grid->RowIndex ?>_titulo_tarea" value="<?= HtmlEncode($Grid->titulo_tarea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <td data-name="fechainireal_tarea" <?= $Grid->fechainireal_tarea->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechainireal_tarea" class="form-group">
<input type="<?= $Grid->fechainireal_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainireal_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechainireal_tarea" id="x<?= $Grid->RowIndex ?>_fechainireal_tarea" placeholder="<?= HtmlEncode($Grid->fechainireal_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechainireal_tarea->EditValue ?>"<?= $Grid->fechainireal_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechainireal_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechainireal_tarea->ReadOnly && !$Grid->fechainireal_tarea->Disabled && !isset($Grid->fechainireal_tarea->EditAttrs["readonly"]) && !isset($Grid->fechainireal_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechainireal_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechainireal_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechainireal_tarea" id="o<?= $Grid->RowIndex ?>_fechainireal_tarea" value="<?= HtmlEncode($Grid->fechainireal_tarea->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechainireal_tarea" class="form-group">
<input type="<?= $Grid->fechainireal_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainireal_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechainireal_tarea" id="x<?= $Grid->RowIndex ?>_fechainireal_tarea" placeholder="<?= HtmlEncode($Grid->fechainireal_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechainireal_tarea->EditValue ?>"<?= $Grid->fechainireal_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechainireal_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechainireal_tarea->ReadOnly && !$Grid->fechainireal_tarea->Disabled && !isset($Grid->fechainireal_tarea->EditAttrs["readonly"]) && !isset($Grid->fechainireal_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechainireal_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechainireal_tarea">
<span<?= $Grid->fechainireal_tarea->viewAttributes() ?>>
<?= $Grid->fechainireal_tarea->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_fechainireal_tarea" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_fechainireal_tarea" id="ftareasgrid$x<?= $Grid->RowIndex ?>_fechainireal_tarea" value="<?= HtmlEncode($Grid->fechainireal_tarea->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_fechainireal_tarea" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_fechainireal_tarea" id="ftareasgrid$o<?= $Grid->RowIndex ?>_fechainireal_tarea" value="<?= HtmlEncode($Grid->fechainireal_tarea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <td data-name="fechafin_tarea" <?= $Grid->fechafin_tarea->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechafin_tarea" class="form-group">
<input type="<?= $Grid->fechafin_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafin_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechafin_tarea" id="x<?= $Grid->RowIndex ?>_fechafin_tarea" placeholder="<?= HtmlEncode($Grid->fechafin_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechafin_tarea->EditValue ?>"<?= $Grid->fechafin_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechafin_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechafin_tarea->ReadOnly && !$Grid->fechafin_tarea->Disabled && !isset($Grid->fechafin_tarea->EditAttrs["readonly"]) && !isset($Grid->fechafin_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechafin_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechafin_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechafin_tarea" id="o<?= $Grid->RowIndex ?>_fechafin_tarea" value="<?= HtmlEncode($Grid->fechafin_tarea->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechafin_tarea" class="form-group">
<input type="<?= $Grid->fechafin_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafin_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechafin_tarea" id="x<?= $Grid->RowIndex ?>_fechafin_tarea" placeholder="<?= HtmlEncode($Grid->fechafin_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechafin_tarea->EditValue ?>"<?= $Grid->fechafin_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechafin_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechafin_tarea->ReadOnly && !$Grid->fechafin_tarea->Disabled && !isset($Grid->fechafin_tarea->EditAttrs["readonly"]) && !isset($Grid->fechafin_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechafin_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechafin_tarea">
<span<?= $Grid->fechafin_tarea->viewAttributes() ?>>
<?= $Grid->fechafin_tarea->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_fechafin_tarea" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_fechafin_tarea" id="ftareasgrid$x<?= $Grid->RowIndex ?>_fechafin_tarea" value="<?= HtmlEncode($Grid->fechafin_tarea->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_fechafin_tarea" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_fechafin_tarea" id="ftareasgrid$o<?= $Grid->RowIndex ?>_fechafin_tarea" value="<?= HtmlEncode($Grid->fechafin_tarea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <td data-name="fechainisimulado_tarea" <?= $Grid->fechainisimulado_tarea->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechainisimulado_tarea" class="form-group">
<input type="<?= $Grid->fechainisimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainisimulado_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" placeholder="<?= HtmlEncode($Grid->fechainisimulado_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechainisimulado_tarea->EditValue ?>"<?= $Grid->fechainisimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechainisimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechainisimulado_tarea->ReadOnly && !$Grid->fechainisimulado_tarea->Disabled && !isset($Grid->fechainisimulado_tarea->EditAttrs["readonly"]) && !isset($Grid->fechainisimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechainisimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechainisimulado_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="o<?= $Grid->RowIndex ?>_fechainisimulado_tarea" value="<?= HtmlEncode($Grid->fechainisimulado_tarea->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechainisimulado_tarea" class="form-group">
<input type="<?= $Grid->fechainisimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainisimulado_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" placeholder="<?= HtmlEncode($Grid->fechainisimulado_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechainisimulado_tarea->EditValue ?>"<?= $Grid->fechainisimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechainisimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechainisimulado_tarea->ReadOnly && !$Grid->fechainisimulado_tarea->Disabled && !isset($Grid->fechainisimulado_tarea->EditAttrs["readonly"]) && !isset($Grid->fechainisimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechainisimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechainisimulado_tarea">
<span<?= $Grid->fechainisimulado_tarea->viewAttributes() ?>>
<?= $Grid->fechainisimulado_tarea->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_fechainisimulado_tarea" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="ftareasgrid$x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" value="<?= HtmlEncode($Grid->fechainisimulado_tarea->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_fechainisimulado_tarea" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="ftareasgrid$o<?= $Grid->RowIndex ?>_fechainisimulado_tarea" value="<?= HtmlEncode($Grid->fechainisimulado_tarea->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <td data-name="fechafinsimulado_tarea" <?= $Grid->fechafinsimulado_tarea->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechafinsimulado_tarea" class="form-group">
<input type="<?= $Grid->fechafinsimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" placeholder="<?= HtmlEncode($Grid->fechafinsimulado_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechafinsimulado_tarea->EditValue ?>"<?= $Grid->fechafinsimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechafinsimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechafinsimulado_tarea->ReadOnly && !$Grid->fechafinsimulado_tarea->Disabled && !isset($Grid->fechafinsimulado_tarea->EditAttrs["readonly"]) && !isset($Grid->fechafinsimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="o<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" value="<?= HtmlEncode($Grid->fechafinsimulado_tarea->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechafinsimulado_tarea" class="form-group">
<input type="<?= $Grid->fechafinsimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" placeholder="<?= HtmlEncode($Grid->fechafinsimulado_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechafinsimulado_tarea->EditValue ?>"<?= $Grid->fechafinsimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechafinsimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechafinsimulado_tarea->ReadOnly && !$Grid->fechafinsimulado_tarea->Disabled && !isset($Grid->fechafinsimulado_tarea->EditAttrs["readonly"]) && !isset($Grid->fechafinsimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tareas_fechafinsimulado_tarea">
<span<?= $Grid->fechafinsimulado_tarea->viewAttributes() ?>>
<?= $Grid->fechafinsimulado_tarea->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-hidden="1" name="ftareasgrid$x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="ftareasgrid$x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" value="<?= HtmlEncode($Grid->fechafinsimulado_tarea->FormValue) ?>">
<input type="hidden" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-hidden="1" name="ftareasgrid$o<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="ftareasgrid$o<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" value="<?= HtmlEncode($Grid->fechafinsimulado_tarea->OldValue) ?>">
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
loadjs.ready(["ftareasgrid","load"], function () {
    ftareasgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_tareas", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->id_tarea->Visible) { // id_tarea ?>
        <td data-name="id_tarea">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_id_tarea" class="form-group tareas_id_tarea"></span>
<?php } else { ?>
<span id="el$rowindex$_tareas_id_tarea" class="form-group tareas_id_tarea">
<span<?= $Grid->id_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_tarea->getDisplayValue($Grid->id_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_tarea" id="x<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_id_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_tarea" id="o<?= $Grid->RowIndex ?>_id_tarea" value="<?= HtmlEncode($Grid->id_tarea->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->id_grupo->Visible) { // id_grupo ?>
        <td data-name="id_grupo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_id_grupo" class="form-group tareas_id_grupo">
    <select
        id="x<?= $Grid->RowIndex ?>_id_grupo"
        name="x<?= $Grid->RowIndex ?>_id_grupo"
        class="form-control ew-select<?= $Grid->id_grupo->isInvalidClass() ?>"
        data-select2-id="tareas_x<?= $Grid->RowIndex ?>_id_grupo"
        data-table="tareas"
        data-field="x_id_grupo"
        data-value-separator="<?= $Grid->id_grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_grupo->getPlaceHolder()) ?>"
        <?= $Grid->id_grupo->editAttributes() ?>>
        <?= $Grid->id_grupo->selectOptionListHtml("x{$Grid->RowIndex}_id_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->id_grupo->getErrorMessage() ?></div>
<?= $Grid->id_grupo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='tareas_x<?= $Grid->RowIndex ?>_id_grupo']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_grupo", selectId: "tareas_x<?= $Grid->RowIndex ?>_id_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.tareas.fields.id_grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_tareas_id_grupo" class="form-group tareas_id_grupo">
<span<?= $Grid->id_grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_grupo->getDisplayValue($Grid->id_grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_id_grupo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_grupo" id="x<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_id_grupo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_grupo" id="o<?= $Grid->RowIndex ?>_id_grupo" value="<?= HtmlEncode($Grid->id_grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->titulo_tarea->Visible) { // titulo_tarea ?>
        <td data-name="titulo_tarea">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_titulo_tarea" class="form-group tareas_titulo_tarea">
<input type="<?= $Grid->titulo_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_titulo_tarea" name="x<?= $Grid->RowIndex ?>_titulo_tarea" id="x<?= $Grid->RowIndex ?>_titulo_tarea" size="50" maxlength="50" placeholder="<?= HtmlEncode($Grid->titulo_tarea->getPlaceHolder()) ?>" value="<?= $Grid->titulo_tarea->EditValue ?>"<?= $Grid->titulo_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titulo_tarea->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_tareas_titulo_tarea" class="form-group tareas_titulo_tarea">
<span<?= $Grid->titulo_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->titulo_tarea->getDisplayValue($Grid->titulo_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_titulo_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_titulo_tarea" id="x<?= $Grid->RowIndex ?>_titulo_tarea" value="<?= HtmlEncode($Grid->titulo_tarea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_titulo_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_titulo_tarea" id="o<?= $Grid->RowIndex ?>_titulo_tarea" value="<?= HtmlEncode($Grid->titulo_tarea->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <td data-name="fechainireal_tarea">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_fechainireal_tarea" class="form-group tareas_fechainireal_tarea">
<input type="<?= $Grid->fechainireal_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainireal_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechainireal_tarea" id="x<?= $Grid->RowIndex ?>_fechainireal_tarea" placeholder="<?= HtmlEncode($Grid->fechainireal_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechainireal_tarea->EditValue ?>"<?= $Grid->fechainireal_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechainireal_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechainireal_tarea->ReadOnly && !$Grid->fechainireal_tarea->Disabled && !isset($Grid->fechainireal_tarea->EditAttrs["readonly"]) && !isset($Grid->fechainireal_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechainireal_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tareas_fechainireal_tarea" class="form-group tareas_fechainireal_tarea">
<span<?= $Grid->fechainireal_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fechainireal_tarea->getDisplayValue($Grid->fechainireal_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechainireal_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fechainireal_tarea" id="x<?= $Grid->RowIndex ?>_fechainireal_tarea" value="<?= HtmlEncode($Grid->fechainireal_tarea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_fechainireal_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechainireal_tarea" id="o<?= $Grid->RowIndex ?>_fechainireal_tarea" value="<?= HtmlEncode($Grid->fechainireal_tarea->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <td data-name="fechafin_tarea">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_fechafin_tarea" class="form-group tareas_fechafin_tarea">
<input type="<?= $Grid->fechafin_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafin_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechafin_tarea" id="x<?= $Grid->RowIndex ?>_fechafin_tarea" placeholder="<?= HtmlEncode($Grid->fechafin_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechafin_tarea->EditValue ?>"<?= $Grid->fechafin_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechafin_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechafin_tarea->ReadOnly && !$Grid->fechafin_tarea->Disabled && !isset($Grid->fechafin_tarea->EditAttrs["readonly"]) && !isset($Grid->fechafin_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechafin_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tareas_fechafin_tarea" class="form-group tareas_fechafin_tarea">
<span<?= $Grid->fechafin_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fechafin_tarea->getDisplayValue($Grid->fechafin_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechafin_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fechafin_tarea" id="x<?= $Grid->RowIndex ?>_fechafin_tarea" value="<?= HtmlEncode($Grid->fechafin_tarea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_fechafin_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechafin_tarea" id="o<?= $Grid->RowIndex ?>_fechafin_tarea" value="<?= HtmlEncode($Grid->fechafin_tarea->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <td data-name="fechainisimulado_tarea">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_fechainisimulado_tarea" class="form-group tareas_fechainisimulado_tarea">
<input type="<?= $Grid->fechainisimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainisimulado_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" placeholder="<?= HtmlEncode($Grid->fechainisimulado_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechainisimulado_tarea->EditValue ?>"<?= $Grid->fechainisimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechainisimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechainisimulado_tarea->ReadOnly && !$Grid->fechainisimulado_tarea->Disabled && !isset($Grid->fechainisimulado_tarea->EditAttrs["readonly"]) && !isset($Grid->fechainisimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechainisimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tareas_fechainisimulado_tarea" class="form-group tareas_fechainisimulado_tarea">
<span<?= $Grid->fechainisimulado_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fechainisimulado_tarea->getDisplayValue($Grid->fechainisimulado_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechainisimulado_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechainisimulado_tarea" value="<?= HtmlEncode($Grid->fechainisimulado_tarea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_fechainisimulado_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechainisimulado_tarea" id="o<?= $Grid->RowIndex ?>_fechainisimulado_tarea" value="<?= HtmlEncode($Grid->fechainisimulado_tarea->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <td data-name="fechafinsimulado_tarea">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tareas_fechafinsimulado_tarea" class="form-group tareas_fechafinsimulado_tarea">
<input type="<?= $Grid->fechafinsimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-format="109" name="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" placeholder="<?= HtmlEncode($Grid->fechafinsimulado_tarea->getPlaceHolder()) ?>" value="<?= $Grid->fechafinsimulado_tarea->EditValue ?>"<?= $Grid->fechafinsimulado_tarea->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechafinsimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Grid->fechafinsimulado_tarea->ReadOnly && !$Grid->fechafinsimulado_tarea->Disabled && !isset($Grid->fechafinsimulado_tarea->EditAttrs["readonly"]) && !isset($Grid->fechafinsimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasgrid", "x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tareas_fechafinsimulado_tarea" class="form-group tareas_fechafinsimulado_tarea">
<span<?= $Grid->fechafinsimulado_tarea->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fechafinsimulado_tarea->getDisplayValue($Grid->fechafinsimulado_tarea->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="x<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" value="<?= HtmlEncode($Grid->fechafinsimulado_tarea->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" id="o<?= $Grid->RowIndex ?>_fechafinsimulado_tarea" value="<?= HtmlEncode($Grid->fechafinsimulado_tarea->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ftareasgrid","load"], function() {
    ftareasgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="ftareasgrid">
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
