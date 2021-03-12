<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SubgrupoAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fsubgrupoadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fsubgrupoadd = currentForm = new ew.Form("fsubgrupoadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "subgrupo")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.subgrupo)
        ew.vars.tables.subgrupo = currentTable;
    fsubgrupoadd.addFields([
        ["id_grupo", [fields.id_grupo.visible && fields.id_grupo.required ? ew.Validators.required(fields.id_grupo.caption) : null], fields.id_grupo.isInvalid],
        ["imagen_subgrupo", [fields.imagen_subgrupo.visible && fields.imagen_subgrupo.required ? ew.Validators.fileRequired(fields.imagen_subgrupo.caption) : null], fields.imagen_subgrupo.isInvalid],
        ["nombre_subgrupo", [fields.nombre_subgrupo.visible && fields.nombre_subgrupo.required ? ew.Validators.required(fields.nombre_subgrupo.caption) : null], fields.nombre_subgrupo.isInvalid],
        ["descripcion_subgrupo", [fields.descripcion_subgrupo.visible && fields.descripcion_subgrupo.required ? ew.Validators.required(fields.descripcion_subgrupo.caption) : null], fields.descripcion_subgrupo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fsubgrupoadd,
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
    fsubgrupoadd.validate = function () {
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
    fsubgrupoadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsubgrupoadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fsubgrupoadd.lists.id_grupo = <?= $Page->id_grupo->toClientList($Page) ?>;
    loadjs.done("fsubgrupoadd");
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
<form name="fsubgrupoadd" id="fsubgrupoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="subgrupo">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "grupo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="grupo">
<input type="hidden" name="fk_id_grupo" value="<?= HtmlEncode($Page->id_grupo->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <div id="r_id_grupo" class="form-group row">
        <label id="elh_subgrupo_id_grupo" for="x_id_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_grupo->caption() ?><?= $Page->id_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_grupo->cellAttributes() ?>>
<?php if ($Page->id_grupo->getSessionValue() != "") { ?>
<span id="el_subgrupo_id_grupo">
<span<?= $Page->id_grupo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_grupo->getDisplayValue($Page->id_grupo->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_id_grupo" name="x_id_grupo" value="<?= HtmlEncode($Page->id_grupo->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_subgrupo_id_grupo">
    <select
        id="x_id_grupo"
        name="x_id_grupo"
        class="form-control ew-select<?= $Page->id_grupo->isInvalidClass() ?>"
        data-select2-id="subgrupo_x_id_grupo"
        data-table="subgrupo"
        data-field="x_id_grupo"
        data-value-separator="<?= $Page->id_grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->id_grupo->getPlaceHolder()) ?>"
        <?= $Page->id_grupo->editAttributes() ?>>
        <?= $Page->id_grupo->selectOptionListHtml("x_id_grupo") ?>
    </select>
    <?= $Page->id_grupo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->id_grupo->getErrorMessage() ?></div>
<?= $Page->id_grupo->Lookup->getParamTag($Page, "p_x_id_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='subgrupo_x_id_grupo']"),
        options = { name: "x_id_grupo", selectId: "subgrupo_x_id_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.subgrupo.fields.id_grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
    <div id="r_imagen_subgrupo" class="form-group row">
        <label id="elh_subgrupo_imagen_subgrupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imagen_subgrupo->caption() ?><?= $Page->imagen_subgrupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->imagen_subgrupo->cellAttributes() ?>>
<span id="el_subgrupo_imagen_subgrupo">
<div id="fd_x_imagen_subgrupo">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->imagen_subgrupo->title() ?>" data-table="subgrupo" data-field="x_imagen_subgrupo" name="x_imagen_subgrupo" id="x_imagen_subgrupo" lang="<?= CurrentLanguageID() ?>"<?= $Page->imagen_subgrupo->editAttributes() ?><?= ($Page->imagen_subgrupo->ReadOnly || $Page->imagen_subgrupo->Disabled) ? " disabled" : "" ?> aria-describedby="x_imagen_subgrupo_help">
        <label class="custom-file-label ew-file-label" for="x_imagen_subgrupo"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->imagen_subgrupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->imagen_subgrupo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_imagen_subgrupo" id= "fn_x_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->Upload->FileName ?>">
<input type="hidden" name="fa_x_imagen_subgrupo" id= "fa_x_imagen_subgrupo" value="0">
<input type="hidden" name="fs_x_imagen_subgrupo" id= "fs_x_imagen_subgrupo" value="100">
<input type="hidden" name="fx_x_imagen_subgrupo" id= "fx_x_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_imagen_subgrupo" id= "fm_x_imagen_subgrupo" value="<?= $Page->imagen_subgrupo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_imagen_subgrupo" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
    <div id="r_nombre_subgrupo" class="form-group row">
        <label id="elh_subgrupo_nombre_subgrupo" for="x_nombre_subgrupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_subgrupo->caption() ?><?= $Page->nombre_subgrupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nombre_subgrupo->cellAttributes() ?>>
<span id="el_subgrupo_nombre_subgrupo">
<input type="<?= $Page->nombre_subgrupo->getInputTextType() ?>" data-table="subgrupo" data-field="x_nombre_subgrupo" name="x_nombre_subgrupo" id="x_nombre_subgrupo" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nombre_subgrupo->getPlaceHolder()) ?>" value="<?= $Page->nombre_subgrupo->EditValue ?>"<?= $Page->nombre_subgrupo->editAttributes() ?> aria-describedby="x_nombre_subgrupo_help">
<?= $Page->nombre_subgrupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_subgrupo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_subgrupo->Visible) { // descripcion_subgrupo ?>
    <div id="r_descripcion_subgrupo" class="form-group row">
        <label id="elh_subgrupo_descripcion_subgrupo" for="x_descripcion_subgrupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_subgrupo->caption() ?><?= $Page->descripcion_subgrupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_subgrupo->cellAttributes() ?>>
<span id="el_subgrupo_descripcion_subgrupo">
<textarea data-table="subgrupo" data-field="x_descripcion_subgrupo" name="x_descripcion_subgrupo" id="x_descripcion_subgrupo" cols="30" rows="2" placeholder="<?= HtmlEncode($Page->descripcion_subgrupo->getPlaceHolder()) ?>"<?= $Page->descripcion_subgrupo->editAttributes() ?> aria-describedby="x_descripcion_subgrupo_help"><?= $Page->descripcion_subgrupo->EditValue ?></textarea>
<?= $Page->descripcion_subgrupo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_subgrupo->getErrorMessage() ?></div>
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
    ew.addEventHandlers("subgrupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("label#elh_subgrupo_nombre_subgrupo").remove(),$("label#elh_subgrupo_id_grupo").remove(),$("label#elh_subgrupo_descripcion_subgrupo").remove(),$("label#elh_subgrupo_imagen_subgrupo").remove(),$("label#elh_subgrupo_participante").remove(),$("label#elh_subgrupo_exon_subgrupo").remove(),$("#r_id_escenario").removeClass("form-group row").addClass("form-group"),$("#r_id_grupo").removeClass("form-group row").addClass("form-group"),$("#r_nombre_subgrupo").removeClass("form-group row").addClass("form-group"),$("#r_imagen_subgrupo").removeClass("form-group row").addClass("form-group"),$("#r_participante").removeClass("form-group row").addClass("form-group"),$("#r_descripcion_subgrupo").removeClass("form-group row").addClass("form-group"),$("#btn-cancel").remove(),$("h4").text("Nuevo subgrupo");
});
</script>
