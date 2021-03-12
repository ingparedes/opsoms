<?php

namespace PHPMaker2021\simexamerica;

// Page object
$IncidenteEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fincidenteedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fincidenteedit = currentForm = new ew.Form("fincidenteedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "incidente")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.incidente)
        ew.vars.tables.incidente = currentTable;
    fincidenteedit.addFields([
        ["id_incidente", [fields.id_incidente.visible && fields.id_incidente.required ? ew.Validators.required(fields.id_incidente.caption) : null], fields.id_incidente.isInvalid],
        ["id_tipo", [fields.id_tipo.visible && fields.id_tipo.required ? ew.Validators.required(fields.id_tipo.caption) : null, ew.Validators.integer], fields.id_tipo.isInvalid],
        ["incidente_es", [fields.incidente_es.visible && fields.incidente_es.required ? ew.Validators.required(fields.incidente_es.caption) : null], fields.incidente_es.isInvalid],
        ["incidente_en", [fields.incidente_en.visible && fields.incidente_en.required ? ew.Validators.required(fields.incidente_en.caption) : null], fields.incidente_en.isInvalid],
        ["icono", [fields.icono.visible && fields.icono.required ? ew.Validators.required(fields.icono.caption) : null], fields.icono.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fincidenteedit,
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
    fincidenteedit.validate = function () {
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
    fincidenteedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fincidenteedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fincidenteedit");
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
<form name="fincidenteedit" id="fincidenteedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="incidente">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_incidente->Visible) { // id_incidente ?>
    <div id="r_id_incidente" class="form-group row">
        <label id="elh_incidente_id_incidente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_incidente->caption() ?><?= $Page->id_incidente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_incidente->cellAttributes() ?>>
<span id="el_incidente_id_incidente">
<span<?= $Page->id_incidente->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_incidente->getDisplayValue($Page->id_incidente->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="incidente" data-field="x_id_incidente" data-hidden="1" name="x_id_incidente" id="x_id_incidente" value="<?= HtmlEncode($Page->id_incidente->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_tipo->Visible) { // id_tipo ?>
    <div id="r_id_tipo" class="form-group row">
        <label id="elh_incidente_id_tipo" for="x_id_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_tipo->caption() ?><?= $Page->id_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tipo->cellAttributes() ?>>
<span id="el_incidente_id_tipo">
<input type="<?= $Page->id_tipo->getInputTextType() ?>" data-table="incidente" data-field="x_id_tipo" name="x_id_tipo" id="x_id_tipo" size="30" placeholder="<?= HtmlEncode($Page->id_tipo->getPlaceHolder()) ?>" value="<?= $Page->id_tipo->EditValue ?>"<?= $Page->id_tipo->editAttributes() ?> aria-describedby="x_id_tipo_help">
<?= $Page->id_tipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_tipo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->incidente_es->Visible) { // incidente_es ?>
    <div id="r_incidente_es" class="form-group row">
        <label id="elh_incidente_incidente_es" for="x_incidente_es" class="<?= $Page->LeftColumnClass ?>"><?= $Page->incidente_es->caption() ?><?= $Page->incidente_es->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->incidente_es->cellAttributes() ?>>
<span id="el_incidente_incidente_es">
<input type="<?= $Page->incidente_es->getInputTextType() ?>" data-table="incidente" data-field="x_incidente_es" name="x_incidente_es" id="x_incidente_es" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->incidente_es->getPlaceHolder()) ?>" value="<?= $Page->incidente_es->EditValue ?>"<?= $Page->incidente_es->editAttributes() ?> aria-describedby="x_incidente_es_help">
<?= $Page->incidente_es->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->incidente_es->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->incidente_en->Visible) { // incidente_en ?>
    <div id="r_incidente_en" class="form-group row">
        <label id="elh_incidente_incidente_en" for="x_incidente_en" class="<?= $Page->LeftColumnClass ?>"><?= $Page->incidente_en->caption() ?><?= $Page->incidente_en->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->incidente_en->cellAttributes() ?>>
<span id="el_incidente_incidente_en">
<input type="<?= $Page->incidente_en->getInputTextType() ?>" data-table="incidente" data-field="x_incidente_en" name="x_incidente_en" id="x_incidente_en" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->incidente_en->getPlaceHolder()) ?>" value="<?= $Page->incidente_en->EditValue ?>"<?= $Page->incidente_en->editAttributes() ?> aria-describedby="x_incidente_en_help">
<?= $Page->incidente_en->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->incidente_en->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->icono->Visible) { // icono ?>
    <div id="r_icono" class="form-group row">
        <label id="elh_incidente_icono" for="x_icono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->icono->caption() ?><?= $Page->icono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->icono->cellAttributes() ?>>
<span id="el_incidente_icono">
<input type="<?= $Page->icono->getInputTextType() ?>" data-table="incidente" data-field="x_icono" name="x_icono" id="x_icono" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->icono->getPlaceHolder()) ?>" value="<?= $Page->icono->EditValue ?>"<?= $Page->icono->editAttributes() ?> aria-describedby="x_icono_help">
<?= $Page->icono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->icono->getErrorMessage() ?></div>
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
    ew.addEventHandlers("incidente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
