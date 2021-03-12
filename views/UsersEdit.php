<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UsersEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fusersedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fusersedit = currentForm = new ew.Form("fusersedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.users)
        ew.vars.tables.users = currentTable;
    fusersedit.addFields([
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
        ["nombres", [fields.nombres.visible && fields.nombres.required ? ew.Validators.required(fields.nombres.caption) : null], fields.nombres.isInvalid],
        ["apellidos", [fields.apellidos.visible && fields.apellidos.required ? ew.Validators.required(fields.apellidos.caption) : null], fields.apellidos.isInvalid],
        ["subgrupo", [fields.subgrupo.visible && fields.subgrupo.required ? ew.Validators.required(fields.subgrupo.caption) : null], fields.subgrupo.isInvalid],
        ["perfil", [fields.perfil.visible && fields.perfil.required ? ew.Validators.required(fields.perfil.caption) : null], fields.perfil.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid],
        ["pais", [fields.pais.visible && fields.pais.required ? ew.Validators.required(fields.pais.caption) : null], fields.pais.isInvalid],
        ["pw", [fields.pw.visible && fields.pw.required ? ew.Validators.required(fields.pw.caption) : null], fields.pw.isInvalid],
        ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
        ["horario", [fields.horario.visible && fields.horario.required ? ew.Validators.required(fields.horario.caption) : null, ew.Validators.datetime(0)], fields.horario.isInvalid],
        ["limite", [fields.limite.visible && fields.limite.required ? ew.Validators.required(fields.limite.caption) : null, ew.Validators.datetime(0)], fields.limite.isInvalid],
        ["img_user", [fields.img_user.visible && fields.img_user.required ? ew.Validators.fileRequired(fields.img_user.caption) : null], fields.img_user.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fusersedit,
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
    fusersedit.validate = function () {
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
    fusersedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fusersedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fusersedit.lists.subgrupo = <?= $Page->subgrupo->toClientList($Page) ?>;
    fusersedit.lists.perfil = <?= $Page->perfil->toClientList($Page) ?>;
    fusersedit.lists.pais = <?= $Page->pais->toClientList($Page) ?>;
    fusersedit.lists.estado = <?= $Page->estado->toClientList($Page) ?>;
    loadjs.done("fusersedit");
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
<form name="fusersedit" id="fusersedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_users->Visible) { // id_users ?>
    <div id="r_id_users" class="form-group row">
        <label id="elh_users_id_users" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_users->caption() ?><?= $Page->id_users->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_users->cellAttributes() ?>>
<span id="el_users_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_users->getDisplayValue($Page->id_users->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="x_id_users" id="x_id_users" value="<?= HtmlEncode($Page->id_users->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
    <div id="r_nombres" class="form-group row">
        <label id="elh_users_nombres" for="x_nombres" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombres->caption() ?><?= $Page->nombres->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombres->cellAttributes() ?>>
<span id="el_users_nombres">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x_nombres" id="x_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?> aria-describedby="x_nombres_help">
<?= $Page->nombres->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <div id="r_apellidos" class="form-group row">
        <label id="elh_users_apellidos" for="x_apellidos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos->caption() ?><?= $Page->apellidos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->apellidos->cellAttributes() ?>>
<span id="el_users_apellidos">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x_apellidos" id="x_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?> aria-describedby="x_apellidos_help">
<?= $Page->apellidos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
    <div id="r_subgrupo" class="form-group row">
        <label id="elh_users_subgrupo" for="x_subgrupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subgrupo->caption() ?><?= $Page->subgrupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el_users_subgrupo">
    <select
        id="x_subgrupo"
        name="x_subgrupo"
        class="form-control ew-select<?= $Page->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Page->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subgrupo->getPlaceHolder()) ?>"
        <?= $Page->subgrupo->editAttributes() ?>>
        <?= $Page->subgrupo->selectOptionListHtml("x_subgrupo") ?>
    </select>
    <?= $Page->subgrupo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->subgrupo->getErrorMessage() ?></div>
<?= $Page->subgrupo->Lookup->getParamTag($Page, "p_x_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x_subgrupo']"),
        options = { name: "x_subgrupo", selectId: "users_x_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
    <div id="r_perfil" class="form-group row">
        <label id="elh_users_perfil" for="x_perfil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->perfil->caption() ?><?= $Page->perfil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->perfil->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_users_perfil">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->perfil->getDisplayValue($Page->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el_users_perfil">
    <select
        id="x_perfil"
        name="x_perfil"
        class="form-control ew-select<?= $Page->perfil->isInvalidClass() ?>"
        data-select2-id="users_x_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Page->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->perfil->getPlaceHolder()) ?>"
        <?= $Page->perfil->editAttributes() ?>>
        <?= $Page->perfil->selectOptionListHtml("x_perfil") ?>
    </select>
    <?= $Page->perfil->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->perfil->getErrorMessage() ?></div>
<?= $Page->perfil->Lookup->getParamTag($Page, "p_x_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x_perfil']"),
        options = { name: "x_perfil", selectId: "users_x_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_users__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <div id="r_telefono" class="form-group row">
        <label id="elh_users_telefono" for="x_telefono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono->caption() ?><?= $Page->telefono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telefono->cellAttributes() ?>>
<span id="el_users_telefono">
<input type="<?= $Page->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x_telefono" id="x_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" value="<?= $Page->telefono->EditValue ?>"<?= $Page->telefono->editAttributes() ?> aria-describedby="x_telefono_help">
<?= $Page->telefono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
    <div id="r_pais" class="form-group row">
        <label id="elh_users_pais" for="x_pais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pais->caption() ?><?= $Page->pais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pais->cellAttributes() ?>>
<span id="el_users_pais">
    <select
        id="x_pais"
        name="x_pais"
        class="form-control ew-select<?= $Page->pais->isInvalidClass() ?>"
        data-select2-id="users_x_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Page->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pais->getPlaceHolder()) ?>"
        <?= $Page->pais->editAttributes() ?>>
        <?= $Page->pais->selectOptionListHtml("x_pais") ?>
    </select>
    <?= $Page->pais->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pais->getErrorMessage() ?></div>
<?= $Page->pais->Lookup->getParamTag($Page, "p_x_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x_pais']"),
        options = { name: "x_pais", selectId: "users_x_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pw->Visible) { // pw ?>
    <div id="r_pw" class="form-group row">
        <label id="elh_users_pw" for="x_pw" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pw->caption() ?><?= $Page->pw->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pw->cellAttributes() ?>>
<span id="el_users_pw">
<div class="input-group">
    <input type="password" name="x_pw" id="x_pw" autocomplete="new-password" data-field="x_pw" value="<?= $Page->pw->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->pw->getPlaceHolder()) ?>"<?= $Page->pw->editAttributes() ?> aria-describedby="x_pw_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->pw->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pw->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado" class="form-group row">
        <label id="elh_users_estado" for="x_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->estado->cellAttributes() ?>>
<span id="el_users_estado">
    <select
        id="x_estado"
        name="x_estado"
        class="form-control ew-select<?= $Page->estado->isInvalidClass() ?>"
        data-select2-id="users_x_estado"
        data-table="users"
        data-field="x_estado"
        data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>"
        <?= $Page->estado->editAttributes() ?>>
        <?= $Page->estado->selectOptionListHtml("x_estado") ?>
    </select>
    <?= $Page->estado->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x_estado']"),
        options = { name: "x_estado", selectId: "users_x_estado", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.users.fields.estado.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.estado.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->horario->Visible) { // horario ?>
    <div id="r_horario" class="form-group row">
        <label id="elh_users_horario" for="x_horario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->horario->caption() ?><?= $Page->horario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->horario->cellAttributes() ?>>
<span id="el_users_horario">
<input type="<?= $Page->horario->getInputTextType() ?>" data-table="users" data-field="x_horario" name="x_horario" id="x_horario" placeholder="<?= HtmlEncode($Page->horario->getPlaceHolder()) ?>" value="<?= $Page->horario->EditValue ?>"<?= $Page->horario->editAttributes() ?> aria-describedby="x_horario_help">
<?= $Page->horario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->horario->getErrorMessage() ?></div>
<?php if (!$Page->horario->ReadOnly && !$Page->horario->Disabled && !isset($Page->horario->EditAttrs["readonly"]) && !isset($Page->horario->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fusersedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fusersedit", "x_horario", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->limite->Visible) { // limite ?>
    <div id="r_limite" class="form-group row">
        <label id="elh_users_limite" for="x_limite" class="<?= $Page->LeftColumnClass ?>"><?= $Page->limite->caption() ?><?= $Page->limite->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->limite->cellAttributes() ?>>
<span id="el_users_limite">
<input type="<?= $Page->limite->getInputTextType() ?>" data-table="users" data-field="x_limite" name="x_limite" id="x_limite" placeholder="<?= HtmlEncode($Page->limite->getPlaceHolder()) ?>" value="<?= $Page->limite->EditValue ?>"<?= $Page->limite->editAttributes() ?> aria-describedby="x_limite_help">
<?= $Page->limite->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->limite->getErrorMessage() ?></div>
<?php if (!$Page->limite->ReadOnly && !$Page->limite->Disabled && !isset($Page->limite->EditAttrs["readonly"]) && !isset($Page->limite->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fusersedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fusersedit", "x_limite", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
    <div id="r_img_user" class="form-group row">
        <label id="elh_users_img_user" class="<?= $Page->LeftColumnClass ?>"><?= $Page->img_user->caption() ?><?= $Page->img_user->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->img_user->cellAttributes() ?>>
<span id="el_users_img_user">
<div id="fd_x_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x_img_user" id="x_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Page->img_user->editAttributes() ?><?= ($Page->img_user->ReadOnly || $Page->img_user->Disabled) ? " disabled" : "" ?> aria-describedby="x_img_user_help">
        <label class="custom-file-label ew-file-label" for="x_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->img_user->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_img_user" id= "fn_x_img_user" value="<?= $Page->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x_img_user" id= "fa_x_img_user" value="<?= (Post("fa_x_img_user") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_img_user" id= "fs_x_img_user" value="60">
<input type="hidden" name="fx_x_img_user" id= "fx_x_img_user" value="<?= $Page->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_img_user" id= "fm_x_img_user" value="<?= $Page->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
