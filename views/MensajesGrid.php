<?php

namespace PHPMaker2021\simexamerica;

// Set up and run Grid object
$Grid = Container("MensajesGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmensajesgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fmensajesgrid = new ew.Form("fmensajesgrid", "grid");
    fmensajesgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "mensajes")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.mensajes)
        ew.vars.tables.mensajes = currentTable;
    fmensajesgrid.addFields([
        ["id_inyect", [fields.id_inyect.visible && fields.id_inyect.required ? ew.Validators.required(fields.id_inyect.caption) : null], fields.id_inyect.isInvalid],
        ["titulo", [fields.titulo.visible && fields.titulo.required ? ew.Validators.required(fields.titulo.caption) : null], fields.titulo.isInvalid],
        ["mensaje", [fields.mensaje.visible && fields.mensaje.required ? ew.Validators.required(fields.mensaje.caption) : null], fields.mensaje.isInvalid],
        ["fechareal_start", [fields.fechareal_start.visible && fields.fechareal_start.required ? ew.Validators.required(fields.fechareal_start.caption) : null, ew.Validators.datetime(109)], fields.fechareal_start.isInvalid],
        ["fechasim_start", [fields.fechasim_start.visible && fields.fechasim_start.required ? ew.Validators.required(fields.fechasim_start.caption) : null, ew.Validators.datetime(109)], fields.fechasim_start.isInvalid],
        ["id_actor", [fields.id_actor.visible && fields.id_actor.required ? ew.Validators.required(fields.id_actor.caption) : null], fields.id_actor.isInvalid],
        ["para", [fields.para.visible && fields.para.required ? ew.Validators.required(fields.para.caption) : null], fields.para.isInvalid],
        ["adjunto", [fields.adjunto.visible && fields.adjunto.required ? ew.Validators.fileRequired(fields.adjunto.caption) : null], fields.adjunto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmensajesgrid,
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
    fmensajesgrid.validate = function () {
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
    fmensajesgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "titulo", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "mensaje", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fechareal_start", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fechasim_start", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "id_actor", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "para[]", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "adjunto", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fmensajesgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmensajesgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fmensajesgrid.lists.id_actor = <?= $Grid->id_actor->toClientList($Grid) ?>;
    fmensajesgrid.lists.para = <?= $Grid->para->toClientList($Grid) ?>;
    loadjs.done("fmensajesgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> mensajes">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="fmensajesgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_mensajes" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_mensajesgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->id_inyect->Visible) { // id_inyect ?>
        <th data-name="id_inyect" class="<?= $Grid->id_inyect->headerCellClass() ?>"><div id="elh_mensajes_id_inyect" class="mensajes_id_inyect"><?= $Grid->renderSort($Grid->id_inyect) ?></div></th>
<?php } ?>
<?php if ($Grid->titulo->Visible) { // titulo ?>
        <th data-name="titulo" class="<?= $Grid->titulo->headerCellClass() ?>"><div id="elh_mensajes_titulo" class="mensajes_titulo"><?= $Grid->renderSort($Grid->titulo) ?></div></th>
<?php } ?>
<?php if ($Grid->mensaje->Visible) { // mensaje ?>
        <th data-name="mensaje" class="<?= $Grid->mensaje->headerCellClass() ?>"><div id="elh_mensajes_mensaje" class="mensajes_mensaje"><?= $Grid->renderSort($Grid->mensaje) ?></div></th>
<?php } ?>
<?php if ($Grid->fechareal_start->Visible) { // fechareal_start ?>
        <th data-name="fechareal_start" class="<?= $Grid->fechareal_start->headerCellClass() ?>"><div id="elh_mensajes_fechareal_start" class="mensajes_fechareal_start"><?= $Grid->renderSort($Grid->fechareal_start) ?></div></th>
<?php } ?>
<?php if ($Grid->fechasim_start->Visible) { // fechasim_start ?>
        <th data-name="fechasim_start" class="<?= $Grid->fechasim_start->headerCellClass() ?>"><div id="elh_mensajes_fechasim_start" class="mensajes_fechasim_start"><?= $Grid->renderSort($Grid->fechasim_start) ?></div></th>
<?php } ?>
<?php if ($Grid->id_actor->Visible) { // id_actor ?>
        <th data-name="id_actor" class="<?= $Grid->id_actor->headerCellClass() ?>"><div id="elh_mensajes_id_actor" class="mensajes_id_actor"><?= $Grid->renderSort($Grid->id_actor) ?></div></th>
<?php } ?>
<?php if ($Grid->para->Visible) { // para ?>
        <th data-name="para" class="<?= $Grid->para->headerCellClass() ?>"><div id="elh_mensajes_para" class="mensajes_para"><?= $Grid->renderSort($Grid->para) ?></div></th>
<?php } ?>
<?php if ($Grid->adjunto->Visible) { // adjunto ?>
        <th data-name="adjunto" class="<?= $Grid->adjunto->headerCellClass() ?>"><div id="elh_mensajes_adjunto" class="mensajes_adjunto"><?= $Grid->renderSort($Grid->adjunto) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_mensajes", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->id_inyect->Visible) { // id_inyect ?>
        <td data-name="id_inyect" <?= $Grid->id_inyect->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_id_inyect" class="form-group"></span>
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_inyect" id="o<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_id_inyect" class="form-group">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_inyect->getDisplayValue($Grid->id_inyect->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_id_inyect">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<?= $Grid->id_inyect->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_id_inyect" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_id_inyect" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->titulo->Visible) { // titulo ?>
        <td data-name="titulo" <?= $Grid->titulo->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_titulo" class="form-group">
<input type="<?= $Grid->titulo->getInputTextType() ?>" data-table="mensajes" data-field="x_titulo" name="x<?= $Grid->RowIndex ?>_titulo" id="x<?= $Grid->RowIndex ?>_titulo" size="50" maxlength="100" placeholder="<?= HtmlEncode($Grid->titulo->getPlaceHolder()) ?>" value="<?= $Grid->titulo->EditValue ?>"<?= $Grid->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titulo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="mensajes" data-field="x_titulo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_titulo" id="o<?= $Grid->RowIndex ?>_titulo" value="<?= HtmlEncode($Grid->titulo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_titulo" class="form-group">
<input type="<?= $Grid->titulo->getInputTextType() ?>" data-table="mensajes" data-field="x_titulo" name="x<?= $Grid->RowIndex ?>_titulo" id="x<?= $Grid->RowIndex ?>_titulo" size="50" maxlength="100" placeholder="<?= HtmlEncode($Grid->titulo->getPlaceHolder()) ?>" value="<?= $Grid->titulo->EditValue ?>"<?= $Grid->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titulo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_titulo">
<span<?= $Grid->titulo->viewAttributes() ?>>
<?php if (!EmptyString($Grid->titulo->TooltipValue) && $Grid->titulo->linkAttributes() != "") { ?>
<a<?= $Grid->titulo->linkAttributes() ?>><?= $Grid->titulo->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->titulo->getViewValue() ?>
<?php } ?>
<span id="tt_mensajes_x<?= $Grid->RowCount ?>_titulo" class="d-none">
<?= $Grid->titulo->TooltipValue ?>
</span></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_titulo" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_titulo" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_titulo" value="<?= HtmlEncode($Grid->titulo->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_titulo" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_titulo" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_titulo" value="<?= HtmlEncode($Grid->titulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->mensaje->Visible) { // mensaje ?>
        <td data-name="mensaje" <?= $Grid->mensaje->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_mensaje" class="form-group">
<?php $Grid->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="mensajes" data-field="x_mensaje" name="x<?= $Grid->RowIndex ?>_mensaje" id="x<?= $Grid->RowIndex ?>_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->mensaje->getPlaceHolder()) ?>"<?= $Grid->mensaje->editAttributes() ?>><?= $Grid->mensaje->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmensajesgrid", "editor"], function() {
	ew.createEditor("fmensajesgrid", "x<?= $Grid->RowIndex ?>_mensaje", 35, 4, <?= $Grid->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
<input type="hidden" data-table="mensajes" data-field="x_mensaje" data-hidden="1" name="o<?= $Grid->RowIndex ?>_mensaje" id="o<?= $Grid->RowIndex ?>_mensaje" value="<?= HtmlEncode($Grid->mensaje->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_mensaje" class="form-group">
<?php $Grid->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="mensajes" data-field="x_mensaje" name="x<?= $Grid->RowIndex ?>_mensaje" id="x<?= $Grid->RowIndex ?>_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->mensaje->getPlaceHolder()) ?>"<?= $Grid->mensaje->editAttributes() ?>><?= $Grid->mensaje->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmensajesgrid", "editor"], function() {
	ew.createEditor("fmensajesgrid", "x<?= $Grid->RowIndex ?>_mensaje", 35, 4, <?= $Grid->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_mensaje">
<span<?= $Grid->mensaje->viewAttributes() ?>>
<?= $Grid->mensaje->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_mensaje" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_mensaje" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_mensaje" value="<?= HtmlEncode($Grid->mensaje->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_mensaje" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_mensaje" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_mensaje" value="<?= HtmlEncode($Grid->mensaje->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechareal_start->Visible) { // fechareal_start ?>
        <td data-name="fechareal_start" <?= $Grid->fechareal_start->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_fechareal_start" class="form-group">
<input type="<?= $Grid->fechareal_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechareal_start" data-format="109" name="x<?= $Grid->RowIndex ?>_fechareal_start" id="x<?= $Grid->RowIndex ?>_fechareal_start" placeholder="<?= HtmlEncode($Grid->fechareal_start->getPlaceHolder()) ?>" value="<?= $Grid->fechareal_start->EditValue ?>"<?= $Grid->fechareal_start->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechareal_start->getErrorMessage() ?></div>
<?php if (!$Grid->fechareal_start->ReadOnly && !$Grid->fechareal_start->Disabled && !isset($Grid->fechareal_start->EditAttrs["readonly"]) && !isset($Grid->fechareal_start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmensajesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmensajesgrid", "x<?= $Grid->RowIndex ?>_fechareal_start", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="mensajes" data-field="x_fechareal_start" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechareal_start" id="o<?= $Grid->RowIndex ?>_fechareal_start" value="<?= HtmlEncode($Grid->fechareal_start->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_fechareal_start" class="form-group">
<input type="<?= $Grid->fechareal_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechareal_start" data-format="109" name="x<?= $Grid->RowIndex ?>_fechareal_start" id="x<?= $Grid->RowIndex ?>_fechareal_start" placeholder="<?= HtmlEncode($Grid->fechareal_start->getPlaceHolder()) ?>" value="<?= $Grid->fechareal_start->EditValue ?>"<?= $Grid->fechareal_start->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechareal_start->getErrorMessage() ?></div>
<?php if (!$Grid->fechareal_start->ReadOnly && !$Grid->fechareal_start->Disabled && !isset($Grid->fechareal_start->EditAttrs["readonly"]) && !isset($Grid->fechareal_start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmensajesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmensajesgrid", "x<?= $Grid->RowIndex ?>_fechareal_start", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_fechareal_start">
<span<?= $Grid->fechareal_start->viewAttributes() ?>>
<?= $Grid->fechareal_start->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_fechareal_start" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_fechareal_start" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_fechareal_start" value="<?= HtmlEncode($Grid->fechareal_start->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_fechareal_start" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_fechareal_start" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_fechareal_start" value="<?= HtmlEncode($Grid->fechareal_start->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fechasim_start->Visible) { // fechasim_start ?>
        <td data-name="fechasim_start" <?= $Grid->fechasim_start->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_fechasim_start" class="form-group">
<input type="<?= $Grid->fechasim_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechasim_start" data-format="109" name="x<?= $Grid->RowIndex ?>_fechasim_start" id="x<?= $Grid->RowIndex ?>_fechasim_start" placeholder="<?= HtmlEncode($Grid->fechasim_start->getPlaceHolder()) ?>" value="<?= $Grid->fechasim_start->EditValue ?>"<?= $Grid->fechasim_start->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechasim_start->getErrorMessage() ?></div>
<?php if (!$Grid->fechasim_start->ReadOnly && !$Grid->fechasim_start->Disabled && !isset($Grid->fechasim_start->EditAttrs["readonly"]) && !isset($Grid->fechasim_start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmensajesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmensajesgrid", "x<?= $Grid->RowIndex ?>_fechasim_start", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="mensajes" data-field="x_fechasim_start" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechasim_start" id="o<?= $Grid->RowIndex ?>_fechasim_start" value="<?= HtmlEncode($Grid->fechasim_start->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_fechasim_start" class="form-group">
<input type="<?= $Grid->fechasim_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechasim_start" data-format="109" name="x<?= $Grid->RowIndex ?>_fechasim_start" id="x<?= $Grid->RowIndex ?>_fechasim_start" placeholder="<?= HtmlEncode($Grid->fechasim_start->getPlaceHolder()) ?>" value="<?= $Grid->fechasim_start->EditValue ?>"<?= $Grid->fechasim_start->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechasim_start->getErrorMessage() ?></div>
<?php if (!$Grid->fechasim_start->ReadOnly && !$Grid->fechasim_start->Disabled && !isset($Grid->fechasim_start->EditAttrs["readonly"]) && !isset($Grid->fechasim_start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmensajesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmensajesgrid", "x<?= $Grid->RowIndex ?>_fechasim_start", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_fechasim_start">
<span<?= $Grid->fechasim_start->viewAttributes() ?>>
<?= $Grid->fechasim_start->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_fechasim_start" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_fechasim_start" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_fechasim_start" value="<?= HtmlEncode($Grid->fechasim_start->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_fechasim_start" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_fechasim_start" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_fechasim_start" value="<?= HtmlEncode($Grid->fechasim_start->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->id_actor->Visible) { // id_actor ?>
        <td data-name="id_actor" <?= $Grid->id_actor->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_id_actor" class="form-group">
<div class="input-group flex-nowrap">
    <select
        id="x<?= $Grid->RowIndex ?>_id_actor"
        name="x<?= $Grid->RowIndex ?>_id_actor"
        class="form-control ew-select<?= $Grid->id_actor->isInvalidClass() ?>"
        data-select2-id="mensajes_x<?= $Grid->RowIndex ?>_id_actor"
        data-table="mensajes"
        data-field="x_id_actor"
        data-value-separator="<?= $Grid->id_actor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_actor->getPlaceHolder()) ?>"
        <?= $Grid->id_actor->editAttributes() ?>>
        <?= $Grid->id_actor->selectOptionListHtml("x{$Grid->RowIndex}_id_actor") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "actor_simulado") && !$Grid->id_actor->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?= $Grid->RowIndex ?>_id_actor" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Grid->id_actor->caption() ?>" data-title="<?= $Grid->id_actor->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_id_actor',url:'<?= GetUrl("ActorSimuladoAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<div class="invalid-feedback"><?= $Grid->id_actor->getErrorMessage() ?></div>
<?= $Grid->id_actor->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_actor") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x<?= $Grid->RowIndex ?>_id_actor']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_actor", selectId: "mensajes_x<?= $Grid->RowIndex ?>_id_actor", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.id_actor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="mensajes" data-field="x_id_actor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_actor" id="o<?= $Grid->RowIndex ?>_id_actor" value="<?= HtmlEncode($Grid->id_actor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_id_actor" class="form-group">
<div class="input-group flex-nowrap">
    <select
        id="x<?= $Grid->RowIndex ?>_id_actor"
        name="x<?= $Grid->RowIndex ?>_id_actor"
        class="form-control ew-select<?= $Grid->id_actor->isInvalidClass() ?>"
        data-select2-id="mensajes_x<?= $Grid->RowIndex ?>_id_actor"
        data-table="mensajes"
        data-field="x_id_actor"
        data-value-separator="<?= $Grid->id_actor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_actor->getPlaceHolder()) ?>"
        <?= $Grid->id_actor->editAttributes() ?>>
        <?= $Grid->id_actor->selectOptionListHtml("x{$Grid->RowIndex}_id_actor") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "actor_simulado") && !$Grid->id_actor->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?= $Grid->RowIndex ?>_id_actor" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Grid->id_actor->caption() ?>" data-title="<?= $Grid->id_actor->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_id_actor',url:'<?= GetUrl("ActorSimuladoAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<div class="invalid-feedback"><?= $Grid->id_actor->getErrorMessage() ?></div>
<?= $Grid->id_actor->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_actor") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x<?= $Grid->RowIndex ?>_id_actor']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_actor", selectId: "mensajes_x<?= $Grid->RowIndex ?>_id_actor", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.id_actor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_id_actor">
<span<?= $Grid->id_actor->viewAttributes() ?>>
<?= $Grid->id_actor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_id_actor" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_id_actor" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_id_actor" value="<?= HtmlEncode($Grid->id_actor->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_id_actor" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_id_actor" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_id_actor" value="<?= HtmlEncode($Grid->id_actor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->para->Visible) { // para ?>
        <td data-name="para" <?= $Grid->para->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_para" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_para"><?= EmptyValue(strval($Grid->para->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->para->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->para->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->para->ReadOnly || $Grid->para->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_para[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->para->getErrorMessage() ?></div>
<?= $Grid->para->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_para") ?>
<input type="hidden" is="selection-list" data-table="mensajes" data-field="x_para" data-type="text" data-multiple="1" data-lookup="1" data-value-separator="<?= $Grid->para->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_para[]" id="x<?= $Grid->RowIndex ?>_para[]" value="<?= $Grid->para->CurrentValue ?>"<?= $Grid->para->editAttributes() ?>>
</span>
<input type="hidden" data-table="mensajes" data-field="x_para" data-hidden="1" name="o<?= $Grid->RowIndex ?>_para[]" id="o<?= $Grid->RowIndex ?>_para[]" value="<?= HtmlEncode($Grid->para->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_para" class="form-group">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_para"><?= EmptyValue(strval($Grid->para->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->para->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->para->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->para->ReadOnly || $Grid->para->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_para[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->para->getErrorMessage() ?></div>
<?= $Grid->para->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_para") ?>
<input type="hidden" is="selection-list" data-table="mensajes" data-field="x_para" data-type="text" data-multiple="1" data-lookup="1" data-value-separator="<?= $Grid->para->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_para[]" id="x<?= $Grid->RowIndex ?>_para[]" value="<?= $Grid->para->CurrentValue ?>"<?= $Grid->para->editAttributes() ?>>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_para">
<span<?= $Grid->para->viewAttributes() ?>>
<?= $Grid->para->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="mensajes" data-field="x_para" data-hidden="1" name="fmensajesgrid$x<?= $Grid->RowIndex ?>_para" id="fmensajesgrid$x<?= $Grid->RowIndex ?>_para" value="<?= HtmlEncode($Grid->para->FormValue) ?>">
<input type="hidden" data-table="mensajes" data-field="x_para" data-hidden="1" name="fmensajesgrid$o<?= $Grid->RowIndex ?>_para[]" id="fmensajesgrid$o<?= $Grid->RowIndex ?>_para[]" value="<?= HtmlEncode($Grid->para->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->adjunto->Visible) { // adjunto ?>
        <td data-name="adjunto" <?= $Grid->adjunto->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_mensajes_adjunto" class="form-group mensajes_adjunto">
<div id="fd_x<?= $Grid->RowIndex ?>_adjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->adjunto->title() ?>" data-table="mensajes" data-field="x_adjunto" name="x<?= $Grid->RowIndex ?>_adjunto" id="x<?= $Grid->RowIndex ?>_adjunto" lang="<?= CurrentLanguageID() ?>"<?= $Grid->adjunto->editAttributes() ?><?= ($Grid->adjunto->ReadOnly || $Grid->adjunto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_adjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->adjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_adjunto" id= "fn_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_adjunto" id= "fa_x<?= $Grid->RowIndex ?>_adjunto" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_adjunto" id= "fs_x<?= $Grid->RowIndex ?>_adjunto" value="60">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_adjunto" id= "fx_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_adjunto" id= "fm_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_adjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="mensajes" data-field="x_adjunto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_adjunto" id="o<?= $Grid->RowIndex ?>_adjunto" value="<?= HtmlEncode($Grid->adjunto->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_adjunto">
<span<?= $Grid->adjunto->viewAttributes() ?>>
<?= GetFileViewTag($Grid->adjunto, $Grid->adjunto->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_mensajes_adjunto" class="form-group mensajes_adjunto">
<div id="fd_x<?= $Grid->RowIndex ?>_adjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->adjunto->title() ?>" data-table="mensajes" data-field="x_adjunto" name="x<?= $Grid->RowIndex ?>_adjunto" id="x<?= $Grid->RowIndex ?>_adjunto" lang="<?= CurrentLanguageID() ?>"<?= $Grid->adjunto->editAttributes() ?><?= ($Grid->adjunto->ReadOnly || $Grid->adjunto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_adjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->adjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_adjunto" id= "fn_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_adjunto" id= "fa_x<?= $Grid->RowIndex ?>_adjunto" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_adjunto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_adjunto" id= "fs_x<?= $Grid->RowIndex ?>_adjunto" value="60">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_adjunto" id= "fx_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_adjunto" id= "fm_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_adjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
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
loadjs.ready(["fmensajesgrid","load"], function () {
    fmensajesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_mensajes", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->id_inyect->Visible) { // id_inyect ?>
        <td data-name="id_inyect">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_id_inyect" class="form-group mensajes_id_inyect"></span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_id_inyect" class="form-group mensajes_id_inyect">
<span<?= $Grid->id_inyect->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_inyect->getDisplayValue($Grid->id_inyect->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_inyect" id="x<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_id_inyect" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_inyect" id="o<?= $Grid->RowIndex ?>_id_inyect" value="<?= HtmlEncode($Grid->id_inyect->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->titulo->Visible) { // titulo ?>
        <td data-name="titulo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_titulo" class="form-group mensajes_titulo">
<input type="<?= $Grid->titulo->getInputTextType() ?>" data-table="mensajes" data-field="x_titulo" name="x<?= $Grid->RowIndex ?>_titulo" id="x<?= $Grid->RowIndex ?>_titulo" size="50" maxlength="100" placeholder="<?= HtmlEncode($Grid->titulo->getPlaceHolder()) ?>" value="<?= $Grid->titulo->EditValue ?>"<?= $Grid->titulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titulo->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_titulo" class="form-group mensajes_titulo">
<span<?= $Grid->titulo->viewAttributes() ?>>
<?php if (!EmptyString($Grid->titulo->TooltipValue) && $Grid->titulo->linkAttributes() != "") { ?>
<a<?= $Grid->titulo->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->titulo->getDisplayValue($Grid->titulo->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->titulo->getDisplayValue($Grid->titulo->ViewValue))) ?>">
<?php } ?>
<span id="tt_mensajes_x<?= $Grid->RowCount ?>_titulo" class="d-none">
<?= $Grid->titulo->TooltipValue ?>
</span></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_titulo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_titulo" id="x<?= $Grid->RowIndex ?>_titulo" value="<?= HtmlEncode($Grid->titulo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_titulo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_titulo" id="o<?= $Grid->RowIndex ?>_titulo" value="<?= HtmlEncode($Grid->titulo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->mensaje->Visible) { // mensaje ?>
        <td data-name="mensaje">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_mensaje" class="form-group mensajes_mensaje">
<?php $Grid->mensaje->EditAttrs->appendClass("editor"); ?>
<textarea data-table="mensajes" data-field="x_mensaje" name="x<?= $Grid->RowIndex ?>_mensaje" id="x<?= $Grid->RowIndex ?>_mensaje" cols="35" rows="4" placeholder="<?= HtmlEncode($Grid->mensaje->getPlaceHolder()) ?>"<?= $Grid->mensaje->editAttributes() ?>><?= $Grid->mensaje->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->mensaje->getErrorMessage() ?></div>
<script>
loadjs.ready(["fmensajesgrid", "editor"], function() {
	ew.createEditor("fmensajesgrid", "x<?= $Grid->RowIndex ?>_mensaje", 35, 4, <?= $Grid->mensaje->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_mensaje" class="form-group mensajes_mensaje">
<span<?= $Grid->mensaje->viewAttributes() ?>>
<?= $Grid->mensaje->ViewValue ?></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_mensaje" data-hidden="1" name="x<?= $Grid->RowIndex ?>_mensaje" id="x<?= $Grid->RowIndex ?>_mensaje" value="<?= HtmlEncode($Grid->mensaje->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_mensaje" data-hidden="1" name="o<?= $Grid->RowIndex ?>_mensaje" id="o<?= $Grid->RowIndex ?>_mensaje" value="<?= HtmlEncode($Grid->mensaje->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fechareal_start->Visible) { // fechareal_start ?>
        <td data-name="fechareal_start">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_fechareal_start" class="form-group mensajes_fechareal_start">
<input type="<?= $Grid->fechareal_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechareal_start" data-format="109" name="x<?= $Grid->RowIndex ?>_fechareal_start" id="x<?= $Grid->RowIndex ?>_fechareal_start" placeholder="<?= HtmlEncode($Grid->fechareal_start->getPlaceHolder()) ?>" value="<?= $Grid->fechareal_start->EditValue ?>"<?= $Grid->fechareal_start->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechareal_start->getErrorMessage() ?></div>
<?php if (!$Grid->fechareal_start->ReadOnly && !$Grid->fechareal_start->Disabled && !isset($Grid->fechareal_start->EditAttrs["readonly"]) && !isset($Grid->fechareal_start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmensajesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmensajesgrid", "x<?= $Grid->RowIndex ?>_fechareal_start", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_fechareal_start" class="form-group mensajes_fechareal_start">
<span<?= $Grid->fechareal_start->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fechareal_start->getDisplayValue($Grid->fechareal_start->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_fechareal_start" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fechareal_start" id="x<?= $Grid->RowIndex ?>_fechareal_start" value="<?= HtmlEncode($Grid->fechareal_start->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_fechareal_start" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechareal_start" id="o<?= $Grid->RowIndex ?>_fechareal_start" value="<?= HtmlEncode($Grid->fechareal_start->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fechasim_start->Visible) { // fechasim_start ?>
        <td data-name="fechasim_start">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_fechasim_start" class="form-group mensajes_fechasim_start">
<input type="<?= $Grid->fechasim_start->getInputTextType() ?>" data-table="mensajes" data-field="x_fechasim_start" data-format="109" name="x<?= $Grid->RowIndex ?>_fechasim_start" id="x<?= $Grid->RowIndex ?>_fechasim_start" placeholder="<?= HtmlEncode($Grid->fechasim_start->getPlaceHolder()) ?>" value="<?= $Grid->fechasim_start->EditValue ?>"<?= $Grid->fechasim_start->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fechasim_start->getErrorMessage() ?></div>
<?php if (!$Grid->fechasim_start->ReadOnly && !$Grid->fechasim_start->Disabled && !isset($Grid->fechasim_start->EditAttrs["readonly"]) && !isset($Grid->fechasim_start->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fmensajesgrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fmensajesgrid", "x<?= $Grid->RowIndex ?>_fechasim_start", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_fechasim_start" class="form-group mensajes_fechasim_start">
<span<?= $Grid->fechasim_start->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fechasim_start->getDisplayValue($Grid->fechasim_start->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_fechasim_start" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fechasim_start" id="x<?= $Grid->RowIndex ?>_fechasim_start" value="<?= HtmlEncode($Grid->fechasim_start->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_fechasim_start" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fechasim_start" id="o<?= $Grid->RowIndex ?>_fechasim_start" value="<?= HtmlEncode($Grid->fechasim_start->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->id_actor->Visible) { // id_actor ?>
        <td data-name="id_actor">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_id_actor" class="form-group mensajes_id_actor">
<div class="input-group flex-nowrap">
    <select
        id="x<?= $Grid->RowIndex ?>_id_actor"
        name="x<?= $Grid->RowIndex ?>_id_actor"
        class="form-control ew-select<?= $Grid->id_actor->isInvalidClass() ?>"
        data-select2-id="mensajes_x<?= $Grid->RowIndex ?>_id_actor"
        data-table="mensajes"
        data-field="x_id_actor"
        data-value-separator="<?= $Grid->id_actor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->id_actor->getPlaceHolder()) ?>"
        <?= $Grid->id_actor->editAttributes() ?>>
        <?= $Grid->id_actor->selectOptionListHtml("x{$Grid->RowIndex}_id_actor") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "actor_simulado") && !$Grid->id_actor->ReadOnly) { ?>
    <div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?= $Grid->RowIndex ?>_id_actor" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Grid->id_actor->caption() ?>" data-title="<?= $Grid->id_actor->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_id_actor',url:'<?= GetUrl("ActorSimuladoAddopt") ?>'});"><i class="fas fa-plus ew-icon"></i></button></div>
    <?php } ?>
</div>
<div class="invalid-feedback"><?= $Grid->id_actor->getErrorMessage() ?></div>
<?= $Grid->id_actor->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_id_actor") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='mensajes_x<?= $Grid->RowIndex ?>_id_actor']"),
        options = { name: "x<?= $Grid->RowIndex ?>_id_actor", selectId: "mensajes_x<?= $Grid->RowIndex ?>_id_actor", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.mensajes.fields.id_actor.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_id_actor" class="form-group mensajes_id_actor">
<span<?= $Grid->id_actor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id_actor->getDisplayValue($Grid->id_actor->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_id_actor" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id_actor" id="x<?= $Grid->RowIndex ?>_id_actor" value="<?= HtmlEncode($Grid->id_actor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_id_actor" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id_actor" id="o<?= $Grid->RowIndex ?>_id_actor" value="<?= HtmlEncode($Grid->id_actor->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->para->Visible) { // para ?>
        <td data-name="para">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_mensajes_para" class="form-group mensajes_para">
<div class="input-group ew-lookup-list">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x<?= $Grid->RowIndex ?>_para"><?= EmptyValue(strval($Grid->para->ViewValue)) ? $Language->phrase("PleaseSelect") : $Grid->para->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Grid->para->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Grid->para->ReadOnly || $Grid->para->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x<?= $Grid->RowIndex ?>_para[]',m:1,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->para->getErrorMessage() ?></div>
<?= $Grid->para->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_para") ?>
<input type="hidden" is="selection-list" data-table="mensajes" data-field="x_para" data-type="text" data-multiple="1" data-lookup="1" data-value-separator="<?= $Grid->para->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_para[]" id="x<?= $Grid->RowIndex ?>_para[]" value="<?= $Grid->para->CurrentValue ?>"<?= $Grid->para->editAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_mensajes_para" class="form-group mensajes_para">
<span<?= $Grid->para->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->para->getDisplayValue($Grid->para->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="mensajes" data-field="x_para" data-hidden="1" name="x<?= $Grid->RowIndex ?>_para" id="x<?= $Grid->RowIndex ?>_para" value="<?= HtmlEncode($Grid->para->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="mensajes" data-field="x_para" data-hidden="1" name="o<?= $Grid->RowIndex ?>_para[]" id="o<?= $Grid->RowIndex ?>_para[]" value="<?= HtmlEncode($Grid->para->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->adjunto->Visible) { // adjunto ?>
        <td data-name="adjunto">
<span id="el$rowindex$_mensajes_adjunto" class="form-group mensajes_adjunto">
<div id="fd_x<?= $Grid->RowIndex ?>_adjunto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->adjunto->title() ?>" data-table="mensajes" data-field="x_adjunto" name="x<?= $Grid->RowIndex ?>_adjunto" id="x<?= $Grid->RowIndex ?>_adjunto" lang="<?= CurrentLanguageID() ?>"<?= $Grid->adjunto->editAttributes() ?><?= ($Grid->adjunto->ReadOnly || $Grid->adjunto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_adjunto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->adjunto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_adjunto" id= "fn_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_adjunto" id= "fa_x<?= $Grid->RowIndex ?>_adjunto" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_adjunto" id= "fs_x<?= $Grid->RowIndex ?>_adjunto" value="60">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_adjunto" id= "fx_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_adjunto" id= "fm_x<?= $Grid->RowIndex ?>_adjunto" value="<?= $Grid->adjunto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_adjunto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="mensajes" data-field="x_adjunto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_adjunto" id="o<?= $Grid->RowIndex ?>_adjunto" value="<?= HtmlEncode($Grid->adjunto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fmensajesgrid","load"], function() {
    fmensajesgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fmensajesgrid">
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
    ew.addEventHandlers("mensajes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
