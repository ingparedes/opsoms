<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SubgrupoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fsubgrupolist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fsubgrupolist = currentForm = new ew.Form("fsubgrupolist", "list");
    fsubgrupolist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subgrupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subgrupo)
        ew.vars.tables.subgrupo = currentTable;
    fsubgrupolist.addFields([
        ["id_subgrupo", [fields.id_subgrupo.visible && fields.id_subgrupo.required ? ew.Validators.required(fields.id_subgrupo.caption) : null], fields.id_subgrupo.isInvalid],
        ["imagen_subgrupo", [fields.imagen_subgrupo.visible && fields.imagen_subgrupo.required ? ew.Validators.fileRequired(fields.imagen_subgrupo.caption) : null], fields.imagen_subgrupo.isInvalid],
        ["nombre_subgrupo", [fields.nombre_subgrupo.visible && fields.nombre_subgrupo.required ? ew.Validators.required(fields.nombre_subgrupo.caption) : null], fields.nombre_subgrupo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubgrupolist,
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
    fsubgrupolist.validate = function () {
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
    fsubgrupolist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubgrupolist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fsubgrupolist");
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
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "grupo") {
    if ($Page->MasterRecordExists) {
        include_once "views/GrupoMaster.php";
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> subgrupo">
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
<form name="fsubgrupolist" id="fsubgrupolist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subgrupo">
<?php if ($Page->getCurrentMasterTable() == "grupo" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="grupo">
<input type="hidden" name="fk_id_grupo" value="<?= HtmlEncode($Page->id_grupo->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_subgrupo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_subgrupolist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
        <th data-name="id_subgrupo" class="<?= $Page->id_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_id_subgrupo" class="subgrupo_id_subgrupo"><?= $Page->renderSort($Page->id_subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <th data-name="imagen_subgrupo" class="<?= $Page->imagen_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_imagen_subgrupo" class="subgrupo_imagen_subgrupo"><?= $Page->renderSort($Page->imagen_subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <th data-name="nombre_subgrupo" class="<?= $Page->nombre_subgrupo->headerCellClass() ?>"><div id="elh_subgrupo_nombre_subgrupo" class="subgrupo_nombre_subgrupo"><?= $Page->renderSort($Page->nombre_subgrupo) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_subgrupo", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
        <td data-name="id_subgrupo">
<span id="el<?= $Page->RowCount ?>_subgrupo_id_subgrupo" class="form-group subgrupo_id_subgrupo"></span>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_id_subgrupo" id="o<?= $Page->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Page->id_subgrupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <td data-name="imagen_subgrupo">
<span id="el<?= $Page->RowCount ?>_subgrupo_imagen_subgrupo" class="form-group subgrupo_imagen_subgrupo">
<div id="fd_x<?= $Page->RowIndex ?>_imagen_subgrupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imagen_subgrupo->title() ?>" data-table="subgrupo" data-field="x_imagen_subgrupo" name="x<?= $Page->RowIndex ?>_imagen_subgrupo" id="x<?= $Page->RowIndex ?>_imagen_subgrupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imagen_subgrupo->editAttributes() ?><?= ($Page->imagen_subgrupo->ReadOnly || $Page->imagen_subgrupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_imagen_subgrupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->imagen_subgrupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fn_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fa_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fs_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="100">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fx_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fm_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_imagen_subgrupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_imagen_subgrupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_imagen_subgrupo" id="o<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= HtmlEncode($Page->imagen_subgrupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <td data-name="nombre_subgrupo">
<span id="el<?= $Page->RowCount ?>_subgrupo_nombre_subgrupo" class="form-group subgrupo_nombre_subgrupo">
<input type="<?= $Page->nombre_subgrupo->getInputTextType() ?>" data-table="subgrupo" data-field="x_nombre_subgrupo" name="x<?= $Page->RowIndex ?>_nombre_subgrupo" id="x<?= $Page->RowIndex ?>_nombre_subgrupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_subgrupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_subgrupo->EditValue ?>"<?= $Page->nombre_subgrupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre_subgrupo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_nombre_subgrupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_nombre_subgrupo" id="o<?= $Page->RowIndex ?>_nombre_subgrupo" value="<?= HtmlEncode($Page->nombre_subgrupo->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fsubgrupolist","load"], function() {
    fsubgrupolist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_subgrupo", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
        <td data-name="id_subgrupo" <?= $Page->id_subgrupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_subgrupo_id_subgrupo" class="form-group">
<span<?= $Page->id_subgrupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_subgrupo->getDisplayValue($Page->id_subgrupo->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_subgrupo" id="x<?= $Page->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Page->id_subgrupo->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_subgrupo_id_subgrupo">
<span<?= $Page->id_subgrupo->viewAttributes() ?>>
<?= $Page->id_subgrupo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="subgrupo" data-field="x_id_subgrupo" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_subgrupo" id="x<?= $Page->RowIndex ?>_id_subgrupo" value="<?= HtmlEncode($Page->id_subgrupo->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <td data-name="imagen_subgrupo" <?= $Page->imagen_subgrupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_subgrupo_imagen_subgrupo" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_imagen_subgrupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imagen_subgrupo->title() ?>" data-table="subgrupo" data-field="x_imagen_subgrupo" name="x<?= $Page->RowIndex ?>_imagen_subgrupo" id="x<?= $Page->RowIndex ?>_imagen_subgrupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imagen_subgrupo->editAttributes() ?><?= ($Page->imagen_subgrupo->ReadOnly || $Page->imagen_subgrupo->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_imagen_subgrupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->imagen_subgrupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fn_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fa_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_imagen_subgrupo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fs_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="100">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fx_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_imagen_subgrupo" id= "fm_x<?= $Page->RowIndex ?>_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_imagen_subgrupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_subgrupo_imagen_subgrupo">
<span>
<?= GetFileViewTag($Page->imagen_subgrupo, $Page->imagen_subgrupo->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <td data-name="nombre_subgrupo" <?= $Page->nombre_subgrupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_subgrupo_nombre_subgrupo" class="form-group">
<input type="<?= $Page->nombre_subgrupo->getInputTextType() ?>" data-table="subgrupo" data-field="x_nombre_subgrupo" name="x<?= $Page->RowIndex ?>_nombre_subgrupo" id="x<?= $Page->RowIndex ?>_nombre_subgrupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_subgrupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_subgrupo->EditValue ?>"<?= $Page->nombre_subgrupo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre_subgrupo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_subgrupo_nombre_subgrupo">
<span<?= $Page->nombre_subgrupo->viewAttributes() ?>>
<?= $Page->nombre_subgrupo->getViewValue() ?></span>
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
loadjs.ready(["fsubgrupolist","load"], function () {
    fsubgrupolist.updateLists(<?= $Page->RowIndex ?>);
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
