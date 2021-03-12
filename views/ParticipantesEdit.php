<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ParticipantesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fparticipantesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fparticipantesedit = currentForm = new ew.Form("fparticipantesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "participantes")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.participantes)
        ew.vars.tables.participantes = currentTable;
    fparticipantesedit.addFields([
        ["id_participantes", [fields.id_participantes.visible && fields.id_participantes.required ? ew.Validators.required(fields.id_participantes.caption) : null], fields.id_participantes.isInvalid],
        ["nombres", [fields.nombres.visible && fields.nombres.required ? ew.Validators.required(fields.nombres.caption) : null], fields.nombres.isInvalid],
        ["apellidos", [fields.apellidos.visible && fields.apellidos.required ? ew.Validators.required(fields.apellidos.caption) : null], fields.apellidos.isInvalid],
        ["_login", [fields._login.visible && fields._login.required ? ew.Validators.required(fields._login.caption) : null], fields._login.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["grupo", [fields.grupo.visible && fields.grupo.required ? ew.Validators.required(fields.grupo.caption) : null, ew.Validators.integer], fields.grupo.isInvalid],
        ["subgrupo", [fields.subgrupo.visible && fields.subgrupo.required ? ew.Validators.required(fields.subgrupo.caption) : null], fields.subgrupo.isInvalid],
        ["imagen_participante", [fields.imagen_participante.visible && fields.imagen_participante.required ? ew.Validators.required(fields.imagen_participante.caption) : null], fields.imagen_participante.isInvalid],
        ["id_escenario", [fields.id_escenario.visible && fields.id_escenario.required ? ew.Validators.required(fields.id_escenario.caption) : null, ew.Validators.integer], fields.id_escenario.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fparticipantesedit,
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
    fparticipantesedit.validate = function () {
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
    fparticipantesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fparticipantesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fparticipantesedit");
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
<form name="fparticipantesedit" id="fparticipantesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="participantes">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_participantes->Visible) { // id_participantes ?>
    <div id="r_id_participantes" class="form-group row">
        <label id="elh_participantes_id_participantes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_participantes->caption() ?><?= $Page->id_participantes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_participantes->cellAttributes() ?>>
<span id="el_participantes_id_participantes">
<span<?= $Page->id_participantes->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_participantes->getDisplayValue($Page->id_participantes->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="participantes" data-field="x_id_participantes" data-hidden="1" name="x_id_participantes" id="x_id_participantes" value="<?= HtmlEncode($Page->id_participantes->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
    <div id="r_nombres" class="form-group row">
        <label id="elh_participantes_nombres" for="x_nombres" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombres->caption() ?><?= $Page->nombres->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombres->cellAttributes() ?>>
<span id="el_participantes_nombres">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="participantes" data-field="x_nombres" name="x_nombres" id="x_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?> aria-describedby="x_nombres_help">
<?= $Page->nombres->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <div id="r_apellidos" class="form-group row">
        <label id="elh_participantes_apellidos" for="x_apellidos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos->caption() ?><?= $Page->apellidos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apellidos->cellAttributes() ?>>
<span id="el_participantes_apellidos">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="participantes" data-field="x_apellidos" name="x_apellidos" id="x_apellidos" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?> aria-describedby="x_apellidos_help">
<?= $Page->apellidos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <div id="r__login" class="form-group row">
        <label id="elh_participantes__login" for="x__login" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_login->caption() ?><?= $Page->_login->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_login->cellAttributes() ?>>
<span id="el_participantes__login">
<input type="<?= $Page->_login->getInputTextType() ?>" data-table="participantes" data-field="x__login" name="x__login" id="x__login" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_login->getPlaceHolder()) ?>" value="<?= $Page->_login->EditValue ?>"<?= $Page->_login->editAttributes() ?> aria-describedby="x__login_help">
<?= $Page->_login->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_login->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password" class="form-group row">
        <label id="elh_participantes__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_password->cellAttributes() ?>>
<span id="el_participantes__password">
<input type="<?= $Page->_password->getInputTextType() ?>" data-table="participantes" data-field="x__password" name="x__password" id="x__password" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>" value="<?= $Page->_password->EditValue ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_participantes__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_participantes__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="participantes" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
    <div id="r_grupo" class="form-group row">
        <label id="elh_participantes_grupo" for="x_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grupo->caption() ?><?= $Page->grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->grupo->cellAttributes() ?>>
<span id="el_participantes_grupo">
<input type="<?= $Page->grupo->getInputTextType() ?>" data-table="participantes" data-field="x_grupo" name="x_grupo" id="x_grupo" size="30" placeholder="<?= HtmlEncode($Page->grupo->getPlaceHolder()) ?>" value="<?= $Page->grupo->EditValue ?>"<?= $Page->grupo->editAttributes() ?> aria-describedby="x_grupo_help">
<?= $Page->grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->grupo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
    <div id="r_subgrupo" class="form-group row">
        <label id="elh_participantes_subgrupo" for="x_subgrupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subgrupo->caption() ?><?= $Page->subgrupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el_participantes_subgrupo">
<input type="<?= $Page->subgrupo->getInputTextType() ?>" data-table="participantes" data-field="x_subgrupo" name="x_subgrupo" id="x_subgrupo" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->subgrupo->getPlaceHolder()) ?>" value="<?= $Page->subgrupo->EditValue ?>"<?= $Page->subgrupo->editAttributes() ?> aria-describedby="x_subgrupo_help">
<?= $Page->subgrupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subgrupo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imagen_participante->Visible) { // imagen_participante ?>
    <div id="r_imagen_participante" class="form-group row">
        <label id="elh_participantes_imagen_participante" for="x_imagen_participante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imagen_participante->caption() ?><?= $Page->imagen_participante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->imagen_participante->cellAttributes() ?>>
<span id="el_participantes_imagen_participante">
<input type="<?= $Page->imagen_participante->getInputTextType() ?>" data-table="participantes" data-field="x_imagen_participante" name="x_imagen_participante" id="x_imagen_participante" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->imagen_participante->getPlaceHolder()) ?>" value="<?= $Page->imagen_participante->EditValue ?>"<?= $Page->imagen_participante->editAttributes() ?> aria-describedby="x_imagen_participante_help">
<?= $Page->imagen_participante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->imagen_participante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <div id="r_id_escenario" class="form-group row">
        <label id="elh_participantes_id_escenario" for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_escenario->caption() ?><?= $Page->id_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el_participantes_id_escenario">
<input type="<?= $Page->id_escenario->getInputTextType() ?>" data-table="participantes" data-field="x_id_escenario" name="x_id_escenario" id="x_id_escenario" size="30" placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>" value="<?= $Page->id_escenario->EditValue ?>"<?= $Page->id_escenario->editAttributes() ?> aria-describedby="x_id_escenario_help">
<?= $Page->id_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage() ?></div>
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
    ew.addEventHandlers("participantes");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
