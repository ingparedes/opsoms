<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensagensAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmensagensadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmensagensadd = currentForm = new ew.Form("fmensagensadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "mensagens")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.mensagens)
        ew.vars.tables.mensagens = currentTable;
    fmensagensadd.addFields([
        ["id_de", [fields.id_de.visible && fields.id_de.required ? ew.Validators.required(fields.id_de.caption) : null, ew.Validators.integer], fields.id_de.isInvalid],
        ["id_para", [fields.id_para.visible && fields.id_para.required ? ew.Validators.required(fields.id_para.caption) : null, ew.Validators.integer], fields.id_para.isInvalid],
        ["mensagem", [fields.mensagem.visible && fields.mensagem.required ? ew.Validators.required(fields.mensagem.caption) : null], fields.mensagem.isInvalid],
        ["time", [fields.time.visible && fields.time.required ? ew.Validators.required(fields.time.caption) : null, ew.Validators.integer], fields.time.isInvalid],
        ["lido", [fields.lido.visible && fields.lido.required ? ew.Validators.required(fields.lido.caption) : null, ew.Validators.integer], fields.lido.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmensagensadd,
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
    fmensagensadd.validate = function () {
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
    fmensagensadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmensagensadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fmensagensadd");
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
<form name="fmensagensadd" id="fmensagensadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensagens">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_de->Visible) { // id_de ?>
    <div id="r_id_de" class="form-group row">
        <label id="elh_mensagens_id_de" for="x_id_de" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_de->caption() ?><?= $Page->id_de->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_de->cellAttributes() ?>>
<span id="el_mensagens_id_de">
<input type="<?= $Page->id_de->getInputTextType() ?>" data-table="mensagens" data-field="x_id_de" name="x_id_de" id="x_id_de" size="30" placeholder="<?= HtmlEncode($Page->id_de->getPlaceHolder()) ?>" value="<?= $Page->id_de->EditValue ?>"<?= $Page->id_de->editAttributes() ?> aria-describedby="x_id_de_help">
<?= $Page->id_de->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_de->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_para->Visible) { // id_para ?>
    <div id="r_id_para" class="form-group row">
        <label id="elh_mensagens_id_para" for="x_id_para" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_para->caption() ?><?= $Page->id_para->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_para->cellAttributes() ?>>
<span id="el_mensagens_id_para">
<input type="<?= $Page->id_para->getInputTextType() ?>" data-table="mensagens" data-field="x_id_para" name="x_id_para" id="x_id_para" size="30" placeholder="<?= HtmlEncode($Page->id_para->getPlaceHolder()) ?>" value="<?= $Page->id_para->EditValue ?>"<?= $Page->id_para->editAttributes() ?> aria-describedby="x_id_para_help">
<?= $Page->id_para->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_para->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mensagem->Visible) { // mensagem ?>
    <div id="r_mensagem" class="form-group row">
        <label id="elh_mensagens_mensagem" for="x_mensagem" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mensagem->caption() ?><?= $Page->mensagem->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mensagem->cellAttributes() ?>>
<span id="el_mensagens_mensagem">
<input type="<?= $Page->mensagem->getInputTextType() ?>" data-table="mensagens" data-field="x_mensagem" name="x_mensagem" id="x_mensagem" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->mensagem->getPlaceHolder()) ?>" value="<?= $Page->mensagem->EditValue ?>"<?= $Page->mensagem->editAttributes() ?> aria-describedby="x_mensagem_help">
<?= $Page->mensagem->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mensagem->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->time->Visible) { // time ?>
    <div id="r_time" class="form-group row">
        <label id="elh_mensagens_time" for="x_time" class="<?= $Page->LeftColumnClass ?>"><?= $Page->time->caption() ?><?= $Page->time->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->time->cellAttributes() ?>>
<span id="el_mensagens_time">
<input type="<?= $Page->time->getInputTextType() ?>" data-table="mensagens" data-field="x_time" name="x_time" id="x_time" size="30" placeholder="<?= HtmlEncode($Page->time->getPlaceHolder()) ?>" value="<?= $Page->time->EditValue ?>"<?= $Page->time->editAttributes() ?> aria-describedby="x_time_help">
<?= $Page->time->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->time->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lido->Visible) { // lido ?>
    <div id="r_lido" class="form-group row">
        <label id="elh_mensagens_lido" for="x_lido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lido->caption() ?><?= $Page->lido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lido->cellAttributes() ?>>
<span id="el_mensagens_lido">
<input type="<?= $Page->lido->getInputTextType() ?>" data-table="mensagens" data-field="x_lido" name="x_lido" id="x_lido" size="30" placeholder="<?= HtmlEncode($Page->lido->getPlaceHolder()) ?>" value="<?= $Page->lido->EditValue ?>"<?= $Page->lido->editAttributes() ?> aria-describedby="x_lido_help">
<?= $Page->lido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lido->getErrorMessage() ?></div>
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
    ew.addEventHandlers("mensagens");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
