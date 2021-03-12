<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpermisos_docadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpermisos_docadd = currentForm = new ew.Form("fpermisos_docadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "permisos_doc")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.permisos_doc)
        ew.vars.tables.permisos_doc = currentTable;
    fpermisos_docadd.addFields([
        ["id_file", [fields.id_file.visible && fields.id_file.required ? ew.Validators.required(fields.id_file.caption) : null, ew.Validators.integer], fields.id_file.isInvalid],
        ["tipo_permiso", [fields.tipo_permiso.visible && fields.tipo_permiso.required ? ew.Validators.required(fields.tipo_permiso.caption) : null], fields.tipo_permiso.isInvalid],
        ["fecha_created", [fields.fecha_created.visible && fields.fecha_created.required ? ew.Validators.required(fields.fecha_created.caption) : null], fields.fecha_created.isInvalid],
        ["id_usuarios", [fields.id_usuarios.visible && fields.id_usuarios.required ? ew.Validators.required(fields.id_usuarios.caption) : null], fields.id_usuarios.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpermisos_docadd,
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
    fpermisos_docadd.validate = function () {
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
    fpermisos_docadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpermisos_docadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpermisos_docadd.lists.tipo_permiso = <?= $Page->tipo_permiso->toClientList($Page) ?>;
    fpermisos_docadd.lists.id_usuarios = <?= $Page->id_usuarios->toClientList($Page) ?>;
    loadjs.done("fpermisos_docadd");
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
<form name="fpermisos_docadd" id="fpermisos_docadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="permisos_doc">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "archivos_doc") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="archivos_doc">
<input type="hidden" name="fk_id_file" value="<?= HtmlEncode($Page->id_file->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_file->Visible) { // id_file ?>
    <div id="r_id_file" class="form-group row">
        <label id="elh_permisos_doc_id_file" for="x_id_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_file->caption() ?><?= $Page->id_file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_file->cellAttributes() ?>>
<?php if ($Page->id_file->getSessionValue() != "") { ?>
<span id="el_permisos_doc_id_file">
<span<?= $Page->id_file->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_file->getDisplayValue($Page->id_file->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_id_file" name="x_id_file" value="<?= HtmlEncode($Page->id_file->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_permisos_doc_id_file">
<input type="<?= $Page->id_file->getInputTextType() ?>" data-table="permisos_doc" data-field="x_id_file" name="x_id_file" id="x_id_file" size="30" placeholder="<?= HtmlEncode($Page->id_file->getPlaceHolder()) ?>" value="<?= $Page->id_file->EditValue ?>"<?= $Page->id_file->editAttributes() ?> aria-describedby="x_id_file_help">
<?= $Page->id_file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_file->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <div id="r_tipo_permiso" class="form-group row">
        <label id="elh_permisos_doc_tipo_permiso" for="x_tipo_permiso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_permiso->caption() ?><?= $Page->tipo_permiso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_permiso->cellAttributes() ?>>
<span id="el_permisos_doc_tipo_permiso">
    <select
        id="x_tipo_permiso"
        name="x_tipo_permiso"
        class="form-control ew-select<?= $Page->tipo_permiso->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x_tipo_permiso"
        data-table="permisos_doc"
        data-field="x_tipo_permiso"
        data-value-separator="<?= $Page->tipo_permiso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_permiso->getPlaceHolder()) ?>"
        <?= $Page->tipo_permiso->editAttributes() ?>>
        <?= $Page->tipo_permiso->selectOptionListHtml("x_tipo_permiso") ?>
    </select>
    <?= $Page->tipo_permiso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_permiso->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x_tipo_permiso']"),
        options = { name: "x_tipo_permiso", selectId: "permisos_doc_x_tipo_permiso", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.permisos_doc.fields.tipo_permiso.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.tipo_permiso.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
    <div id="r_id_usuarios" class="form-group row">
        <label id="elh_permisos_doc_id_usuarios" for="x_id_usuarios" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_usuarios->caption() ?><?= $Page->id_usuarios->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_usuarios->cellAttributes() ?>>
<span id="el_permisos_doc_id_usuarios">
    <select
        id="x_id_usuarios"
        name="x_id_usuarios"
        class="form-control ew-select<?= $Page->id_usuarios->isInvalidClass() ?>"
        data-select2-id="permisos_doc_x_id_usuarios"
        data-table="permisos_doc"
        data-field="x_id_usuarios"
        data-value-separator="<?= $Page->id_usuarios->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_usuarios->getPlaceHolder()) ?>"
        <?= $Page->id_usuarios->editAttributes() ?>>
        <?= $Page->id_usuarios->selectOptionListHtml("x_id_usuarios") ?>
    </select>
    <?= $Page->id_usuarios->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->id_usuarios->getErrorMessage() ?></div>
<?= $Page->id_usuarios->Lookup->getParamTag($Page, "p_x_id_usuarios") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='permisos_doc_x_id_usuarios']"),
        options = { name: "x_id_usuarios", selectId: "permisos_doc_x_id_usuarios", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.permisos_doc.fields.id_usuarios.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
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
    ew.addEventHandlers("permisos_doc");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
