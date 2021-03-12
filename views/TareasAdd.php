<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ftareasadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ftareasadd = currentForm = new ew.Form("ftareasadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "tareas")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.tareas)
        ew.vars.tables.tareas = currentTable;
    ftareasadd.addFields([
        ["id_escenario", [fields.id_escenario.visible && fields.id_escenario.required ? ew.Validators.required(fields.id_escenario.caption) : null, ew.Validators.integer], fields.id_escenario.isInvalid],
        ["id_grupo", [fields.id_grupo.visible && fields.id_grupo.required ? ew.Validators.required(fields.id_grupo.caption) : null], fields.id_grupo.isInvalid],
        ["titulo_tarea", [fields.titulo_tarea.visible && fields.titulo_tarea.required ? ew.Validators.required(fields.titulo_tarea.caption) : null], fields.titulo_tarea.isInvalid],
        ["descripcion_tarea", [fields.descripcion_tarea.visible && fields.descripcion_tarea.required ? ew.Validators.required(fields.descripcion_tarea.caption) : null], fields.descripcion_tarea.isInvalid],
        ["fechainireal_tarea", [fields.fechainireal_tarea.visible && fields.fechainireal_tarea.required ? ew.Validators.required(fields.fechainireal_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechainireal_tarea.isInvalid],
        ["fechafin_tarea", [fields.fechafin_tarea.visible && fields.fechafin_tarea.required ? ew.Validators.required(fields.fechafin_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechafin_tarea.isInvalid],
        ["fechainisimulado_tarea", [fields.fechainisimulado_tarea.visible && fields.fechainisimulado_tarea.required ? ew.Validators.required(fields.fechainisimulado_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechainisimulado_tarea.isInvalid],
        ["fechafinsimulado_tarea", [fields.fechafinsimulado_tarea.visible && fields.fechafinsimulado_tarea.required ? ew.Validators.required(fields.fechafinsimulado_tarea.caption) : null, ew.Validators.datetime(109)], fields.fechafinsimulado_tarea.isInvalid],
        ["id_tarearelacion", [fields.id_tarearelacion.visible && fields.id_tarearelacion.required ? ew.Validators.required(fields.id_tarearelacion.caption) : null], fields.id_tarearelacion.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ftareasadd,
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
    ftareasadd.validate = function () {
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
    ftareasadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftareasadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ftareasadd.lists.id_grupo = <?= $Page->id_grupo->toClientList($Page) ?>;
    ftareasadd.lists.id_tarearelacion = <?= $Page->id_tarearelacion->toClientList($Page) ?>;
    loadjs.done("ftareasadd");
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
<form name="ftareasadd" id="ftareasadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tareas">
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
        <label id="elh_tareas_id_escenario" for="x_id_escenario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_escenario->caption() ?><?= $Page->id_escenario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_escenario->cellAttributes() ?>>
<?php if ($Page->id_escenario->getSessionValue() != "") { ?>
<span id="el_tareas_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_escenario->getDisplayValue($Page->id_escenario->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_id_escenario" name="x_id_escenario" value="<?= HtmlEncode($Page->id_escenario->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_tareas_id_escenario">
<input type="<?= $Page->id_escenario->getInputTextType() ?>" data-table="tareas" data-field="x_id_escenario" name="x_id_escenario" id="x_id_escenario" size="30" placeholder="<?= HtmlEncode($Page->id_escenario->getPlaceHolder()) ?>" value="<?= $Page->id_escenario->EditValue ?>"<?= $Page->id_escenario->editAttributes() ?> aria-describedby="x_id_escenario_help">
<?= $Page->id_escenario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_escenario->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <div id="r_id_grupo" class="form-group row">
        <label id="elh_tareas_id_grupo" for="x_id_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_grupo->caption() ?><?= $Page->id_grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_grupo->cellAttributes() ?>>
<span id="el_tareas_id_grupo">
    <select
        id="x_id_grupo"
        name="x_id_grupo"
        class="form-control ew-select<?= $Page->id_grupo->isInvalidClass() ?>"
        data-select2-id="tareas_x_id_grupo"
        data-table="tareas"
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
    var el = document.querySelector("select[data-select2-id='tareas_x_id_grupo']"),
        options = { name: "x_id_grupo", selectId: "tareas_x_id_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.tareas.fields.id_grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
    <div id="r_titulo_tarea" class="form-group row">
        <label id="elh_tareas_titulo_tarea" for="x_titulo_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titulo_tarea->caption() ?><?= $Page->titulo_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->titulo_tarea->cellAttributes() ?>>
<span id="el_tareas_titulo_tarea">
<input type="<?= $Page->titulo_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_titulo_tarea" name="x_titulo_tarea" id="x_titulo_tarea" size="50" maxlength="50" placeholder="<?= HtmlEncode($Page->titulo_tarea->getPlaceHolder()) ?>" value="<?= $Page->titulo_tarea->EditValue ?>"<?= $Page->titulo_tarea->editAttributes() ?> aria-describedby="x_titulo_tarea_help">
<?= $Page->titulo_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titulo_tarea->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_tarea->Visible) { // descripcion_tarea ?>
    <div id="r_descripcion_tarea" class="form-group row">
        <label id="elh_tareas_descripcion_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_tarea->caption() ?><?= $Page->descripcion_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->descripcion_tarea->cellAttributes() ?>>
<span id="el_tareas_descripcion_tarea">
<?php $Page->descripcion_tarea->EditAttrs->appendClass("editor"); ?>
<textarea data-table="tareas" data-field="x_descripcion_tarea" name="x_descripcion_tarea" id="x_descripcion_tarea" cols="50" rows="4" placeholder="<?= HtmlEncode($Page->descripcion_tarea->getPlaceHolder()) ?>"<?= $Page->descripcion_tarea->editAttributes() ?> aria-describedby="x_descripcion_tarea_help"><?= $Page->descripcion_tarea->EditValue ?></textarea>
<?= $Page->descripcion_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_tarea->getErrorMessage() ?></div>
<script>
loadjs.ready(["ftareasadd", "editor"], function() {
	ew.createEditor("ftareasadd", "x_descripcion_tarea", 50, 4, <?= $Page->descripcion_tarea->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
    <div id="r_fechainireal_tarea" class="form-group row">
        <label id="elh_tareas_fechainireal_tarea" for="x_fechainireal_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechainireal_tarea->caption() ?><?= $Page->fechainireal_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechainireal_tarea->cellAttributes() ?>>
<span id="el_tareas_fechainireal_tarea">
<input type="<?= $Page->fechainireal_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainireal_tarea" data-format="109" name="x_fechainireal_tarea" id="x_fechainireal_tarea" placeholder="<?= HtmlEncode($Page->fechainireal_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechainireal_tarea->EditValue ?>"<?= $Page->fechainireal_tarea->editAttributes() ?> aria-describedby="x_fechainireal_tarea_help">
<?= $Page->fechainireal_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechainireal_tarea->getErrorMessage() ?></div>
<?php if (!$Page->fechainireal_tarea->ReadOnly && !$Page->fechainireal_tarea->Disabled && !isset($Page->fechainireal_tarea->EditAttrs["readonly"]) && !isset($Page->fechainireal_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasadd", "x_fechainireal_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
    <div id="r_fechafin_tarea" class="form-group row">
        <label id="elh_tareas_fechafin_tarea" for="x_fechafin_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechafin_tarea->caption() ?><?= $Page->fechafin_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafin_tarea->cellAttributes() ?>>
<span id="el_tareas_fechafin_tarea">
<input type="<?= $Page->fechafin_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafin_tarea" data-format="109" name="x_fechafin_tarea" id="x_fechafin_tarea" placeholder="<?= HtmlEncode($Page->fechafin_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechafin_tarea->EditValue ?>"<?= $Page->fechafin_tarea->editAttributes() ?> aria-describedby="x_fechafin_tarea_help">
<?= $Page->fechafin_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechafin_tarea->getErrorMessage() ?></div>
<?php if (!$Page->fechafin_tarea->ReadOnly && !$Page->fechafin_tarea->Disabled && !isset($Page->fechafin_tarea->EditAttrs["readonly"]) && !isset($Page->fechafin_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasadd", "x_fechafin_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
    <div id="r_fechainisimulado_tarea" class="form-group row">
        <label id="elh_tareas_fechainisimulado_tarea" for="x_fechainisimulado_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechainisimulado_tarea->caption() ?><?= $Page->fechainisimulado_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
<span id="el_tareas_fechainisimulado_tarea">
<input type="<?= $Page->fechainisimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechainisimulado_tarea" data-format="109" name="x_fechainisimulado_tarea" id="x_fechainisimulado_tarea" placeholder="<?= HtmlEncode($Page->fechainisimulado_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechainisimulado_tarea->EditValue ?>"<?= $Page->fechainisimulado_tarea->editAttributes() ?> aria-describedby="x_fechainisimulado_tarea_help">
<?= $Page->fechainisimulado_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechainisimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Page->fechainisimulado_tarea->ReadOnly && !$Page->fechainisimulado_tarea->Disabled && !isset($Page->fechainisimulado_tarea->EditAttrs["readonly"]) && !isset($Page->fechainisimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasadd", "x_fechainisimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
    <div id="r_fechafinsimulado_tarea" class="form-group row">
        <label id="elh_tareas_fechafinsimulado_tarea" for="x_fechafinsimulado_tarea" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fechafinsimulado_tarea->caption() ?><?= $Page->fechafinsimulado_tarea->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
<span id="el_tareas_fechafinsimulado_tarea">
<input type="<?= $Page->fechafinsimulado_tarea->getInputTextType() ?>" data-table="tareas" data-field="x_fechafinsimulado_tarea" data-format="109" name="x_fechafinsimulado_tarea" id="x_fechafinsimulado_tarea" placeholder="<?= HtmlEncode($Page->fechafinsimulado_tarea->getPlaceHolder()) ?>" value="<?= $Page->fechafinsimulado_tarea->EditValue ?>"<?= $Page->fechafinsimulado_tarea->editAttributes() ?> aria-describedby="x_fechafinsimulado_tarea_help">
<?= $Page->fechafinsimulado_tarea->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fechafinsimulado_tarea->getErrorMessage() ?></div>
<?php if (!$Page->fechafinsimulado_tarea->ReadOnly && !$Page->fechafinsimulado_tarea->Disabled && !isset($Page->fechafinsimulado_tarea->EditAttrs["readonly"]) && !isset($Page->fechafinsimulado_tarea->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftareasadd", "datetimepicker"], function() {
    ew.createDateTimePicker("ftareasadd", "x_fechafinsimulado_tarea", {"ignoreReadonly":true,"useCurrent":false,"format":109});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id_tarearelacion->Visible) { // id_tarearelacion ?>
    <div id="r_id_tarearelacion" class="form-group row">
        <label id="elh_tareas_id_tarearelacion" for="x_id_tarearelacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_tarearelacion->caption() ?><?= $Page->id_tarearelacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_tarearelacion->cellAttributes() ?>>
<span id="el_tareas_id_tarearelacion">
<div class="input-group ew-lookup-list" aria-describedby="x_id_tarearelacion_help">
    <div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_id_tarearelacion"><?= EmptyValue(strval($Page->id_tarearelacion->ViewValue)) ? $Language->phrase("PleaseSelect") : $Page->id_tarearelacion->ViewValue ?></div>
    <div class="input-group-append">
        <button type="button" title="<?= HtmlEncode(str_replace("%s", RemoveHtml($Page->id_tarearelacion->caption()), $Language->phrase("LookupLink", true))) ?>" class="ew-lookup-btn btn btn-default"<?= ($Page->id_tarearelacion->ReadOnly || $Page->id_tarearelacion->Disabled) ? " disabled" : "" ?> onclick="ew.modalLookupShow({lnk:this,el:'x_id_tarearelacion',m:0,n:10});"><i class="fas fa-search ew-icon"></i></button>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->id_tarearelacion->getErrorMessage() ?></div>
<?= $Page->id_tarearelacion->getCustomMessage() ?>
<?= $Page->id_tarearelacion->Lookup->getParamTag($Page, "p_x_id_tarearelacion") ?>
<input type="hidden" is="selection-list" data-table="tareas" data-field="x_id_tarearelacion" data-type="text" data-multiple="0" data-lookup="1" data-value-separator="<?= $Page->id_tarearelacion->displayValueSeparatorAttribute() ?>" name="x_id_tarearelacion" id="x_id_tarearelacion" value="<?= $Page->id_tarearelacion->CurrentValue ?>"<?= $Page->id_tarearelacion->editAttributes() ?>>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("mensajes", explode(",", $Page->getCurrentDetailTable())) && $mensajes->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("mensajes", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "MensajesGrid.php" ?>
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
    ew.addEventHandlers("tareas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("label#elh_tareas_titulo_tarea").remove(),$("label#elh_tareas_id_tarea").remove(),$("label#elh_tareas_descripcion_tarea").remove(),$("label#elh_tareas_fechainisimulado_tarea").remove(),$("label#elh_tareas_fechafinsimulado_tarea").remove(),$("label#elh_tareas_fechainireal_tarea").remove(),$("label#elh_tareas_fechafin_tarea").remove(),$("label#elh_tareas_archivo").remove(),$("label#elh_tareas_medios").remove(),$("label#elh_tareas_id_grupo").remove(),$("label#elh_tareas_id_tarearelacion").remove(),$("h4").text("Nueva Tarea");
});
</script>
