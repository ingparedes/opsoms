<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ActorSimuladoEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var factor_simuladoedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    factor_simuladoedit = currentForm = new ew.Form("factor_simuladoedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "actor_simulado")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.actor_simulado)
        ew.vars.tables.actor_simulado = currentTable;
    factor_simuladoedit.addFields([
        ["id_actor", [fields.id_actor.visible && fields.id_actor.required ? ew.Validators.required(fields.id_actor.caption) : null], fields.id_actor.isInvalid],
        ["nombre_actor", [fields.nombre_actor.visible && fields.nombre_actor.required ? ew.Validators.required(fields.nombre_actor.caption) : null], fields.nombre_actor.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = factor_simuladoedit,
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
    factor_simuladoedit.validate = function () {
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
    factor_simuladoedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    factor_simuladoedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("factor_simuladoedit");
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
<form name="factor_simuladoedit" id="factor_simuladoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="actor_simulado">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_actor->Visible) { // id_actor ?>
    <div id="r_id_actor" class="form-group row">
        <label id="elh_actor_simulado_id_actor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_actor->caption() ?><?= $Page->id_actor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_actor->cellAttributes() ?>>
<span id="el_actor_simulado_id_actor">
<span<?= $Page->id_actor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_actor->getDisplayValue($Page->id_actor->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="actor_simulado" data-field="x_id_actor" data-hidden="1" name="x_id_actor" id="x_id_actor" value="<?= HtmlEncode($Page->id_actor->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_actor->Visible) { // nombre_actor ?>
    <div id="r_nombre_actor" class="form-group row">
        <label id="elh_actor_simulado_nombre_actor" for="x_nombre_actor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_actor->caption() ?><?= $Page->nombre_actor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombre_actor->cellAttributes() ?>>
<span id="el_actor_simulado_nombre_actor">
<input type="<?= $Page->nombre_actor->getInputTextType() ?>" data-table="actor_simulado" data-field="x_nombre_actor" name="x_nombre_actor" id="x_nombre_actor" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nombre_actor->getPlaceHolder()) ?>" value="<?= $Page->nombre_actor->EditValue ?>"<?= $Page->nombre_actor->editAttributes() ?> aria-describedby="x_nombre_actor_help">
<?= $Page->nombre_actor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_actor->getErrorMessage() ?></div>
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
    ew.addEventHandlers("actor_simulado");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
