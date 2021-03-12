<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ActorSimuladoAddopt = &$Page;
?>
<script>
var currentForm, currentPageID;
var factor_simuladoaddopt;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "addopt";
    factor_simuladoaddopt = currentForm = new ew.Form("factor_simuladoaddopt", "addopt");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "actor_simulado")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.actor_simulado)
        ew.vars.tables.actor_simulado = currentTable;
    factor_simuladoaddopt.addFields([
        ["nombre_actor", [fields.nombre_actor.visible && fields.nombre_actor.required ? ew.Validators.required(fields.nombre_actor.caption) : null], fields.nombre_actor.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = factor_simuladoaddopt,
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
    factor_simuladoaddopt.validate = function () {
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
    factor_simuladoaddopt.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    factor_simuladoaddopt.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("factor_simuladoaddopt");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<form name="factor_simuladoaddopt" id="factor_simuladoaddopt" class="ew-form ew-horizontal" action="<?= HtmlEncode(GetUrl(Config("API_URL"))) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="<?= Config("API_ACTION_NAME") ?>" id="<?= Config("API_ACTION_NAME") ?>" value="<?= Config("API_ADD_ACTION") ?>">
<input type="hidden" name="<?= Config("API_OBJECT_NAME") ?>" id="<?= Config("API_OBJECT_NAME") ?>" value="actor_simulado">
<input type="hidden" name="addopt" id="addopt" value="1">
<?php if ($Page->nombre_actor->Visible) { // nombre_actor ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label ew-label" for="x_nombre_actor"><?= $Page->nombre_actor->caption() ?><?= $Page->nombre_actor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="col-sm-10">
<input type="<?= $Page->nombre_actor->getInputTextType() ?>" data-table="actor_simulado" data-field="x_nombre_actor" name="x_nombre_actor" id="x_nombre_actor" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nombre_actor->getPlaceHolder()) ?>" value="<?= $Page->nombre_actor->EditValue ?>"<?= $Page->nombre_actor->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre_actor->getErrorMessage() ?></div>
</div>
    </div>
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
