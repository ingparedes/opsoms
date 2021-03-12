<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ArchivosDocAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var farchivos_docadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    farchivos_docadd = currentForm = new ew.Form("farchivos_docadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "archivos_doc")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.archivos_doc)
        ew.vars.tables.archivos_doc = currentTable;
    farchivos_docadd.addFields([
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["file_name", [fields.file_name.visible && fields.file_name.required ? ew.Validators.fileRequired(fields.file_name.caption) : null], fields.file_name.isInvalid],
        ["fecha_created", [fields.fecha_created.visible && fields.fecha_created.required ? ew.Validators.required(fields.fecha_created.caption) : null], fields.fecha_created.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = farchivos_docadd,
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
    farchivos_docadd.validate = function () {
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

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    farchivos_docadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    farchivos_docadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    farchivos_docadd.lists.id_users = <?= $Page->id_users->toClientList($Page) ?>;
    loadjs.done("farchivos_docadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="farchivos_docadd" id="farchivos_docadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="archivos_doc">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->file_name->Visible) { // file_name ?>
    <div id="r_file_name" class="form-group row">
        <label id="elh_archivos_doc_file_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file_name->caption() ?><?= $Page->file_name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->file_name->cellAttributes() ?>>
<span id="el_archivos_doc_file_name">
<div id="fd_x_file_name">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->file_name->title() ?>" data-table="archivos_doc" data-field="x_file_name" name="x_file_name" id="x_file_name" lang="<?= CurrentLanguageID() ?>"<?= $Page->file_name->editAttributes() ?><?= ($Page->file_name->ReadOnly || $Page->file_name->Disabled) ? " disabled" : "" ?> aria-describedby="x_file_name_help">
        <label class="custom-file-label ew-file-label" for="x_file_name"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->file_name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file_name->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file_name" id= "fn_x_file_name" value="<?= $Page->file_name->Upload->FileName ?>">
<input type="hidden" name="fa_x_file_name" id= "fa_x_file_name" value="0">
<input type="hidden" name="fs_x_file_name" id= "fs_x_file_name" value="100">
<input type="hidden" name="fx_x_file_name" id= "fx_x_file_name" value="<?= $Page->file_name->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file_name" id= "fm_x_file_name" value="<?= $Page->file_name->UploadMaxFileSize ?>">
</div>
<table id="ft_x_file_name" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("permisos_doc", explode(",", $Page->getCurrentDetailTable())) && $permisos_doc->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("permisos_doc", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PermisosDocGrid.php" ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("archivos_doc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
