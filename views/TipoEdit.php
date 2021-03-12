<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TipoEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftipoedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    ftipoedit = currentForm = new ew.Form("ftipoedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tipo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.tipo)
        ew.vars.tables.tipo = currentTable;
    ftipoedit.addFields([
        ["id_tipo", [fields.id_tipo.visible && fields.id_tipo.required ? ew.Validators.required(fields.id_tipo.caption) : null, ew.Validators.integer], fields.id_tipo.isInvalid],
        ["tipo_es", [fields.tipo_es.visible && fields.tipo_es.required ? ew.Validators.required(fields.tipo_es.caption) : null], fields.tipo_es.isInvalid],
        ["tipo_en", [fields.tipo_en.visible && fields.tipo_en.required ? ew.Validators.required(fields.tipo_en.caption) : null], fields.tipo_en.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftipoedit,
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
    ftipoedit.validate = function () {
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
    ftipoedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftipoedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ftipoedit");
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
<form name="ftipoedit" id="ftipoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tipo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_tipo->Visible) { // id_tipo ?>
    <div id="r_id_tipo" class="form-group row">
        <label id="elh_tipo_id_tipo" for="x_id_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_tipo->caption() ?><?= $Page->id_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tipo->cellAttributes() ?>>
<input type="<?= $Page->id_tipo->getInputTextType() ?>" data-table="tipo" data-field="x_id_tipo" name="x_id_tipo" id="x_id_tipo" size="30" placeholder="<?= HtmlEncode($Page->id_tipo->getPlaceHolder()) ?>" value="<?= $Page->id_tipo->EditValue ?>"<?= $Page->id_tipo->editAttributes() ?> aria-describedby="x_id_tipo_help">
<?= $Page->id_tipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_tipo->getErrorMessage() ?></div>
<input type="hidden" data-table="tipo" data-field="x_id_tipo" data-hidden="1" name="o_id_tipo" id="o_id_tipo" value="<?= HtmlEncode($Page->id_tipo->OldValue ?? $Page->id_tipo->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_es->Visible) { // tipo_es ?>
    <div id="r_tipo_es" class="form-group row">
        <label id="elh_tipo_tipo_es" for="x_tipo_es" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_es->caption() ?><?= $Page->tipo_es->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_es->cellAttributes() ?>>
<span id="el_tipo_tipo_es">
<input type="<?= $Page->tipo_es->getInputTextType() ?>" data-table="tipo" data-field="x_tipo_es" name="x_tipo_es" id="x_tipo_es" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->tipo_es->getPlaceHolder()) ?>" value="<?= $Page->tipo_es->EditValue ?>"<?= $Page->tipo_es->editAttributes() ?> aria-describedby="x_tipo_es_help">
<?= $Page->tipo_es->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_es->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_en->Visible) { // tipo_en ?>
    <div id="r_tipo_en" class="form-group row">
        <label id="elh_tipo_tipo_en" for="x_tipo_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_en->caption() ?><?= $Page->tipo_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_en->cellAttributes() ?>>
<span id="el_tipo_tipo_en">
<input type="<?= $Page->tipo_en->getInputTextType() ?>" data-table="tipo" data-field="x_tipo_en" name="x_tipo_en" id="x_tipo_en" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->tipo_en->getPlaceHolder()) ?>" value="<?= $Page->tipo_en->EditValue ?>"<?= $Page->tipo_en->editAttributes() ?> aria-describedby="x_tipo_en_help">
<?= $Page->tipo_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("tipo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
