<?php

namespace PHPMaker2021\simexamerica;

// Page object
$EscenarioAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fescenarioadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fescenarioadd = currentForm = new ew.Form("fescenarioadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "escenario")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.escenario)
        ew.vars.tables.escenario = currentTable;
    fescenarioadd.addFields([
        ["icon_escenario", [fields.icon_escenario.visible && fields.icon_escenario.required ? ew.Validators.required(fields.icon_escenario.caption) : null], fields.icon_escenario.isInvalid],
        ["fechacreacion_escenario", [fields.fechacreacion_escenario.visible && fields.fechacreacion_escenario.required ? ew.Validators.required(fields.fechacreacion_escenario.caption) : null], fields.fechacreacion_escenario.isInvalid],
        ["nombre_escenario", [fields.nombre_escenario.visible && fields.nombre_escenario.required ? ew.Validators.required(fields.nombre_escenario.caption) : null], fields.nombre_escenario.isInvalid],
        ["tipo_evento", [fields.tipo_evento.visible && fields.tipo_evento.required ? ew.Validators.required(fields.tipo_evento.caption) : null], fields.tipo_evento.isInvalid],
        ["incidente", [fields.incidente.visible && fields.incidente.required ? ew.Validators.required(fields.incidente.caption) : null], fields.incidente.isInvalid],
        ["pais_escenario", [fields.pais_escenario.visible && fields.pais_escenario.required ? ew.Validators.required(fields.pais_escenario.caption) : null], fields.pais_escenario.isInvalid],
        ["descripcion_escenario", [fields.descripcion_escenario.visible && fields.descripcion_escenario.required ? ew.Validators.required(fields.descripcion_escenario.caption) : null], fields.descripcion_escenario.isInvalid],
        ["fechaini_simulado", [fields.fechaini_simulado.visible && fields.fechaini_simulado.required ? ew.Validators.required(fields.fechaini_simulado.caption) : null, ew.Validators.datetime(109)], fields.fechaini_simulado.isInvalid],
        ["fechafin_simulado", [fields.fechafin_simulado.visible && fields.fechafin_simulado.required ? ew.Validators.required(fields.fechafin_simulado.caption) : null, ew.Validators.datetime(109)], fields.fechafin_simulado.isInvalid],
        ["fechaini_real", [fields.fechaini_real.visible && fields.fechaini_real.required ? ew.Validators.required(fields.fechaini_real.caption) : null, ew.Validators.datetime(109)], fields.fechaini_real.isInvalid],
        ["fechafinal_real", [fields.fechafinal_real.visible && fields.fechafinal_real.required ? ew.Validators.required(fields.fechafinal_real.caption) : null, ew.Validators.datetime(109)], fields.fechafinal_real.isInvalid],
        ["image_escenario", [fields.image_escenario.visible && fields.image_escenario.required ? ew.Validators.fileRequired(fields.image_escenario.caption) : null], fields.image_escenario.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fescenarioadd,
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
    fescenarioadd.validate = function () {
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
    fescenarioadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fescenarioadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fescenarioadd.lists.tipo_evento = <?= $Page->tipo_evento->toClientList($Page) ?>;
    fescenarioadd.lists.incidente = <?= $Page->incidente->toClientList($Page) ?>;
    fescenarioadd.lists.pais_escenario = <?= $Page->pais_escenario->toClientList($Page) ?>;
    loadjs.done("fescenarioadd");
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
<form name="fescenarioadd" id="fescenarioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="escenario">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->icon_escenario->Visible) { // icon_escenario ?>
    <div id="r_icon_escenario" class="form-group row">
        <label id="elh_escenario_icon_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->icon_escenario->caption() ?><?= $Page->icon_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->icon_escenario->cellAttributes() ?>>
<span id="el_escenario_icon_escenario">
<input type="<?= $Page->icon_escenario->getInputTextType() ?>" data-table="escenario" data-field="x_icon_escenario" name="x_icon_escenario" id="x_icon_escenario" placeholder="<?= HtmlEncode($Page->icon_escenario->getPlaceHolder()) ?>" value="<?= $Page->icon_escenario->EditValue ?>"<?= $Page->icon_escenario->editAttributes() ?> aria-describedby="x_icon_escenario_help">
<?= $Page->icon_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->icon_escenario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_escenario->Visible) { // nombre_escenario ?>
    <div id="r_nombre_escenario" class="form-group row">
        <label id="elh_escenario_nombre_escenario" for="x_nombre_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_escenario->caption() ?><?= $Page->nombre_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombre_escenario->cellAttributes() ?>>
<span id="el_escenario_nombre_escenario">
<input type="<?= $Page->nombre_escenario->getInputTextType() ?>" data-table="escenario" data-field="x_nombre_escenario" name="x_nombre_escenario" id="x_nombre_escenario" size="90" maxlength="200" placeholder="<?= HtmlEncode($Page->nombre_escenario->getPlaceHolder()) ?>" value="<?= $Page->nombre_escenario->EditValue ?>"<?= $Page->nombre_escenario->editAttributes() ?> aria-describedby="x_nombre_escenario_help">
<?= $Page->nombre_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_escenario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_evento->Visible) { // tipo_evento ?>
    <div id="r_tipo_evento" class="form-group row">
        <label id="elh_escenario_tipo_evento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_evento->caption() ?><?= $Page->tipo_evento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tipo_evento->cellAttributes() ?>>
<span id="el_escenario_tipo_evento">
<template id="tp_x_tipo_evento">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="escenario" data-field="x_tipo_evento" name="x_tipo_evento" id="x_tipo_evento"<?= $Page->tipo_evento->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_tipo_evento" class="ew-item-list"></div>
<?php $Page->tipo_evento->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<input type="hidden"
    is="selection-list"
    id="x_tipo_evento"
    name="x_tipo_evento"
    value="<?= HtmlEncode($Page->tipo_evento->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo_evento"
    data-target="dsl_x_tipo_evento"
    data-repeatcolumn="5"
    class="form-control<?= $Page->tipo_evento->isInvalidClass() ?>"
    data-table="escenario"
    data-field="x_tipo_evento"
    data-value-separator="<?= $Page->tipo_evento->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo_evento->editAttributes() ?>>
<?= $Page->tipo_evento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_evento->getErrorMessage() ?></div>
<?= $Page->tipo_evento->Lookup->getParamTag($Page, "p_x_tipo_evento") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->incidente->Visible) { // incidente ?>
    <div id="r_incidente" class="form-group row">
        <label id="elh_escenario_incidente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->incidente->caption() ?><?= $Page->incidente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->incidente->cellAttributes() ?>>
<span id="el_escenario_incidente">
<template id="tp_x_incidente">
    <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" data-table="escenario" data-field="x_incidente" name="x_incidente" id="x_incidente"<?= $Page->incidente->editAttributes() ?>>
        <label class="custom-control-label"></label>
    </div>
</template>
<div id="dsl_x_incidente" class="ew-item-list"></div>
<input type="hidden"
    is="selection-list"
    id="x_incidente"
    name="x_incidente"
    value="<?= HtmlEncode($Page->incidente->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_incidente"
    data-target="dsl_x_incidente"
    data-repeatcolumn="5"
    class="form-control<?= $Page->incidente->isInvalidClass() ?>"
    data-table="escenario"
    data-field="x_incidente"
    data-value-separator="<?= $Page->incidente->displayValueSeparatorAttribute() ?>"
    <?= $Page->incidente->editAttributes() ?>>
<?= $Page->incidente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->incidente->getErrorMessage() ?></div>
<?= $Page->incidente->Lookup->getParamTag($Page, "p_x_incidente") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pais_escenario->Visible) { // pais_escenario ?>
    <div id="r_pais_escenario" class="form-group row">
        <label id="elh_escenario_pais_escenario" for="x_pais_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pais_escenario->caption() ?><?= $Page->pais_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pais_escenario->cellAttributes() ?>>
<span id="el_escenario_pais_escenario">
    <select
        id="x_pais_escenario"
        name="x_pais_escenario"
        class="form-control ew-select<?= $Page->pais_escenario->isInvalidClass() ?>"
        data-select2-id="escenario_x_pais_escenario"
        data-table="escenario"
        data-field="x_pais_escenario"
        data-value-separator="<?= $Page->pais_escenario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pais_escenario->getPlaceHolder()) ?>"
        <?= $Page->pais_escenario->editAttributes() ?>>
        <?= $Page->pais_escenario->selectOptionListHtml("x_pais_escenario") ?>
    </select>
    <?= $Page->pais_escenario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pais_escenario->getErrorMessage() ?></div>
<?= $Page->pais_escenario->Lookup->getParamTag($Page, "p_x_pais_escenario") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='escenario_x_pais_escenario']"),
        options = { name: "x_pais_escenario", selectId: "escenario_x_pais_escenario", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.escenario.fields.pais_escenario.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_escenario->Visible) { // descripcion_escenario ?>
    <div id="r_descripcion_escenario" class="form-group row">
        <label id="elh_escenario_descripcion_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_escenario->caption() ?><?= $Page->descripcion_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_escenario->cellAttributes() ?>>
<span id="el_escenario_descripcion_escenario">
<?php $Page->descripcion_escenario->EditAttrs->appendClass("editor"); ?>
<textarea data-table="escenario" data-field="x_descripcion_escenario" name="x_descripcion_escenario" id="x_descripcion_escenario" cols="20" rows="4" placeholder="<?= HtmlEncode($Page->descripcion_escenario->getPlaceHolder()) ?>"<?= $Page->descripcion_escenario->editAttributes() ?> aria-describedby="x_descripcion_escenario_help"><?= $Page->descripcion_escenario->EditValue ?></textarea>
<?= $Page->descripcion_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_escenario->getErrorMessage() ?></div>
<script>
loadjs.ready(["fescenarioadd", "editor"], function() {
	ew.createEditor("fescenarioadd", "x_descripcion_escenario", 20, 4, <?= $Page->descripcion_escenario->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechaini_simulado->Visible) { // fechaini_simulado ?>
    <div id="r_fechaini_simulado" class="form-group row">
        <label id="elh_escenario_fechaini_simulado" for="x_fechaini_simulado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechaini_simulado->caption() ?><?= $Page->fechaini_simulado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechaini_simulado->cellAttributes() ?>>
<span id="el_escenario_fechaini_simulado">
<input type="<?= $Page->fechaini_simulado->getInputTextType() ?>" data-table="escenario" data-field="x_fechaini_simulado" data-format="109" name="x_fechaini_simulado" id="x_fechaini_simulado" placeholder="<?= HtmlEncode($Page->fechaini_simulado->getPlaceHolder()) ?>" value="<?= $Page->fechaini_simulado->EditValue ?>"<?= $Page->fechaini_simulado->editAttributes() ?> aria-describedby="x_fechaini_simulado_help">
<?= $Page->fechaini_simulado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechaini_simulado->getErrorMessage() ?></div>
<?php if (!$Page->fechaini_simulado->ReadOnly && !$Page->fechaini_simulado->Disabled && !isset($Page->fechaini_simulado->EditAttrs["readonly"]) && !isset($Page->fechaini_simulado->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fescenarioadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fescenarioadd", "x_fechaini_simulado", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafin_simulado->Visible) { // fechafin_simulado ?>
    <div id="r_fechafin_simulado" class="form-group row">
        <label id="elh_escenario_fechafin_simulado" for="x_fechafin_simulado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechafin_simulado->caption() ?><?= $Page->fechafin_simulado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafin_simulado->cellAttributes() ?>>
<span id="el_escenario_fechafin_simulado">
<input type="<?= $Page->fechafin_simulado->getInputTextType() ?>" data-table="escenario" data-field="x_fechafin_simulado" data-format="109" name="x_fechafin_simulado" id="x_fechafin_simulado" placeholder="<?= HtmlEncode($Page->fechafin_simulado->getPlaceHolder()) ?>" value="<?= $Page->fechafin_simulado->EditValue ?>"<?= $Page->fechafin_simulado->editAttributes() ?> aria-describedby="x_fechafin_simulado_help">
<?= $Page->fechafin_simulado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechafin_simulado->getErrorMessage() ?></div>
<?php if (!$Page->fechafin_simulado->ReadOnly && !$Page->fechafin_simulado->Disabled && !isset($Page->fechafin_simulado->EditAttrs["readonly"]) && !isset($Page->fechafin_simulado->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fescenarioadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fescenarioadd", "x_fechafin_simulado", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechaini_real->Visible) { // fechaini_real ?>
    <div id="r_fechaini_real" class="form-group row">
        <label id="elh_escenario_fechaini_real" for="x_fechaini_real" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechaini_real->caption() ?><?= $Page->fechaini_real->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechaini_real->cellAttributes() ?>>
<span id="el_escenario_fechaini_real">
<input type="<?= $Page->fechaini_real->getInputTextType() ?>" data-table="escenario" data-field="x_fechaini_real" data-format="109" name="x_fechaini_real" id="x_fechaini_real" placeholder="<?= HtmlEncode($Page->fechaini_real->getPlaceHolder()) ?>" value="<?= $Page->fechaini_real->EditValue ?>"<?= $Page->fechaini_real->editAttributes() ?> aria-describedby="x_fechaini_real_help">
<?= $Page->fechaini_real->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechaini_real->getErrorMessage() ?></div>
<?php if (!$Page->fechaini_real->ReadOnly && !$Page->fechaini_real->Disabled && !isset($Page->fechaini_real->EditAttrs["readonly"]) && !isset($Page->fechaini_real->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fescenarioadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fescenarioadd", "x_fechaini_real", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafinal_real->Visible) { // fechafinal_real ?>
    <div id="r_fechafinal_real" class="form-group row">
        <label id="elh_escenario_fechafinal_real" for="x_fechafinal_real" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechafinal_real->caption() ?><?= $Page->fechafinal_real->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafinal_real->cellAttributes() ?>>
<span id="el_escenario_fechafinal_real">
<input type="<?= $Page->fechafinal_real->getInputTextType() ?>" data-table="escenario" data-field="x_fechafinal_real" data-format="109" name="x_fechafinal_real" id="x_fechafinal_real" placeholder="<?= HtmlEncode($Page->fechafinal_real->getPlaceHolder()) ?>" value="<?= $Page->fechafinal_real->EditValue ?>"<?= $Page->fechafinal_real->editAttributes() ?> aria-describedby="x_fechafinal_real_help">
<?= $Page->fechafinal_real->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechafinal_real->getErrorMessage() ?></div>
<?php if (!$Page->fechafinal_real->ReadOnly && !$Page->fechafinal_real->Disabled && !isset($Page->fechafinal_real->EditAttrs["readonly"]) && !isset($Page->fechafinal_real->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fescenarioadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fescenarioadd", "x_fechafinal_real", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->image_escenario->Visible) { // image_escenario ?>
    <div id="r_image_escenario" class="form-group row">
        <label id="elh_escenario_image_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->image_escenario->caption() ?><?= $Page->image_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->image_escenario->cellAttributes() ?>>
<span id="el_escenario_image_escenario">
<div id="fd_x_image_escenario">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->image_escenario->title() ?>" data-table="escenario" data-field="x_image_escenario" name="x_image_escenario" id="x_image_escenario" lang="<?= CurrentLanguageID() ?>"<?= $Page->image_escenario->editAttributes() ?><?= ($Page->image_escenario->ReadOnly || $Page->image_escenario->Disabled) ? " disabled" : "" ?> aria-describedby="x_image_escenario_help">
        <label class="custom-file-label ew-file-label" for="x_image_escenario"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->image_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->image_escenario->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_image_escenario" id= "fn_x_image_escenario" value="<?= $Page->image_escenario->Upload->FileName ?>">
<input type="hidden" name="fa_x_image_escenario" id= "fa_x_image_escenario" value="0">
<input type="hidden" name="fs_x_image_escenario" id= "fs_x_image_escenario" value="65535">
<input type="hidden" name="fx_x_image_escenario" id= "fx_x_image_escenario" value="<?= $Page->image_escenario->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_image_escenario" id= "fm_x_image_escenario" value="<?= $Page->image_escenario->UploadMaxFileSize ?>">
</div>
<table id="ft_x_image_escenario" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("grupo", explode(",", $Page->getCurrentDetailTable())) && $grupo->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("grupo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "GrupoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("tareas", explode(",", $Page->getCurrentDetailTable())) && $tareas->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("tareas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "TareasGrid.php" ?>
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
    ew.addEventHandlers("escenario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("label#elh_escenario_icon_escenario").remove(),$("label#elh_escenario_nombre_escenario").remove(),$("label#elh_escenario_pais_escenario").remove(),$("label#elh_escenario_descripcion_escenario").remove(),$("label#elh_escenario_fechaini_simulado").remove(),$("label#elh_escenario_fechafin_simulado").remove(),$("label#elh_escenario_fechaini_real").remove(),$("label#elh_escenario_fechafinal_real").remove(),$("label#elh_escenario_image_escenario").remove(),$("label#elh_escenario_tipo_evento").remove(),$("label#elh_escenario_incidente").remove(),$("#dsl_x_tipo_evento").before("Categoría incidente"),$("#dsl_x_incidente").before("Tipo incidente"),$("#r_icon_escenario").hide(),$("h4").text("Nueva simulación");
});
</script>
