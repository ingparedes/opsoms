<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fgrupoadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fgrupoadd = currentForm = new ew.Form("fgrupoadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "grupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.grupo)
        ew.vars.tables.grupo = currentTable;
    fgrupoadd.addFields([
        ["id_escenario", [fields.id_escenario.visible && fields.id_escenario.required ? ew.Validators.required(fields.id_escenario.caption) : null], fields.id_escenario.isInvalid],
        ["imgen_grupo", [fields.imgen_grupo.visible && fields.imgen_grupo.required ? ew.Validators.fileRequired(fields.imgen_grupo.caption) : null], fields.imgen_grupo.isInvalid],
        ["nombre_grupo", [fields.nombre_grupo.visible && fields.nombre_grupo.required ? ew.Validators.required(fields.nombre_grupo.caption) : null], fields.nombre_grupo.isInvalid],
        ["descripcion_grupo", [fields.descripcion_grupo.visible && fields.descripcion_grupo.required ? ew.Validators.required(fields.descripcion_grupo.caption) : null], fields.descripcion_grupo.isInvalid],
        ["color", [fields.color.visible && fields.color.required ? ew.Validators.required(fields.color.caption) : null], fields.color.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fgrupoadd,
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
    fgrupoadd.validate = function () {
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
    fgrupoadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fgrupoadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fgrupoadd.lists.id_escenario = <?= $Page->id_escenario->toClientList($Page) ?>;
    fgrupoadd.lists.color = <?= $Page->color->toClientList($Page) ?>;
    loadjs.done("fgrupoadd");
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
<form name="fgrupoadd" id="fgrupoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="grupo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "escenario") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="escenario">
<input type="hidden" name="fk_id_escenario" value="<?= HtmlEncode($Page->id_escenario->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <div id="r_id_escenario" class="form-group row">
        <label id="elh_grupo_id_escenario" for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_escenario->caption() ?><?= $Page->id_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
<?php if ($Page->id_escenario->getSessionValue() != "") { ?>
<span id="el_grupo_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_escenario->getDisplayValue($Page->id_escenario->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_id_escenario" name="x_id_escenario" value="<?= HtmlEncode($Page->id_escenario->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_grupo_id_escenario">
    <select
        id="x_id_escenario"
        name="x_id_escenario"
        class="form-control ew-select<?= $Page->id_escenario->isInvalidClass() ?>"
        data-select2-id="grupo_x_id_escenario"
        data-table="grupo"
        data-field="x_id_escenario"
        data-value-separator="<?= $Page->id_escenario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>"
        <?= $Page->id_escenario->editAttributes() ?>>
        <?= $Page->id_escenario->selectOptionListHtml("x_id_escenario") ?>
    </select>
    <?= $Page->id_escenario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage() ?></div>
<?= $Page->id_escenario->Lookup->getParamTag($Page, "p_x_id_escenario") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='grupo_x_id_escenario']"),
        options = { name: "x_id_escenario", selectId: "grupo_x_id_escenario", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.grupo.fields.id_escenario.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
    <div id="r_imgen_grupo" class="form-group row">
        <label id="elh_grupo_imgen_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imgen_grupo->caption() ?><?= $Page->imgen_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->imgen_grupo->cellAttributes() ?>>
<span id="el_grupo_imgen_grupo">
<div id="fd_x_imgen_grupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imgen_grupo->title() ?>" data-table="grupo" data-field="x_imgen_grupo" name="x_imgen_grupo" id="x_imgen_grupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imgen_grupo->editAttributes() ?><?= ($Page->imgen_grupo->ReadOnly || $Page->imgen_grupo->Disabled) ? " disabled" : "" ?> aria-describedby="x_imgen_grupo_help">
        <label class="custom-file-label ew-file-label" for="x_imgen_grupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->imgen_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->imgen_grupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_imgen_grupo" id= "fn_x_imgen_grupo" value="<?= $Page->imgen_grupo->Upload->FileName ?>">
<input type="hidden" name="fa_x_imgen_grupo" id= "fa_x_imgen_grupo" value="0">
<input type="hidden" name="fs_x_imgen_grupo" id= "fs_x_imgen_grupo" value="30">
<input type="hidden" name="fx_x_imgen_grupo" id= "fx_x_imgen_grupo" value="<?= $Page->imgen_grupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_imgen_grupo" id= "fm_x_imgen_grupo" value="<?= $Page->imgen_grupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_imgen_grupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
    <div id="r_nombre_grupo" class="form-group row">
        <label id="elh_grupo_nombre_grupo" for="x_nombre_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_grupo->caption() ?><?= $Page->nombre_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombre_grupo->cellAttributes() ?>>
<span id="el_grupo_nombre_grupo">
<input type="<?= $Page->nombre_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_nombre_grupo" name="x_nombre_grupo" id="x_nombre_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_grupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_grupo->EditValue ?>"<?= $Page->nombre_grupo->editAttributes() ?> aria-describedby="x_nombre_grupo_help">
<?= $Page->nombre_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_grupo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_grupo->Visible) { // descripcion_grupo ?>
    <div id="r_descripcion_grupo" class="form-group row">
        <label id="elh_grupo_descripcion_grupo" for="x_descripcion_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_grupo->caption() ?><?= $Page->descripcion_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_grupo->cellAttributes() ?>>
<span id="el_grupo_descripcion_grupo">
<input type="<?= $Page->descripcion_grupo->getInputTextType() ?>" data-table="grupo" data-field="x_descripcion_grupo" name="x_descripcion_grupo" id="x_descripcion_grupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->descripcion_grupo->getPlaceHolder()) ?>" value="<?= $Page->descripcion_grupo->EditValue ?>"<?= $Page->descripcion_grupo->editAttributes() ?> aria-describedby="x_descripcion_grupo_help">
<?= $Page->descripcion_grupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_grupo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <div id="r_color" class="form-group row">
        <label id="elh_grupo_color" for="x_color" class="<?= $Page->LeftColumnClass ?>"><?= $Page->color->caption() ?><?= $Page->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->color->cellAttributes() ?>>
<span id="el_grupo_color">
    <select
        id="x_color"
        name="x_color"
        class="form-control ew-select<?= $Page->color->isInvalidClass() ?>"
        data-select2-id="grupo_x_color"
        data-table="grupo"
        data-field="x_color"
        data-value-separator="<?= $Page->color->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->color->getPlaceHolder()) ?>"
        <?= $Page->color->editAttributes() ?>>
        <?= $Page->color->selectOptionListHtml("x_color") ?>
    </select>
    <?= $Page->color->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->color->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='grupo_x_color']"),
        options = { name: "x_color", selectId: "grupo_x_color", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.grupo.fields.color.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.grupo.fields.color.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("subgrupo", explode(",", $Page->getCurrentDetailTable())) && $subgrupo->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("subgrupo", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "SubgrupoGrid.php" ?>
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
    ew.addEventHandlers("grupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("label#elh_grupo_nombre_grupo").remove(),$("label#elh_grupo_descripcion_grupo").remove(),$("label#elh_grupo_imgen_grupo").remove(),$("label#elh_grupo_id_escenario").remove(),$("label#elh_grupo_color").remove(),$("label#elh_grupo_participante").remove(),$("label#elh_grupo_excon_grupo").remove(),$("h4").text("Nuevo grupo");
});
</script>
